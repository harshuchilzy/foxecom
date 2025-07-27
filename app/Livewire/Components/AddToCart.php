<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Component;
use Lunar\Base\Purchasable;
use Lunar\Facades\CartSession;

class AddToCart extends Component
{
    /**
     * The purchasable model we want to add to the cart.
     */
    public ?Purchasable $purchasable = null;

    /**
     * The quantity to add to cart.
     */
    public int $quantity = 1;

    public function rules(): array
    {
        return [
            'quantity' => 'required|numeric|min:1|max:10000',
        ];
    }

    public function addToCart(): void
    {
        $this->validate();

        if ($this->purchasable->stock < $this->quantity) {
            $this->addError('quantity', 'The quantity exceeds the available stock.');
            return;
        }

        $productVariantQuantityIncrement = $this->quantity * $this->purchasable?->quantity_increment;

        $existing = CartSession::lines()
            ->get()
            ->first(fn ($l) => $l->purchasable_id === $this->purchasable->id && empty($l->meta['free']));

        if ($existing) {
            CartSession::updateLines(collect([[
                'id' => $existing->id,
                'quantity' => $existing->quantity + $productVariantQuantityIncrement,
            ]]));
        } else {
            CartSession::manager()->add($this->purchasable, $productVariantQuantityIncrement);
        }

        $this->dispatch('add-to-cart');
    }

    public function render(): View
    {
        return view('livewire.components.add-to-cart');
    }
}
