<?php

namespace App\Payments;

use App\Mail\AdminNewOrderMail;
use App\Mail\CustomerNewOrderMail;
use Illuminate\Support\Facades\Mail;
use Lunar\Admin\Models\Staff;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Facades\DB;
use Lunar\Models\Discount;
use Lunar\Models\OrderLine;
use Lunar\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Lunar\PaymentTypes\AbstractPayment;
use Illuminate\Support\Str;
use App\Models\ExtendLunarOrder;
use GuzzleHttp\Exception\RequestException;
use Lunar\Facades\CartSession;
use Lunar\Models\Order;

class WorldpayPayment extends AbstractPayment
{
    protected Client $http;
    protected $authHeader;
    protected $acceptHeader;
    protected $contentType;
    protected $merchantEntity;
    protected $transactionReference;
    protected $cardType;
    protected $cardLast4Digits;

    public function setConfig(array $config): static
    {
        $this->config = $config;

        $baseUrl = rtrim($config['base_url'], '/');
        $username = $config['username'];
        $password = $config['password'];

        $this->authHeader = 'Basic ' . base64_encode("{$username}:{$password}");
        $this->acceptHeader = $config['accept_header'];
        $this->contentType = $config['content_type_header'];
        $this->merchantEntity = $config['merchant_entity'];

        $this->http = new Client([
            'base_uri' => $baseUrl,
            'timeout' => 15,
        ]);

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config ?? [];
    }

    public function initiateHostedPaymentPage()
    {
        $this->cart ??= CartSession::current();
        $cartTotal = $this->cart->total;

        $this->order = $this->cart->order ?? $this->cart->createOrder();

        $transactionReference = time() . '-' . Str::random(6);
        $wpCorrelationId = Str::uuid()->toString();

        $wpMeta = [
            'status' => 'initiated',
            'created_at' => now()->toDateTimeString(),
            'wp_correlation_id' => $wpCorrelationId,
        ];

        $this->order->update([
            'worldpay_meta' => $wpMeta,
            'transaction_reference' => $transactionReference,
            'status' => 'awaiting-payment',
        ]);

        $payload = [
            'transactionReference' => $transactionReference,
            'merchant' => ['entity' => $this->merchantEntity],
            'narrative' => ['line1' => 'FOXERGO Shop'],
            'value' => [
                'amount' => intval($cartTotal->value),
                'currency' => 'GBP',
            ],
            // 'threeDS' => [
            //     'type' => 'disabled',
            // ],
            'resultURLs' => [
                'successURL' => route('checkout.finalize'),
                'errorURL'   => route('checkout.view'),
                'failureURL' => route('checkout.view'),
                'cancelURL'  => route('checkout.view'),
                'expiryURL'  => route('checkout.view'),
            ],
        ];

        try {
            $res = $this->http->post('/payment_pages', [
                'headers' => [
                    'Authorization' => $this->authHeader,
                    'Accept' => $this->acceptHeader,
                    'Content-Type' => $this->contentType,
                    'WP-CorrelationId' => $wpCorrelationId,
                ],
                'json' => $payload,
            ]);

            $body = json_decode((string)$res->getBody(), true);
            Log::info('Worldpay HPP create response', ['order' => $this->order->id, 'body' => $body]);

            $redirectUrl = data_get($body, 'url');
            $lookupHref = data_get($body, '_links.self.href');

            if (!$redirectUrl || !$lookupHref) {
                Log::error('Worldpay HPP create error: Missing redirect or lookup URL', ['order' => $this->order->id, 'body' => $body]);
                return redirect()->route('checkout.view')->with('error', 'Invalid response from Worldpay (missing URLs).');
            }

            $meta = $this->order->worldpay_meta ?? [];
            if (!is_array($meta)) $meta = (array)$meta;
            $meta = array_merge($meta, [
                'response' => $body,
                'redirect_url' => $redirectUrl,
                'lookup_href' => $lookupHref,
                'status' => 'awaiting-payment',
                'updated_at' => now()->toDateTimeString(),
            ]);

            $this->order->update(['worldpay_meta' => $meta, 'status' => 'awaiting-payment']);

            session([
                'worldpay_order_id' => $this->order->id,
                'worldpay_transaction_reference' => $transactionReference,
            ]);

            return redirect()->away($redirectUrl);
        } catch (RequestException $e) {
            Log::error('Worldpay HPP create error', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string)$e->getResponse()->getBody() : null,
            ]);

