<?php

namespace App\Livewire;

use App\Models\Page;
use Lunar\DiscountTypes\BuyXGetY;
use Lunar\Models\Url;
use Livewire\Component;
use Illuminate\View\View;
use App\Models\Redemption;
use Lunar\Models\Collection;
use Lunar\Models\Discount;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    /**
     * Return the sale collection.
     */
    public function getSaleCollectionProperty(): Collection|null
    {
        return Url::whereElementType((new Collection)->getMorphClass())->whereSlug('sale')->first()?->element ?? null;
    }

    /**
     * Return all images in sale collection.
     */
    public function getSaleCollectionImagesProperty()
    {
        if (!$this->getSaleCollectionProperty()) {
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
        $page = Page::with(['meta', 'gallery'])->where('slug', 'home')->first();
        $metaFields = $page?->getMetaKeyValueArray() ?? [];
        $mediaCollection = $page?->getMediaCollectionArray() ?? [];

        //$discounts = Discount::active()->get();
        $discounts = Discount::whereNotNull('starts_at')
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>', now());
            })
            ->get();

        $discountProductIds = \DB::table('lunar_discountables')
            ->whereIn('discount_id', $discounts->pluck('id'))
            ->where('discountable_type', 'product')
            ->pluck('discountable_id')
            ->unique();

        $products = \Lunar\Models\Product::whereIn('id', $discountProductIds)
            ->with(['brand'])
            ->get()
            ->keyBy('id');

        $brandIds = $products->pluck('brand_id')->unique()->filter();

        $brandMedia = \DB::table('media')
            ->where('model_type', 'brand')
            ->whereIn('model_id', $brandIds)
            ->get()
            ->groupBy('model_id');

        $discounts->transform(function ($discount) use ($products, $brandMedia) {
            $productIds = \DB::table('lunar_discountables')
                ->where('discount_id', $discount->id)
                ->where('discountable_type', 'product')
                ->pluck('discountable_id');

            $discountProducts = $products->only($productIds->toArray());

            $discount->products = $discountProducts->map(function ($product) use ($brandMedia) {
                $product->brand_media = $brandMedia[$product->brand_id] ?? collect();
                return $product;
            });

            return $discount;
        });

        $latestDiscounts = $discounts; //->where('type', 'Lunar\DiscountTypes\BuyXGetY')->take(3);

        return view('livewire.home', [
            'latestDiscounts' => $latestDiscounts,
            'metaFields' => $metaFields,
            'mediaCollection' => $mediaCollection,
            'discounts' => $discounts,
        ]);
    }
}
