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
        $this->outer_box_qty = ($this->quantity) * ($this->purchasable->quantity_increment ?? 1);
        //Log::info(print_r($this->outer_box_qty, true));
        if ($this->purchasable->stock < $this->outer_box_qty) {
            $this->addError('quantity', 'The quantity exceeds the available stock.');
            return;
        }

        // Look up any existing PAID line for this variant
        $existing = CartSession::lines()
            ->get()
            ->first(fn ($l) => ($l->purchasable_id === $this->purchasable->id) && empty($l->meta['free']));

        if ($existing) {
            // If it exists, update the quantity
            CartSession::updateLines(collect([[
                'id' => $existing->id,
                'quantity' => $existing->quantity + $this->outer_box_qty
            ]]));
        } else {
            CartSession::manager()->add($this->purchasable, $this->outer_box_qty);
        }

        $this->dispatch('add-to-cart');
    }

    public function render(): View
    {
        return view('livewire.components.add-to-cart');
    }
}
