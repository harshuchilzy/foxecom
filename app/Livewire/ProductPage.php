<?php

namespace App\Livewire;

use App\Traits\FetchesUrls;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Livewire\WithFileUploads;
use App\Models\ProductReview;
use App\Models\ReviewImage;

class ProductPage extends Component
{
    use FetchesUrls;
    use WithFileUploads;

    /**
     * The selected option values.
     */
    public array $selectedOptionValues = [];

    public $quantity = 1;

    public ?string $redemptionId = null;

    public array $reviewForm = [
        'name' => '',
        'email' => '',
        'rating' => null,
        'review' => '',
        'images' => [],
    ];

    protected $rules = [
        'reviewForm.name' => 'required|string|max:255',
        'reviewForm.email' => 'required|email',
        'reviewForm.rating' => 'required|integer|min:1|max:5',
        'reviewForm.review' => 'required|string|max:1000',
        'reviewForm.images.*' => 'nullable|image|max:2048',
    ];


    public function mount($slug): void
    {
        $this->redemptionId = request()->get('redemption');

        $this->url = $this->fetchUrl(
            $slug,
            (new Product)->getMorphClass(),
            [
                'element.media',
                'element.variants.basePrices.currency',
                'element.variants.basePrices.priceable',
                'element.variants.values.option',
                'element.associations.target',
            ]
        );

        if (! $this->url) {
            abort(404);
        }

        $this->selectedOptionValues = $this->productOptions->mapWithKeys(function ($data) {
            return [$data['option']->id => $data['values']->first()->id];
        })->toArray();
    }


    public function getSuggestedProductsProperty()
    {
        return Product::with(['media', 'prices'])
            ->latest()
            ->limit(8)
            ->get();
    }

    public function getCrossSellProductsProperty(): Collection
    {
        return $this->product->associations
            ->filter(fn ($assoc) => $assoc->type === 'cross-sell' && $assoc->target)
            ->pluck('target');
    }

    /**
     * Computed property to get variant.
     */
    public function getVariantProperty(): ProductVariant
    {
        return $this->product->variants->first(function ($variant) {
            return ! $variant->values->pluck('id')
                ->diff(
                    collect($this->selectedOptionValues)->values()
                )->count();
        });
    }

    /**
     * Computed property to return all available option values.
     */
    public function getProductOptionValuesProperty(): Collection
    {
        return $this->product->variants->pluck('values')->flatten();
    }

    /**
     * Computed propert to get available product options with values.
     */
    public function getProductOptionsProperty(): Collection
    {
        return $this->productOptionValues->unique('id')->groupBy('product_option_id')
            ->map(function ($values) {
                return [
                    'option' => $values->first()->option,
                    'values' => $values,
                ];
            })->values();
    }

    /**
     * Computed property to return product.
     */
    public function getProductProperty(): Product
    {
        return $this->url->element;
    }

    /**
     * Return all images for the product.
     */
    public function getImagesProperty(): Collection
    {
        return $this->product->media->sortBy('order_column');
    }

    /**
     * Computed property to return current image.
     */
    public function getImageProperty(): ?Media
    {
        if (count($this->variant->images)) {
            return $this->variant->images->first();
        }

        if ($primary = $this->images->first(fn ($media) => $media->getCustomProperty('primary'))) {
            return $primary;
        }

        return $this->images->first();
    }

    /**
     * Summary of getCrossSellAssociationsProperty
     */
    public function getCrossSellAssociationsProperty()
    {
        return $this->product->associations->filter(function ($association) {
            return $association->type === 'cross-sell';
        })->take(8);
    }

    public function getReviewCountProperty(): int
    {
        return \App\Models\ProductReview::where('product_id', $this->product->id)
            ->where('approved', true)
            ->count();
    }

    public function submitReview()
    {
        $this->validate();

        $review = ProductReview::create([
            'product_id' => $this->product->id,
            'content' => $this->reviewForm['review'],
            'rating' => $this->reviewForm['rating'],
            'approved' => null,
            'customer_id' => auth()->user()?->customer?->id,
        ]);

        foreach ($this->reviewForm['images'] as $image) {
            $path = $image->store('review-images', 'public');
            $review->images()->create(['path' => $path]);
        }

        $this->reset('reviewForm');

        session()->flash('success', 'Review submitted and awaiting approval.');
    }

    public function claimOffer(): \Livewire\Features\SupportRedirects\Redirector
    {
        if ($this->redemptionId) {
            session(['active_redemption_id' => $this->redemptionId]);
        }

        $productId = $this->product->id;
        $variantId = $this->variant->id;
        $quantity = $this->quantity;

        return redirect()->route('checkout.view', [
            'redemption' => $this->redemptionId,
            'product' => $productId,
            'variant' => $variantId,
            'quantity' => $quantity,
        ]);
    }

    public function render(): View
    {
        return view('livewire.product-page');
    }
}
