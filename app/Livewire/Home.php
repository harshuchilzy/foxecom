<?php

namespace App\Livewire;

use App\Models\Page;
use Lunar\Models\Url;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\Redemption;
use Lunar\Models\Collection;

class Home extends Component
{
    /**
     * Return the sale collection.
     */
    public function getSaleCollectionProperty(): Collection | null
    {
        return Url::whereElementType((new Collection)->getMorphClass())->whereSlug('sale')->first()?->element ?? null;
    }

    /**
     * Return all images in sale collection.
     */
    public function getSaleCollectionImagesProperty()
    {
        if (! $this->getSaleCollectionProperty()) {
            return null;
        }

        $collectionProducts = $this->getSaleCollectionProperty()
            ->products()->inRandomOrder()->limit(4)->get();

        $saleImages = $collectionProducts->map(function ($product) {
            return $product->thumbnail;
        });

        return $saleImages->chunk(2);
    }

    /**
     * Return a random collection.
     */
    public function getRandomCollectionProperty(): ?Collection
    {
        $collections = Url::whereElementType((new Collection)->getMorphClass());

        if ($this->getSaleCollectionProperty()) {
            $collections = $collections->where('element_id', '!=', $this->getSaleCollectionProperty()?->id);
        }

        return $collections->inRandomOrder()->first()?->element;
    }

    public function render(): View
    {
        // return view('livewire.home');
        $redemptions = Redemption::with(['products.brand'])->get();

        $page = Page::with(['meta', 'gallery'])->where('slug', 'home')->first();
        $metaFields = $page?->getMetaKeyValueArray() ?? [];
        $mediaCollection = $page?->getMediaCollectionArray() ?? [];

        $latestRedemptions = $redemptions->take(3);

        return view('livewire.home', [
            'redemptions' => $redemptions,
            'latestRedemptions' => $latestRedemptions,
            'metaFields' => $metaFields,
            'mediaCollection' => $mediaCollection
        ]);
    }
}
