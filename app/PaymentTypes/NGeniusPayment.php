<?php

namespace App\PaymentTypes;

use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Events\PaymentAttemptEvent;
use Lunar\Models\Transaction;

class NGeniusPayment extends AbstractPayment
{
    /**
     * {@inheritDoc}
     */
    public function authorize(): ?PaymentAuthorize
    {
        if (!$this->order) {
            if (!$this->order = $this->cart->order) {
                $this->order = $this->cart->createOrder();
            }
        }

        // ...
        
        $response = new PaymentAuthorize(
            success: true,
            message: 'The payment was successful',
            orderId: $this->order->id,
            paymentType: 'custom-type'
        );
        
        PaymentAttemptEvent::dispatch($response);

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function refund(Transaction $transaction, int $amount = 0, $notes = null): PaymentRefund
    {
        // ...
        return new PaymentRefund(true);
    }

    /**
     * {@inheritDoc}
     */
    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        // ...
        return new PaymentCapture(true);
    }
}