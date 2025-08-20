<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\View\View;
use Lunar\Base\Purchasable;
use Lunar\Facades\CartSession;
use Illuminate\Support\Facades\Log;

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

    public int $outer_box_qty = 1;

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

        $existing = CartSession::lines()
            ->get()
            ->first(fn ($l) => $l->purchasable_id === $this->purchasable->id && empty($l->meta['free']));

        if ($existing) {
            CartSession::updateLines(collect([[
                'id' => $existing->id,
                'quantity' => $existing->quantity + $this->quantity
            ]]));
        } else {
            CartSession::manager()->add(
                $this->purchasable, 
                $this->quantity
            );
        }

        $this->dispatch('add-to-cart');
    }

    public function render(): View
    {
        return view('livewire.components.add-to-cart');
    }
}
