<?php

namespace App\Payments;

use App\Mail\AdminNewOrderMail;
use App\Mail\CustomerNewOrderMail;
use Illuminate\Support\Facades\Mail;
use Lunar\Admin\Models\Staff;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Facades\DB;
use Lunar\Models\Discount;
use Lunar\Models\OrderLine;
use Lunar\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Lunar\PaymentTypes\AbstractPayment;
use Illuminate\Support\Str;
use Lunar\Models\Order as ModelsOrder;
use App\Models\ExtendLunarOrder;
use GuzzleHttp\Exception\RequestException;
use Lunar\Facades\CartSession;

class WorldpayPayment extends AbstractPayment
{
    protected Client $http;
    protected $authHeader;
    protected $acceptHeader;
    protected $contentTypeHeader;
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
        $this->merchantEntity = $config['merchant_entity'];
        $this->contentTypeHeader = $config['content_type_header'];

        $this->http = new Client([
            'base_uri' => $baseUrl,
            'timeout' => 10,
        ]);

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function initiateHostedPaymentPage()
    {
        $this->cart ??= CartSession::current();
        $cartTotal = $this->cart->total;

        $this->order = $this->cart->order ?? $this->cart->createOrder();

        $transactionReference = time() . '-' . Str::random(6);
        $wpCorrelationId = Str::uuid()->toString();

        $wpMeta =  [
            'transaction_reference' => $transactionReference,
            'status' => 'initiated',
            'created_at' => now()->toDateTimeString(),
            'wp_correlation_id' => $wpCorrelationId,
        ];

        $this->order->update([
            'worldpay_meta' => $wpMeta,
            'transaction_reference' => $transactionReference,
            'status' => 'pending_payment', // set a clear order status
        ]);

        $payload = [
            'transactionReference' => $transactionReference,
            'merchant' => [
                'entity' => $this->merchantEntity
            ],
            'narrative' => [
                'line1' => 'FOXERGO Shop',
            ],
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
                    'Content-Type' => $this->contentTypeHeader,
                    'WP-CorrelationId' => $wpCorrelationId,
                ],
                'json' => $payload,
            ]);

            $body = json_decode((string)$res->getBody(), true);

            \Log::info('Worldpay HPP create response', $body);

            $redirectUrl = $body['url'] ?? null;
            $lookupHref  = $body['_links']['self']['href'] ?? null;

            $wpMeta = $this->order->fresh()->worldpay_meta ?? [];
            if (!is_array($wpMeta)) $wpMeta = (array) $wpMeta;

            $wpMeta = array_merge($wpMeta, [
                'response' => $body,
                'redirect_url' => $redirectUrl,
                'lookup_href' => $lookupHref,
                'status' => 'awaiting-payment',
                'updated_at' => now()->toDateTimeString(),
            ]);

            $this->order->update([
                'worldpay_meta' => $wpMeta,
            ]);

            session([
                'worldpay_order_id' => $this->order->id,
                'worldpay_transaction_reference' => $transactionReference,
            ]);

            if (!$redirectUrl) {
                \Log::error('Worldpay HPP create error: No redirect URL in response', $body);
                return redirect()->route('checkout.view')->with('error', 'No redirect URL returned from Worldpay.');
            }

            return redirect()->away($redirectUrl);
        } catch (RequestException $e) {
            \Log::error('Worldpay HPP create error: ' . $e->getMessage(), [
                'body' => $e->hasResponse() ? (string)$e->getResponse()->getBody() : null
            ]);

            $wpMeta = $this->order->fresh()->worldpay_meta ?? [];
            if (!is_array($wpMeta)) $wpMeta = (array)$wpMeta;
            $wpMeta = array_merge($wpMeta, [
                'status' => 'failed_to_initiate',
                'error' => $e->hasResponse() ? json_decode((string)$e->getResponse()->getBody(), true) : $e->getMessage(),
                'updated_at' => now()->toDateTimeString(),
            ]);
            $this->order->update(['worldpay_meta' => $wpMeta]);

            return redirect()->route('checkout.view')->with('error', 'Payment initiation failed.');
        }
    }

    public function authorize(): PaymentAuthorize
    {
        $orderId = session('worldpay_order_id');
        $this->order = ModelsOrder::find($orderId);

        try {
            $response = new PaymentAuthorize(
                success: true,
                message: 'Payment captured',
                orderId: $this->order->id,
                paymentType: 'worldpay',
            );
        } catch (\Exception $e) {
            $response = new PaymentAuthorize(
                success: false,
                message: $e->getMessage(),
                orderId: $this->order->id,
                paymentType: 'worldpay',
            );
        }

        PaymentAttemptEvent::dispatch($response);

        return $response;
    }

    public function capture(Transaction|\Lunar\Models\Contracts\Transaction $transaction = null, $amount = 0): PaymentCapture
    {
        Transaction::create([
            'order_id' => $this->order->id,
            'driver' => 'worldpay',
            'success' => true,
            'amount' => $this->order->total,
            'reference' => $this->transactionReference,
            'status' => 'CAPTURED',
            'type' => 'capture',
            'card_type' => $this->cardType ?? 'unknow',
            'last_four' => $this->cardLast4Digits ?? 'unknown'
        ]);

        $this->order->placed_at = now();
        $this->order->status = 'payment-received';
        $this->order->save();

        if ($user = auth()->user()) {
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
        }

        Mail::to(auth()->user())->send(new CustomerNewOrderMail($this->order));

        $admins = Staff::get();
        foreach ($admins as $admin) {
            if (in_array($admin->email, ['info@dayzsolutions.com', 'pieter@dayzsolutions.com'])) {
                continue;
            }
            Mail::to($admin)->send(new AdminNewOrderMail($this->order));
        }

        return new PaymentCapture(
            success: true,
            message: 'Payment recorded and order placed',
        );
    }

    public function refund(Transaction|\Lunar\Models\Contracts\Transaction $transaction, int $amount = 0, $notes = null): PaymentRefund
    {
        return new PaymentRefund(success: false, message: 'Not implemented');
    }

    public function verifyAndFinalizePayment()
    {
        $orderId = session('worldpay_order_id');
        if (! $orderId) {
            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Order session not found.']);
        }

        $order = ExtendLunarOrder::find($orderId);
        if (! $order) {
            Log::warning('Worldpay: order id from session not found in DB', ['order_id' => $orderId]);
            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Order not found.']);
        }

        $lookupHref = data_get($order->worldpay_meta, 'lookup_href') ?? null;

        if (! $lookupHref) {
            Log::error('Worldpay: lookup/redirect href missing for order', ['order_id' => $order->id, 'worldpay_meta' => $order->worldpay_meta]);
            return redirect()->route('checkout.view')->with(['success' => false, 'message' => 'Lookup URL not available.']);
        }

        try {
            $correlationId = Str::uuid()->toString();
            $maxRetries = 5;
            $attemptDelay = 1;
            $success = false;
            $body = null;

            for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
                $res = $this->http->get($lookupHref, [
                    'headers' => [
                        'Authorization' => $this->authHeader,
                        'WP-CorrelationId' => $correlationId,
                    ],
                    'http_errors' => false,
                    'timeout' => 15,
                ]);

                $status = $res->getStatusCode();
                $raw = (string) $res->getBody();
                $body = json_decode($raw, true) ?: [];

                $payments = data_get($body, '_embedded.payments', []);
                if ($status === 200 && !empty($payments) && is_array($payments)) {
                    $success = true;

                    $this->cardType = data_get($body, '_embedded.payments.0.paymentInstrument.card.brand') ?? null;
                    $this->cardLast4Digits = data_get($body, '_embedded.payments.0.paymentInstrument.card.number.last4Digits') ?? null;
                    $this->transactionReference = $order->transaction_reference;

                    Log::info('Worldpay lookup response', [
                        'order_id' => $order->id,
                        'body' => $body,
                    ]);

                    break;
                }

                if ($status === 200 && empty($payments)) {
                    Log::info('Worldpay lookup returned 200 but payments empty; will retry', [
                        'order_id' => $order->id,
                        'attempt' => $attempt,
                    ]);

                    sleep($attemptDelay);
                    $attemptDelay *= 2;
                    continue;
                }

                Log::warning('Worldpay lookup non-successful attempt (will retry)', [
                    'order_id' => $order->id,
                    'status' => $status,
                    'attempt' => $attempt,
                    'body' => $body,
                ]);

                sleep($attemptDelay);
                $attemptDelay *= 2;
            }

            if (! $success) {
                $wp = is_array($order->worldpay_meta) ? $order->worldpay_meta : (array) ($order->worldpay_meta ?? []);
                $wp['status'] = 'lookup_unconfirmed';
                $wp['lookup_last_checked_at'] = now()->toDateTimeString();
                $wp['lookup_last_http_status'] = $status;
                $wp['lookup_last_response'] = $body;
                $wp['wp_correlation_id'] = $correlationId;

                $order->worldpay_meta = $wp;
                $order->status = 'pending_payment';
                $order->save();

                Log::warning('Worldpay lookup exhausted: no confirmed payment; user redirected and meta updated', [
                    'order_id' => $order->id,
                    'last_status' => $status,
                ]);

                return redirect()->route('checkout.view')->with([
                    'success' => false,
                    'message' => 'Payment not confirmed yet. We will confirm it shortly — please check your email or try again.',
                ]);
            }

            $authResp = $this->authorize();

            if (! $authResp->success) {
                $wp = is_array($order->worldpay_meta) ? $order->worldpay_meta : (array) ($order->worldpay_meta ?? []);
                $wp['status'] = 'failed';
                $wp['authorize_response'] = [
                    'success' => false,
                    'message' => $authResp->message ?? null,
                ];
                $order->worldpay_meta = $wp;
                $order->status = 'failed';
                $order->save();

                Log::warning('Worldpay authorize failed', ['order_id' => $order->id, 'auth' => $authResp]);

                return redirect()->route('checkout.view')->with([
                    'success' => false,
                    'message' => 'Authorization failed: ' . ($authResp->message ?? 'unknown')
                ]);
            }

            $captureResp = $this->capture();

            if (! $captureResp->success) {
                $wp = is_array($order->worldpay_meta) ? $order->worldpay_meta : (array) ($order->worldpay_meta ?? []);
                $wp['status'] = 'capture_failed';
                $wp['capture_response'] = [
                    'success' => false,
                    'message' => $captureResp->message ?? null,
                ];
                $order->worldpay_meta = $wp;
                $order->status = 'failed';
                $order->save();

                Log::warning('Worldpay capture failed', ['order_id' => $order->id, 'capture' => $captureResp]);

                return redirect()->route('checkout.view')->with([
                    'success' => false,
                    'message' => 'Capture failed: ' . ($captureResp->message ?? 'unknown')
                ]);
            }

            $wp = is_array($order->worldpay_meta) ? $order->worldpay_meta : (array) ($order->worldpay_meta ?? []);
            $wp['status'] = 'success';
            $wp['authorized_at'] = now()->toDateTimeString();
            $wp['authorize_response'] = $authResp;
            $wp['capture_response'] = $captureResp;
            $wp['lookup_response'] = $body;

            $order->worldpay_meta = $wp;
            $order->status = 'payment-received';
            $order->save();

            Log::info('Worldpay payment completed', ['order_id' => $order->id]);

            return redirect()->route('checkout-success.view')->with([
                'success' => true,
                'message' => 'Payment authorized and captured successfully.'
            ]);
        } catch (RequestException $e) {
            Log::error('Worldpay HPP lookup error: ' . $e->getMessage(), [
                'order_id' => $order->id ?? null,
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('checkout.view')->with([
                'success' => true,
                'message' => 'Payment verification failed (network).'
            ]);
        } catch (\Throwable $e) {
            Log::error('Unexpected error in Worldpay verify flow', [
                'order_id' => $order->id ?? null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('checkout.view')->with([
                'success' => true,
                'message' => 'Internal error.'
            ]);
        }
    }
}
