<?php

namespace App\Filament\PipeLines\Cart;

use Closure;
use Lunar\Models\Cart;
use Lunar\DataTypes\Price;
use Illuminate\Support\Facades\Log;

class BuyXGetYDiscountTotals
{
    public function handle(Cart $cart, Closure $next): Cart
    {
        $cart = $next($cart);

        $paidLines = $cart->lines
            ->filter(fn ($L) => !($L->meta['free'] ?? false));

        $freeLines = $cart->lines
            ->filter(fn ($L) => $L->meta['free'] ?? false);

        $zeroPrice = new Price(0, $cart->currency, $cart->currency->factor);
        $paidSubtotal = 0;
        $totalDiscountValue = 0;

        foreach ($paidLines as $paid) {
            $unit = $paid->unitPrice->value;
            $paidSubtotal += $unit * $paid->quantity;
        }

        foreach ($freeLines as $free) {
            $parentId = $free->meta['parent_line_id'] ?? null;
            $parentUnit = $paidLines->firstWhere('id', $parentId)?->unitPrice->value ?? 0;
            $discountForLine = $parentUnit * $free->quantity;
            $totalDiscountValue += $discountForLine;

            $free->unitPrice = $zeroPrice;
            $free->subTotal = $zeroPrice;
            $free->discountTotal = $zeroPrice;
            $free->total = $zeroPrice;
            $free->save();
        }

        $originalSubtotal = $paidSubtotal + $totalDiscountValue;

        $shipping = $cart->shippingSubTotal?->value ?? 0;
        $tax = $cart->taxTotal?->value ?? 0;
      
        $rawTotal = $originalSubtotal + $shipping + $tax - $totalDiscountValue;
        $finalTotal = max(0, $rawTotal);
        
        $cart->subTotal = new Price($originalSubtotal, $cart->currency, $cart->currency->factor);
        $cart->discountTotal = new Price($totalDiscountValue, $cart->currency, $cart->currency->factor);
        $cart->total = new Price($finalTotal, $cart->currency, $cart->currency->factor);

        return $cart;
    }
}
