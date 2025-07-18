<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lunar\Facades\CartSession;
use Lunar\Facades\Payments;

class CheckoutController extends Controller
{
    public function initiate(Request $request)
    {
        $request->validate(['sessionId' => 'required|string']);

        $cart = CartSession::current();

        $driver = Payments::driver('ngenius')
            ->cart($cart)
            ->withData(['sessionId' => $request->sessionId]);

        $payData = $driver->initiateHostedSession();

        return response()->json($payData);
    }

    public function complete(Request $request)
    {
        $request->validate(['sessionId' => 'required|string']);

        $cart = CartSession::current();

        $driver = Payments::driver('ngenius')
            ->cart($cart)
            ->withData(['sessionId' => $request->sessionId]);

        $authResp = $driver->authorize();

        if (!$authResp->success) {
            return response()->json([
                'success' => false,
                'message' => $authResp->message,
            ], 422);
        }

        $captureResp = $driver->capture();

        return response()->json([
            'success' => $captureResp->success,
            'message' => $captureResp->message,
        ], $captureResp->success ? 200 : 422);
    }
}
