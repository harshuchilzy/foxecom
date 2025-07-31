<?php

namespace App\Livewire;

use Livewire\Component;
use App\Traits\FetchesUrls;
use Lunar\Models\Brand as BrandModel;

class BrandPage extends Component
{
    use FetchesUrls;

    public function mount(string $slug): void
    {
        $this->url = $this->fetchUrl(
            $slug,
            (new BrandModel)->getMorphClass(),
            [
                'element.thumbnail',
                'element.products.variants.basePrices',
                'element.products.defaultUrl',
            ]
        );

        if (! $this->url) {
            abort(404);
        }
    }

    /**
     * Computed property to return the collection.
     */
    public function getBrandProperty(): mixed
    {
        return $this->url->element;
    }

    public function getPriceRangeForProducts($product)
    {
        if (!$product->variants()->exists()) {
            return null;
        }

        $variations = $product->variants()
            ->with(['values.option', 'basePrices'])
            ->get();

        $outerBoxQty = $product->attr('outer-box') ?? 1;

        $prices = collect();

        foreach ($variations as $variant) {
            $base = $variant->basePrices->first();
            $prices->push($base);
        }

        $pricesWithEffectivePrice = $prices->map(function ($item) use ($outerBoxQty) {
            $effectivePrice = ($item->compare_price->value ?? 0) > 0
                ? $item->compare_price->value
                : $item->price->value;

            $item->per_unit_price = $effectivePrice / $outerBoxQty;

            return $item;
        });


        $lowest = $pricesWithEffectivePrice->sortBy('per_unit_price')->first();
        $highest = $pricesWithEffectivePrice->sortByDesc('per_unit_price')->first();

        $lowest->price->value = $lowest->per_unit_price;
       
        $highest->price->value = $highest->per_unit_price;
       
        if($lowest->price->value == $highest->price->value){
            $finalPrice = $highest->price->formatted; 
        }else{
            $finalPrice = $lowest->price->formatted . ' - ' . $highest->price->formatted; 
        }
        return array(
            'discount' => 0, 
            'price' => $finalPrice
        );
        
    }

    public function render()
    {
        return view('livewire.brand-page');
    }
}
