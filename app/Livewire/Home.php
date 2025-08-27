<?php

namespace App\Livewire;

use App\Models\Page;
use Lunar\Models\Url;
use Livewire\Component;
use Lunar\Models\Brand;
use Illuminate\View\View;
use App\Models\Redemption;
use Lunar\Models\Discount;
use Lunar\Models\Collection;
use Lunar\Facades\CartSession;
use Lunar\DiscountTypes\BuyXGetY;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public function mount()
    {
        $customers = \Lunar\Models\Customer::get();
        dd($customers->first()->customerGroups->first()->name);
    }

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

    /**
     * Get BrandSlugs
     */
    public function getBrandSlug($brandId) 
    {
        $brandSlug = $brandId 
                        ? Url::where('element_id', $brandId)
                            ->where('element_type', 'brand')
                            ->value('slug') 
                        : null;

        return $brandSlug;
    }

    public function render(): View
    {
        $page = Page::with(['meta', 'gallery'])->where('slug', 'home')->first();
        $metaFields = $page?->getMetaKeyValueArray() ?? [];
        $mediaCollection = $page?->getMediaCollectionArray() ?? [];

        $discounts = Discount::whereNotNull('starts_at')
            ->where('starts_at', '<=', now())
            ->where(function ($query) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>', now());
            })
            ->get();

        $discountProductIds = \DB::table('lunar_discount_purchasables')
            ->whereIn('discount_id', $discounts->pluck('id'))
            ->where('purchasable_type', 'product')
            ->pluck('purchasable_id')
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
            $productIds = \DB::table('lunar_discount_purchasables')
                ->where('discount_id', $discount->id)
                ->where('purchasable_type', 'product')
                ->pluck('purchasable_id');

            $discountProducts = $products->only($productIds->toArray());

            $discount->products = $discountProducts->map(function ($product) use ($brandMedia) {
                $product->brand_media = $brandMedia[$product->brand_id] ?? collect();
                return $product;
            });

            return $discount;
        });

        $latestDiscounts = $discounts; 

        return view('livewire.home', [
            'latestDiscounts' => $latestDiscounts,
            'metaFields' => $metaFields,
            'mediaCollection' => $mediaCollection,
            'discounts' => $discounts,
        ]);
    }
}
