<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Brand;
use Lunar\Models\Product;
use App\Traits\FetchesUrls;
use Lunar\Models\Collection;
use App\Models\Configuration;
use Illuminate\Support\Facades\Log;
use Lunar\Models\Collection as CollectionModel;

class ProductsPage extends Component
{
    /**
     * Sorting option for products.
     */
    public $sortOption = '';
    
     /**
     * The search term for the search input.
     */
    public $term = null;

    /**
     * Store all brands - Filter
     */
    public $brands;

    /**
     * Selected Brands - Filter
     */
    public $selectedBrand = '';

    /**
     * Selected Price Range - Filter
     */
    public $selectedPriceRange = '';

    /**
     * Query strings - Filter
     */
    protected $queryString = [
        'term',
        'selectedBrand',
        'sortOption',
        'selectedPriceRange',
    ];

    /**
     * Store Product Collections
     */
    public $collections;

    public string $mobileBanner;
    public string $desktopBanner;

    public function mount(): void
    {
        $this->collections = CollectionModel::with([
            'thumbnail',
            'products.variants.basePrices',
            'products.defaultUrl',
        ])->get();

        $this->brands = Brand::all();

        $this->mobileBanner =  Configuration::getValue('mobile_wholesale_banner', '');
        $this->desktopBanner =  Configuration::getValue('desktop_wholesale_banner', '');
    }

    /**
     * Return the collections in a tree.
     */
    public function getCollectionsProperty()
    {
        return Collection::with(['defaultUrl'])->get()->toTree();
    }

    /**
     * Filter products by selected rangers
     */
    public function getProductsProperty()
    {
        $query = Product::with(['variants.basePrices', 'defaultUrl'])->where('status', 'published');

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

        // if ($this->selectedPriceRange) {
        //     [$min, $max] = explode('-', $this->selectedPriceRange);
        //     $min = (int) $min;
        //     $max = $max === '' ? null : (int) $max;
        //     $products = $products->filter(function ($product) use ($min, $max) {
        //         $price = $product->variants->first()?->basePrices->first()?->price->value ?? 0;
        //         return $price >= $min && ($max === null || $price <= $max);
        //     });
        // }
       
        if ($this->selectedPriceRange) {
            [$min, $max] = explode('-', $this->selectedPriceRange);
            
            $min = (int)($min * 100); // convert to cents
            $max = $max === '' ? null : (int)($max * 100); // convert to cents
            Log::info('Min: ' . $min . 'Max: ' . $max);
            $products = $products->filter(function ($product) use ($min, $max) {
                $price = (int)($product->variants->first()?->basePrices->first()?->price->value ?? 0);
                return $price >= $min && ($max === null || $price <= $max);
            });
        }


        if ($this->sortOption === 'price_asc') {
            $products = $products->sortBy(function ($product) {
                return $product->variants->first()?->basePrices->first()?->price->value ?? PHP_INT_MAX;
            });
        } 
        
        if ($this->sortOption === 'price_desc') {
            $products = $products->sortByDesc(function ($product) {
                return $product->variants->first()?->basePrices->first()?->price->value ?? 0;
            });
        }

        return $products;
    }

    /**
     * Get price range - Filter
     */
    // public function getPriceRangesProperty()
    // {
    //     $minPrice = Product::with('variants.basePrices')
    //         ->get()
    //         ->map(function ($product) {
    //             return $product->variants->first()?->basePrices->first()?->price->value ?? 0;
    //         })->min();

    //     $maxPrice = Product::with('variants.basePrices')
    //         ->get()
    //         ->map(function ($product) {
    //             return $product->variants->first()?->basePrices->first()?->price->value ?? 0;
    //         })->max();
    //         Log::info('max price: ' . $maxPrice . '| min price' . $minPrice);
    //     $ranges = [];
    //     $step = 1000;
    //     for ($price = floor($minPrice / $step) * $step; $price < $maxPrice; $price += $step) {
    //         $ranges[] = [
    //             'min' => $price,
    //             'max' => $price + $step - 1,
    //             'label' => number_format($price) . ' - ' . number_format($price + $step - 1)
    //         ];
    //     }

    //     $ranges[] = [
    //         'min' => $price,
    //         'max' => null,
    //         'label' => number_format($price) . '+'
    //     ];

    //     return $ranges;
    // }

    public function getPriceRangesProperty()
    {
        $prices = Product::with('variants.basePrices')
            ->get()
            ->map(function ($product) {
                return $product->variants->first()?->basePrices->first()?->price->value / 100 ?? 0;
            })
            ->filter() // remove null/0
            ->values();

        if ($prices->isEmpty()) {
            return [];
        }

        $minPrice = $prices->min();
        $maxPrice = $prices->max();

        $ranges = [];
        $step = 10; // choose a reasonable step now that prices are decimals

        for ($price = floor($minPrice / $step) * $step; $price < $maxPrice; $price += $step) {
            $ranges[] = [
                'min'   => $price,
                'max'   => $price + $step - 0.01,
                'label' => number_format($price, 2) . ' - ' . number_format($price + $step - 0.01, 2)
            ];
        }

        $ranges[] = [
            'min'   => $price,
            'max'   => null,
            'label' => number_format($price, 2) . '+'
        ];

        return $ranges;
    }


    /**
     * Get price ranger for individul products
     */
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
        return view('livewire.products-page');
    }
}
