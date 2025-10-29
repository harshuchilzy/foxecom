<?php

namespace App\Http\Controllers;

use App\Models\ExtendLunarOrder;
use App\Services\WorldpaySignatureVerifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Lunar\Admin\Support\Infolists\Components\Transaction;
use Lunar\Facades\Payments;
use Symfony\Component\HttpFoundation\Response;

class WorldpayWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $worldpayPayment = Payments::driver('worldpay');

        $raw = $request->getContent();
        $sigHeader = $request->header('Event-Signature') ?? $request->header('event-signature');

        Log::info('Worldpay webhook received', ['signature' => $sigHeader]);

        // Verify signature
        // if (! WorldpaySignatureVerifier::verify($raw, $sigHeader)) {
        //     Log::warning('Worldpay webhook invalid signature', ['ip' => $request->ip()]);
        //     return response('Invalid signature', Response::HTTP_BAD_REQUEST);
        // }

        $payload = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Worldpay webhook invalid JSON', ['error' => json_last_error_msg()]);

            return response('Invalid JSON', Response::HTTP_BAD_REQUEST);
        }

        Log::info('Worldpay webhook payload', ['eventId' => data_get($payload, 'eventId'), 'type' => data_get($payload, 'eventDetails.type')]);

        $eventId = data_get($payload, 'eventId');
        $eventType = data_get($payload, 'eventDetails.type') ?? data_get($payload, 'type');
        $transactionReference = data_get($payload, 'eventDetails.transactionReference') ?? data_get($payload, 'eventDetails.downstreamReference');
        $amount = (int) data_get($payload, 'eventDetails.amount.value', 0);
        $currency = data_get($payload, 'eventDetails.amount.currencyCode') ?? data_get($payload, 'eventDetails.amount.currency') ?? 'GBP';

        // find order
        $order = null;
        if ($transactionReference) {
            $order = ExtendLunarOrder::where('transaction_reference', $transactionReference)->first();
        }

        if (! $order) {
            Log::warning('Webhook order not found', ['transactionReference' => $transactionReference, 'eventId' => $eventId]);

            return response('Order not found', Response::HTTP_NOT_FOUND);
        }

        $meta = (array) ($order->worldpay_meta ?? []);
        $meta['last_event_id'] = $eventId;
        $meta['last_event_type'] = $eventType;
        $meta['last_event_at'] = now()->toIso8601String();

        // Save worldpay links if present (flatten)
        $links = data_get($payload, 'eventDetails._links', []);
        if (! empty($links) && is_array($links)) {
            $meta['worldpay_links'] = array_merge($meta['worldpay_links'] ?? [], $worldpayPayment->flattenLinks($links));
        }

        $order->worldpay_meta = $meta;
        $order->save();

        $currentEvent = strtolower((string) $eventType);

        if (Str::contains($currentEvent, 'authorized') || Str::contains($currentEvent, 'sentforauthorization') || Str::contains($currentEvent, 'authorizationsucceeded')) {
            $worldpayPayment->createOrUpdateTransaction($order, 'intent', $transactionReference, $amount, $payload);
            Log::info('Authorization event processed', ['order_id' => $order->id]);
        }

        if (Str::contains($currentEvent, 'settlementrequested') || Str::contains($currentEvent, 'settlementrequestsubmitted') || Str::contains($currentEvent, 'settlement') || Str::contains($currentEvent, 'settled') || Str::contains($currentEvent, 'sentforsettlement')) {
            $worldpayPayment->createOrUpdateTransaction($order, 'capture', $transactionReference, $amount, $payload);

            $transaction = Transaction::where('reference', $transactionReference)->first();

            if (! $transaction) {
                Log::warning('Worldpay capture transaction not found', ['order_id' => $order->id, 'transaction_reference' => $transactionReference]);

                return response('Transaction not found', Response::HTTP_NOT_FOUND);
            }

            $captureResp = $worldpayPayment->capture($transaction, $amount);
            if (! $captureResp->success) {
                Log::warning('Worldpay capture failed', ['order_id' => $order->id, 'capture' => $captureResp]);
                $meta = (array) $order->worldpay_meta;
                $meta['status'] = 'capture_failed';
                $order->update(['worldpay_meta' => $meta, 'status' => 'payment-failed']);
            }

            Log::info('Settlement event processed', ['order_id' => $order->id]);
        }

        return response('OK', Response::HTTP_OK);
    }
}
