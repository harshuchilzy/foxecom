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
    
    public function render()
    {
        return view('livewire.products-page');
    }
}
