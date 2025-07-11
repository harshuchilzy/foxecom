<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Discount;
class OfferPage extends Component
{
    public Discount $discount;
    public int $id;

    public function mount( int $id ): void
    {
        $this->discount = Discount::findOrFail($id);
    }


    public function render()
    {
        return view('livewire.offer-page');
    }
}
