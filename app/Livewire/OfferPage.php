<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Discount;
use Lunar\Models\Product;
use Illuminate\Support\Facades\DB;
class OfferPage extends Component
{
    /**
     * Discount collect
     */
    public Discount $discount;

    /**
     * Discount Id
     */
    public int $id;

    public function mount( int $id ): void
    {
        $this->discount = Discount::findOrFail($id);

        $productId = DB::table('lunar_discount_purchasables')
            ->where('discount_id', $id)
            ->where('purchasable_type', 'product')
            ->value('purchasable_id');

        $product = null;

        if ($productId) {
            $product = Product::with('defaultUrl')->find($productId);
        }

        $this->discount->linked_product = $product;
    }


    public function render()
    {
        return view('livewire.offer-page');
    }
}
