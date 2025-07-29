<?php

namespace App\Livewire;

use App\Traits\FetchesUrls;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\Collection as CollectionModel;

class CollectionPage extends Component
{
    use FetchesUrls;

    public function mount(string $slug): void
    {
        $this->url = $this->fetchUrl(
            $slug,
            (new CollectionModel)->getMorphClass(),
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
    public function getCollectionProperty(): mixed
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
            // array_push($prices, $base);
            $prices->push($base);
        }

        $pricesWithEffectivePrice = $prices->map(function ($item) use ($outerBoxQty) {
            $effectivePrice = ($item->compare_price->value ?? 0) > 0
                ? $item->compare_price->value
                : $item->price->value;

            $item->per_unit_price = $effectivePrice / $outerBoxQty;
            // Log::info($item->per_unit_price);

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
            'discount' => 0, // $lowest->compare_price->formatted ?? 0,
            'price' => $finalPrice
        );
        
    }

    public function render(): View
    {
        return view('livewire.collection-page');
    }
}
