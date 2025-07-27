<?php

namespace App\Validation\CartLine;

use Lunar\Validation\BaseValidator;

class CustomCartLineQuantity extends BaseValidator
{
    /**
     * {@inheritDoc}
     */
    public function validate(): bool
    {
        $quantity = $this->parameters['quantity'] ?? 0;
        $purchasable = $this->parameters['purchasable'] ?? null;
        $cartLineId = $this->parameters['cartLineId'] ?? null;
        $cart = $this->parameters['cart'] ?? null;

        if ($cartLineId && ! $purchasable && $cart) {
            $purchasable = $cart->lines->first(
                fn ($cartLine) => $cartLine->id == $cartLineId
            )?->purchasable;
        }

        if ($quantity < 1) {
            $this->fail(
                'cart',
                __('lunar::exceptions.invalid_cart_line_quantity', [
                    'quantity' => $quantity,
                ])
            );
        }

        if ($quantity > 1000000) {
            $this->fail(
                'cart',
                __('lunar::exceptions.maximum_cart_line_quantity', [
                    'quantity' => 1000000,
                ])
            );
        }

        if ($purchasable && $quantity < $purchasable->min_quantity) {
            $this->fail(
                'cart',
                __('lunar::exceptions.minimum_quantity', [
                    'quantity' => $purchasable->min_quantity,
                ])
            );
        }

        return $this->pass();
    }
}
