<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Brand;
use Lunar\Models\Product;
use App\Traits\FetchesUrls;
use Lunar\Models\Collection;
use Illuminate\Support\Facades\Log;
use Lunar\Models\Collection as CollectionModel;

class ProductsPage extends Component
{
    /**
     * Sorting option for products.
     *
     * @var string
     */
    public $sortOption = '';
     /**
     * The search term for the search input.
     *
     * @var string
     */
    public $term = null;

    public $brands;
    public $selectedBrand = '';

    public $selectedPriceRange = '';

    /**
     * {@inheritDoc}
     */
    protected $queryString = [
        'term',
        'selectedBrand',
        'sortOption',
        'selectedPriceRange',
    ];

    public $collections;

    public function mount(): void
    {
        $this->collections = CollectionModel::with([
            'thumbnail',
            'products.variants.basePrices',
            'products.defaultUrl',
        ])->get();

        $this->brands = Brand::all();
    }

    /**
     * Return the collections in a tree.
     */
    public function getCollectionsProperty()
    {
        return Collection::with(['defaultUrl'])->get()->toTree();
    }

    public function getProductsProperty()
    {
        $query = Product::with(['variants.basePrices', 'defaultUrl']);

        if ($this->selectedBrand) {
            $query->where('brand_id', $this->selectedBrand);
        }

        if ($this->sortOption === 'latest') {
            $query->latest();
        }

        $products = $query->get();

        if ($this->term) {
            $products = $products->filter(function ($product) {
                $translatedName = $product->attribute_data['name'] ?? null;

                if (method_exists($translatedName, 'getValue')) {
                    $name = $translatedName->getValue('en'); // or use app locale
                    return stripos($name, $this->term) !== false;
                }

                return false;
            });
        }

        if ($this->selectedPriceRange) {
            [$min, $max] = explode('-', $this->selectedPriceRange);
            $min = (int) $min;
            $max = $max === '' ? null : (int) $max;
            $products = $products->filter(function ($product) use ($min, $max) {
                $price = $product->variants->first()?->basePrices->first()?->price->value ?? 0;
                return $price >= $min && ($max === null || $price <= $max);
            });
        }

        if ($this->sortOption === 'price-asc') {
            $products = $products->sortBy(function ($product) {
                return optional($product->variants->first()?->basePrices->first())->price->value ?? 0;
            });
        } elseif ($this->sortOption === 'price-desc') {
            $products = $products->sortByDesc(function ($product) {
                return optional($product->variants->first()?->basePrices->first())->price->value ?? 0;
            });
        }

        return $products;
    }
    public function getPriceRangesProperty()
    {
        $minPrice = Product::with('variants.basePrices')
            ->get()
            ->map(function ($product) {
                return $product->variants->first()?->basePrices->first()?->price->value ?? 0;
            })->min();

        $maxPrice = Product::with('variants.basePrices')
            ->get()
            ->map(function ($product) {
                return $product->variants->first()?->basePrices->first()?->price->value ?? 0;
            })->max();

        $ranges = [];
        $step = 1000;
        for ($price = floor($minPrice / $step) * $step; $price < $maxPrice; $price += $step) {
            $ranges[] = [
                'min' => $price,
                'max' => $price + $step - 1,
                'label' => number_format($price) . ' - ' . number_format($price + $step - 1)
            ];
        }

        $ranges[] = [
            'min' => $price,
            'max' => null,
            'label' => number_format($price) . '+'
        ];

        return $ranges;
    }

    // public function updatedTerm($value)
    // {
    //     logger()->info("Search term updated:", ['term' => $value]);
    // }

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


    public function render()
    {
        return view('livewire.products-page');
    }
}
