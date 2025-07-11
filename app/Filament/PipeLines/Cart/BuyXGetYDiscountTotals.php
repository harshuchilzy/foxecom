<?php

namespace App\Filament\PipeLines\Cart;

use Closure;
use Lunar\Models\Cart;
use Lunar\DataTypes\Price;

class BuyXGetYDiscountTotals
{
    public function handle(Cart $cart, Closure $next): Cart
    {
        // First, let the next pipeline finish adjusting prices
        $cart = $next($cart);

        // Build a quick price lookup for paid items: [cartLineId => unitPrice]
        $priceMap = $cart->lines
            ->filter(function ($line) {
                return !($line->meta['free'] ?? false);
            })
            ->mapWithKeys(function ($line) {
                return [$line->id => $line->unitPrice?->value ?? 0];
            });

        // Figure out how much value we’ve given away free:
        // For each “free” line, look up its parent’s price and multiply by free quantity
        $freeValue = $cart->lines
            ->filter(function ($line) {
                return $line->meta['free'] ?? false;
            })
            ->sum(function ($freeLine) use ($priceMap) {
                $parentId = $freeLine->meta['parent_line_id'] ?? null;
                $parentPrice = $priceMap[$parentId] ?? 0;

                return $parentPrice * $freeLine->quantity;
            });

        // If there’s any free-value to apply, override the cart’s discount and total
        if ($freeValue > 0) {
            $cart->discountTotal = new Price(
                $freeValue,
                $cart->currency,
                $cart->currency->factor
            );
            $cart->total = new Price(
                $cart->subTotal->value - $freeValue,
                $cart->currency,
                $cart->currency->factor
            );
        }

        return $cart;
    }
}
