<?php

namespace App\Livewire;

use App\Traits\FetchesUrls;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Models\Collection;
use Lunar\Models\Collection as CollectionModel;
use Lunar\Models\Brand;

class ProductsPage extends Component
{
     /**
     * The search term for the search input.
     *
     * @var string
     */
    public $term = null;

    public $brands;
    public $selectedBrand = '';

    /**
     * {@inheritDoc}
     */
    protected $queryString = [
        'term',
        'selectedBrand',
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

        return $products;
    }

    // public function updatedTerm($value)
    // {
    //     logger()->info("Search term updated:", ['term' => $value]);
    // }

    public function render()
    {
        return view('livewire.products-page');
    }
}
