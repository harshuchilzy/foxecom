<?php

namespace App\Payments;

use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Lunar\PaymentTypes\AbstractPayment;

class NgeniusPayment extends AbstractPayment
{
    protected Client $http;

    public function setConfig(array $config): static
    {
        $this->config = $config;

        $baseUri = rtrim($config['base_uri'], '/');

        $this->http = new Client([
            'base_uri' => $baseUri,
            'timeout' => 10,
        ]);

        return $this;
    }

    public function initiateHostedSession(): array
    {
        $totalPrice = $this->cart->total;
        $sessionId = $this->data['sessionId'];

        $tokenRes = $this->http->post('/identity/auth/access-token', [
            'headers' => [
                'Accept' => 'application/vnd.ni-identity.v1+json',
                'Content-Type' => 'application/vnd.ni-identity.v1+json',
                'Authorization' => "Basic {$this->config['api_key']}",
            ]
        ]);

        $body = json_decode((string)$tokenRes->getBody(), true);
        $accessToken = $body['access_token'] ?? null;

//        $totalPrice->currency->code;

        $paymentRes = $this->http->post(
            "transactions/outlets/{$this->config['outlet_ref']}/payment/hosted-session/{$sessionId}",
            [
                'headers' => [
                    'Content-Type' => 'application/vnd.ni-payment.v2+json',
                    'Authorization' => "Bearer {$accessToken}",
                ],
                'json' => [
                    'action' => 'SALE',
                    'amount' => [
                        'currencyCode' => 'AED',
                        'value' => $totalPrice->value,
                    ]
                ],
            ]
        );

        Log::info($paymentRes->getBody());

        return json_decode((string) $paymentRes->getBody(), true);
    }

    public function authorize(): PaymentAuthorize
    {
        if (!$this->order) {
            $this->order = $this->cart->order ?? $this->cart->createOrder();
        }

        try {
            $response = new PaymentAuthorize(
                success: true,
                message: 'Payment captured',
                orderId: $this->order->id,
                paymentType: 'ngenius',
            );
        } catch (\Exception $e) {
            $response = new PaymentAuthorize(
                success: false,
                message: $e->getMessage(),
                orderId: $this->order->id,
                paymentType: 'ngenius',
            );
        }

        PaymentAttemptEvent::dispatch($response);

        return $response;
    }

    public function capture(Transaction|\Lunar\Models\Contracts\Transaction $transaction = null, $amount = 0): PaymentCapture
    {
        Transaction::create([
            'order_id' => $this->order->id,
            'driver' => 'ngenius',
            'success' => true,
            'amount' => $this->order->total,
            'reference' => $this->data['sessionId'],
            'status' => 'CAPTURED',
            'type' => 'capture',
            'card_type' => 'card'
        ]);

        $this->order->placed_at = now();
        $this->order->status = 'payment-received';
        $this->order->save();

        return new PaymentCapture(
            success: true,
            message: 'Payment recorded and order placed',
        );
    }

    public function refund(Transaction|\Lunar\Models\Contracts\Transaction $transaction, int $amount = 0, $notes = null): PaymentRefund
    {
        return new PaymentRefund(success: false, message: 'Not implemented');
    }
}
