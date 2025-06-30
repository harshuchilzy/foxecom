<?php

namespace App\Livewire;

use App\Traits\FetchesUrls;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Models\Collection;
use Lunar\Models\Collection as CollectionModel;

class ProductsPage extends Component
{
     /**
     * The search term for the search input.
     *
     * @var string
     */
    public $term = null;

    /**
     * {@inheritDoc}
     */
    protected $queryString = [
        'term',
    ];

    public $collections;

    public function mount(): void
    {
        $this->collections = CollectionModel::with([
            'thumbnail',
            'products.variants.basePrices',
            'products.defaultUrl',
        ])->get();
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
        logger()->info('Search term:', ['term' => $this->term]);

        $products = Product::with(['variants.basePrices', 'defaultUrl'])->get();

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

        // return Product::with([
        //     'variants.basePrices',
        //     'defaultUrl'
        // ])->get();
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
