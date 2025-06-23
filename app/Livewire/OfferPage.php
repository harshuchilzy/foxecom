<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Redemption;
class OfferPage extends Component
{
    public Redemption $redemption;
    public int $id;

    public function mount(): void
    {
        // $this->redemption = \App\Models\Redemption::with('products')->findOrFail($this->id);
        $this->redemption = \App\Models\Redemption::with('products.defaultUrl')->findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.offer-page');
    }
}
