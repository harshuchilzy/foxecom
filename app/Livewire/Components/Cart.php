<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Illuminate\View\View;
use Lunar\Facades\CartSession;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class Cart extends Component
{
    /**
     * The editable cart lines.
     */
    public array $lines;

    public bool $linesVisible = false;

    public int $cart_count;

    protected $listeners = [
        'add-to-cart' => 'handleAddToCart',
    ];

    public function rules(): array
    {
        return [
            'lines.*.quantity' => 'required|numeric|min:1|max:10000',
        ];
    }

    public function mount(): void
    {
        $this->mapLines();

        $cart = \Lunar\Facades\CartSession::current();

        //$this->cart_count = $cart?->lines->count() ?? 0;

        $this->cart_count = collect($this->cart->lines)->sum(fn($line) => $line->quantity ?? 0);
    }

    /**
     * Get the current cart instance.
     */
    public function getCartProperty()
    {
        return CartSession::current();
    }

    /**
     * Return the cart lines from the cart.
     */
    public function getCartLinesProperty(): Collection
    {
        return $this->cart->lines ?? collect();
    }

    /**
     * Update the cart lines.
     */
    public function updateLines(): void
    {
        $this->validate();

        CartSession::updateLines(
            collect($this->lines)
        );
        $this->mapLines();
        $this->dispatch('cartUpdated');

        $this->cart_count = collect($this->cart->lines)->sum(fn($line) => $line->quantity ?? 0);
    }

    public function removeLine($id): void
    {
        CartSession::remove($id);
        $this->mapLines();

        $this->dispatch('add-to-cart');
    }

    /**
     * Map the cart lines.
     *
     * We want to map out our cart lines like this so we can
     * add some validation rules and make them editable.
     */
    public function mapLines(): void
    {
        $this->lines = $this->cartLines->map(function ($line) {
            return [
                'id' => $line->id,
                'identifier' => $line->purchasable->getIdentifier(),
                'quantity' => $line->quantity,
                'description' => $line->purchasable->getDescription(),
                'thumbnail' => $line->purchasable->getThumbnail()?->getUrl(),
                'option' => $line->purchasable->getOption(),
                'options' => $line->purchasable->getOptions()->implode(' / '),
                'sub_total' => $line->subTotal->formatted(),
                'unit_price' => $line->unitPrice->formatted(),
            ];
        })->toArray();
    }

    public function handleAddToCart(): void
    {
        $this->mapLines();

        $cart = \Lunar\Facades\CartSession::current();

        //$this->cart_count = $cart?->lines->count() ?? 0;

        $this->cart_count = collect($this->cart->lines)->sum(fn($line) => $line->quantity ?? 0);
    
        $this->linesVisible = true;
    }

    public function render(): View
    {
        return view('livewire.components.cart');
    }
}
