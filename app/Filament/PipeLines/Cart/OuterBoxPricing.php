<?php

namespace App\Filament\PipeLines\Cart;

use Closure;
use Lunar\DataTypes\Price;
use Lunar\Facades\Pricing;
use Lunar\Models\CartLine;
use Spatie\LaravelBlink\BlinkFacade as Blink;
use Illuminate\Support\Facades\Log;

class OuterBoxPricing
{
    public function handle(CartLine $cartLine, Closure $next)
    {
        $purchasable = $cartLine->purchasable;
        $cart = $cartLine->cart;

        if ($customer = $cart->customer) {
            $customerGroups = $customer->customerGroups;
        } else {
            $customerGroups = $cart->user?->customers->pluck('customerGroups')->flatten();
        }

        $currency = Blink::once('currency_'.$cart->currency_id, function () use ($cart) {
            return $cart->currency;
        });

        $priceResponse = Pricing::currency($currency)
            ->qty($cartLine->quantity)
            ->currency($cart->currency)
            ->customerGroups($customerGroups)
            ->for($purchasable)
            ->get();

        $unitQuantity = $purchasable->getUnitQuantity();
        
        // Get outer box quantity from product attributes
        $outerBoxQty = $purchasable->product->attr('outer-box') ?? 1;
        
        // Calculate base price
        $basePrice = $priceResponse->matched->price->value;
        $basePriceInclTax = $priceResponse->matched->priceIncTax()->value;
        
        // Apply outer box division
        $adjustedPrice = $basePrice / $outerBoxQty;
        $adjustedPriceInclTax = $basePriceInclTax / $outerBoxQty;

        $cartLine->unitPrice = new Price(
            $adjustedPrice,
            $cart->currency,
            $unitQuantity
        );

        $cartLine->unitPriceInclTax = new Price(
            $adjustedPriceInclTax,
            $cart->currency,
            $unitQuantity
        );

        return $next($cartLine);
    }
}