<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lunar\Facades\CartSession;
use Lunar\Facades\Payments;

class CheckoutController extends Controller
{
    public function finalize(Request $request)
    {
        $cart = CartSession::current();

        $driver = Payments::driver('worldpay')
            ->cart($cart);

        return $driver->verifyAndFinalizePayment();
    }
}