            $meta = $this->order->fresh()->worldpay_meta ?? [];
            if (!is_array($meta)) $meta = (array)$meta;
            $meta = array_merge($meta, [
                'status' => 'failed_to_initiate',
                'error' => $e->hasResponse() ? json_decode((string)$e->getResponse()->getBody(), true) : $e->getMessage(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            $this->order->update(['worldpay_meta' => $meta]);

            return redirect()->route('checkout.view')->with('error', 'Payment initiation failed.');
        }
    }

    public function verifyAndFinalizePayment()
    {

        $orderId = session('worldpay_order_id');
        if (! $orderId) {
            Log::warning('Worldpay: missing order id in session during finalize');
            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Order session not found.']);
        }

        $order = ExtendLunarOrder::find($orderId);
        Log::info('Worldpay finalize payment for order', ['order_id' => $order]);
        if (! $order) {
            Log::warning('Worldpay: missing order for session', ['order_id' => $orderId]);
            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Order not found.']);
        }

        $lookupHref = data_get($order->worldpay_meta, 'lookup_href');
        if (! $lookupHref) {
            Log::error('Worldpay: lookup href missing', ['order_id' => $order->id, 'worldpay_meta' => $order->worldpay_meta]);
            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Lookup URL not available.']);
        }

        $maxAttempts = 5;
        $delay = 1;
        $body = [];

        for ($i = 1; $i <= $maxAttempts; $i++) {
            try {
                $res = $this->http->get($lookupHref, [
                    'headers' => [
                        'Authorization' => $this->authHeader,
                    ],
                    'http_errors' => false,
                    'timeout' => 10,
                ]);

                $status = $res->getStatusCode();
                $raw = (string)$res->getBody();
                $body = json_decode($raw, true) ?: [];

                $payments = data_get($body, '_embedded.payments', []);
                if ($status === 200 && !empty($payments) && is_array($payments)) {
                    $payment = $payments[0];

                    $lastEvent = strtolower(data_get($payment, 'lastEvent'));

                    if ($lastEvent === 'authorizationrequested') {
                        Log::info('Worldpay payment authorization not yet completed', ['order_id' => $order->id, 'last_event' => $lastEvent]);
                        sleep($delay);
                        $delay *= 2;
                        continue;
                    }

                    $links = $this->flattenLinks(data_get($payment, '_links', []));
                    $meta = (array)$order->worldpay_meta;
                    $meta['worldpay_links'] = array_merge($meta['worldpay_links'] ?? [], $links);
                    $meta['lookup_response'] = $body;
                    $meta['status'] = 'awaiting-finalize';
                    $order->update(['worldpay_meta' => $meta]);

                    $this->cardType = data_get($payment, 'paymentInstrument.card.brand');
                    $this->cardLast4Digits = data_get($payment, 'paymentInstrument.card.number.last4Digits');
                    $this->transactionReference = $order->transaction_reference;

                    Log::info('Worldpay lookup confirmed payment', ['order_id' => $order->id, 'payment' => $payment]);

                    Log::info('Worldpay payment last event', ['order_id' => $order->id, 'last_event' => $lastEvent]);
                    if (Str::contains($lastEvent, 'settlementrequested') || Str::contains($lastEvent, 'settlementrequestsubmitted') || Str::contains($lastEvent, 'authorizationsucceeded') || Str::contains($lastEvent, 'authorized')) {
                        $this->createOrUpdateTransaction($order, 'intent', $order->transaction_reference, (int)data_get($payment, 'value.amount', 0), $payment);

                        Log::info('Worldpay authorization event processed', ['order_id' => $order->id]);

                        $authResp = $this->authorize();
                        if (! $authResp->success) {
                            Log::warning('Worldpay authorize failed', ['order_id' => $order->id, 'auth' => $authResp]);
                            $meta = (array)$order->worldpay_meta;
                            $meta['status'] = 'authorize_failed';
                            $order->update(['worldpay_meta' => $meta, 'status' => 'failed']);
                            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Authorization failed.']);
                        }

                        $meta = (array)$order->worldpay_meta;
                        $meta['status'] = 'success';
                        $meta['authorized_at'] = now()->toDateTimeString();
                        $order = Order::find($order->id);
                        $order->update(['worldpay_meta' => $meta, 'placed_at' => now(), 'status' => 'awaiting-payment']);

                        Log::info('Worldpay payment completed', ['order_id' => $order->id, 'order' => $order]);

                        return redirect()->route('checkout-success.view')->with(['success' => true, 'message' => 'Payment captured and order placed.']);
                    }

                    break;
                }

                sleep($delay);
                $delay *= 2;
            } catch (\Throwable $e) {
                Log::error('Worldpay lookup request failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                sleep($delay);
                $delay *= 2;
            }
        }
    }

    protected function createOrUpdateTransaction($order, string $type, ?string $reference, int $amount, $metaPayload = null)
    {
        $transaction = $order->transactions()
            ->where('driver', 'worldpay')
            ->where('type', $type)
            ->where('reference', $reference)
            ->first();

        if ($transaction) {
            $transaction->update([
                'amount' => $amount,
                'success' => true,
                'status' => $type,
                'meta' => array_merge((array)$transaction->meta, ['worldpay' => $metaPayload]),
            ]);
            return $transaction;
        }

        return $order->transactions()->create([
            'parent_transaction_id' => null,
            'type' => $type,
            'driver' => 'worldpay',
            'amount' => $amount,
            'reference' => $reference ?? Str::uuid()->toString(),
            'status' => 'intent',
            'card_type' => $this->cardType ?? 'unknown',
            'last_four' => $this->cardLast4Digits ?? 'unknown',
            'success' => true,
            'meta' => ['worldpay' => $metaPayload],
        ]);
    }

    public function refund(Transaction|\Lunar\Models\Contracts\Transaction $transaction, int $amount = 0, $notes = null): PaymentRefund
    {
        return new PaymentRefund(success: false, message: 'Not implemented');
    }

    public function flattenLinks(array $links): array
    {
        $out = [];
        foreach ($links as $key => $v) {
            $href = null;
            if (is_string($v)) {
                $href = $v;
            } elseif (is_array($v) && isset($v['href'])) {
                if (is_string($v['href'])) {
                    $href = $v['href'];
                } elseif (is_array($v['href'])) {
                    $flat = Arr::flatten($v['href']);
                    foreach ($flat as $candidate) {
                        if (is_string($candidate) && trim($candidate) !== '') {
                            $href = $candidate;
                            break;
                        }
                    }
                }
            }

            if ($href) $out[$key] = $href;
        }
        return $out;
    }

    public function authorize(): PaymentAuthorize
    {
        $this->order ??= ExtendLunarOrder::find(session('worldpay_order_id'));

        try {
            return new PaymentAuthorize(success: true, message: 'Authorized', orderId: $this->order->id, paymentType: 'worldpay');
        } catch (\Throwable $e) {
            Log::error('Worldpay authorize error', ['error' => $e->getMessage()]);
            return new PaymentAuthorize(success: false, message: $e->getMessage(), orderId: $this->order->id, paymentType: 'worldpay');
        }
    }

    public function capture(\Lunar\Models\Contracts\Transaction $transaction = null, $amount = 0): PaymentCapture
    {
        try {
            $order = $transaction->order;

            Log::info('Worldpay capture called', ['order_id' => $order->id, 'transaction_id' => $transaction->id, 'amount' => $amount]);

            if (! $order) {
                return new PaymentCapture(success: false, message: 'Order not available for capture.');
            }

            $transaction = $this->createOrUpdateTransaction($order, 'capture', $order->transaction_reference, $amount, null);

            $order->status = 'payment-received';
            $order->save();

            $this->sendOrderEmails($order->user);

            Log::info('Worldpay capture completed', ['order_id' => $order->id, 'transaction_id' => $transaction->id]);

            return new PaymentCapture(success: true, message: 'Payment recorded and order placed');
        } catch (\Throwable $e) {
            Log::error('Worldpay capture error', ['error' => $e->getMessage()]);
            return new PaymentCapture(success: false, message: $e->getMessage());
        }
    }

    private function sendOrderEmails($user)
    {
        $raw = $this->order->discount_breakdown;
        $entries = is_string($raw) ? json_decode($raw) : $raw;

        foreach ($entries as $entry) {
            $discountId = $entry->discount_id ?? null;
            if (!$discountId) {
                continue;
            }

            $freeQty = OrderLine::where('order_id', $this->order->id)
                ->where('meta->free', true)
                ->where('meta->discount_id', $discountId)
                ->sum('quantity');

            if ($freeQty <= 0) {
                continue;
            }

            $discount = Discount::find($discountId);
            $rewardQty = data_get($discount->data, 'reward_qty', 1);

            $timesUsed = (int)floor($freeQty / max(1, $rewardQty));

            for ($i = 0; $i < $timesUsed; $i++) {
                DB::table('lunar_discount_user')->insert([
                    'user_id' => $user->id,
                    'discount_id' => $discountId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Mail::to($user)->send(new CustomerNewOrderMail($this->order));

        $admins = Staff::get();
        foreach ($admins as $admin) {
            if (in_array($admin->email, ['info@dayzsolutions.com', 'pieter@dayzsolutions.com'])) {
                continue;
            }
            Mail::to($admin)->send(new AdminNewOrderMail($this->order));
        }
    }
}
