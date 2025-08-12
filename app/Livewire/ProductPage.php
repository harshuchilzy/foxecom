<?php

namespace App\Livewire;

use Lunar\Models\Cart;
use Livewire\Component;
use Illuminate\View\View;
use Lunar\Models\Channel;
use Lunar\Models\Product;
use Lunar\DataTypes\Price;
use Lunar\Models\Currency;
use Lunar\Models\Discount;
use App\Models\ReviewImage;
use App\Traits\FetchesUrls;
use App\Models\ProductReview;
use Livewire\WithFileUploads;
use Lunar\Facades\CartSession;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductPage extends Component
{
    use FetchesUrls;
    use WithFileUploads;

    /**
     * The selected option values.
     */
    public array $selectedOptionValues = [];

    /**
     * Product quantity
     */
    public $quantity = 1;

    /**
     * Product discount id
     */
    public ?string $discountId = null;

    /**
     * Product review all the fields
     */
    public array $reviewForm = [
        'name' => '',
        'email' => '',
        'rating' => null,
        'review' => '',
        'images' => [],
    ];

    /**
     * Product review validation rules
     */
    protected $rules = [
        'reviewForm.name' => 'required|string|max:255',
        'reviewForm.email' => 'required|email',
        'reviewForm.rating' => 'required|integer|min:1|max:5',
        'reviewForm.review' => 'required|string|max:1000',
        'reviewForm.images.*' => 'nullable|image|max:2048',
    ];

    /**
     * Show Review Popup
     */
    public bool $showReviewPopup = false;

    /**
     * Show Bulk Add to Cart Popup
     */
    public bool $showBulkAddToCartPopup = false;

    /**
     * Product Variations
     */
    public $variations = [];

    /**
     * Selected Variants
     */
    public array $selectedVariants = [];

    /**
     * Selected Variant Quantities
     */
    public array $quantities = [];

    /**
     * Selected Variant Toggles
     */
    public array $toggles = [];

    /**
     * Maximum outer box quantity
     */
    public $maxQuantityIncrement = 1;

    /**
     * Rewarded items(free items)
     */
    public $rewardItems;

    /**
     * Sum of the selected toggles
     */
    public $sumOfSelectedToggles;

    public function mount($slug): void
    {
        $this->discountId = request()->get('discount');

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

        $this->initializeQuantities();
        $this->getLargestQuantityIncrement();
    }

    /**
     * Updated Selected Option Values by Product Id
     */
    function updatedSelectedOptionValues($value) : void {
        $this->product->variant = $this->product->variants->where('product_id', $value);
    }

    /**
     * Get limited products
     */
    public function getSuggestedProductsProperty()
    {
        return Product::with(['media', 'prices'])
            ->latest()
            ->limit(8)
            ->get();
    }

    /**
     * Get Cross Sell Products
     */
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

    /**
     * Get Review Count
     */
    public function getReviewCountProperty(): int
    {
        return ProductReview::where('product_id', $this->product->id)
            ->where('approved', true)
            ->count();
    }

    /**
     * Get Average Rating
     */
    public function getAverageRatingProperty(): ?float
    {
        return ProductReview::where('product_id', $this->product->id)
            ->where('approved', true)
            ->avg('rating');
    }

    /**
     * Get Average Formatted Rating
     */
    public function getFormattedAverageProperty(): string
    {
        return number_format($this->averageRating, 1) ?: '0.0';
    }

    /**
     * Submit Product Review
     */
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

        $this->showReviewPopup = false;
    }

    /**
     * ClaimOffer Button Action
     */
    public function claimOffer()
    {
        if (!$this->discountId) {
            abort(400, 'No discount provided.');
        }

        $discount = $this->getDiscount();

        if (!$discount) {
            abort(404, 'Discount not found.');
        }

        $cart = CartSession::current();
        if(!$cart){
            $cart = Cart::create([
                'currency_id' => Currency::getDefault()->id,
                'channel_id' => Channel::getDefault()->id,
            ]);
        }

        $cart->coupon_code = $discount->coupon;
        $cart->calculate();
        $cart->save();

        session(['active_discount_id' => $this->discountId]);

        $this->quantity = isset($discount->data['min_qty']) ? (int) $discount->data['min_qty'] : 1;

        CartSession::manager()->add($this->variant, $this->quantity, [
            'applied_discount_id' => $this->discountId,
        ]);

        return redirect()->route('product.view', ['slug' => $this->url->slug]);
    }

    /**
     * Load variations inside popup
     */
    public function loadVariations()
    {
        $this->variations = $this->product->variants()
            ->with(['values.option', 'images'])
            ->get()
            ->map(function ($variant) {
                $outerBoxQty = $this->product->attr('outer-box') ?? 1;
                $basePrice = $variant->basePrices->first()->price;
                $unitPricePerOuterBox = $basePrice?->value / $outerBoxQty;

                return [
                    'id' => $variant->id,
                    'name' => $this->getVariantName($variant),
                    'image_url' => $this->getVariantImage($variant),
                    'sku' => $variant->sku,
                    'price' => $variant->basePrices->first()->price?->formatted(),
                    'outer_box_qty' => $outerBoxQty,
                    'unit_price_per_outer_box' =>  $basePrice ? ( new Price($unitPricePerOuterBox, $basePrice->currency, $basePrice->unitQty) )->formatted() : null,
                    'stock' => $variant->stock,
                    'quantity_increment' => $variant->quantity_increment,
                    'options' => $variant->values->map(function ($value) {
                        return [
                            'option_id' => $value->option->id,
                            'option_name' => $value->option->translate('name'),
                            'value_id' => $value->id,
                            'value_name' => $value->translate('name'),
                        ];
                    })->toArray()
                ];
            })->toArray();

        return $this->variations;
    }

    /**
     * Get Variant Name
     */
    protected function getVariantName($variant)
    {
        $productName = $this->product->translate('name');
        $optionNames = $variant->values->map(function ($value) {
            return $value->translate('name');
        })->implode(' / ');

        return "{$productName} - {$optionNames}";
    }

    /**
     * Get Variant Image
     */
    protected function getVariantImage($variant)
    {
        if ($variant->images->isNotEmpty()) {
            return $variant->images->first()->getUrl();
        }

        if ($this->product->images->isNotEmpty()) {
            return $this->product->images->first()->getUrl();
        }

        return asset('images/placeholder.jpg');
    }

    /**
     * Get maximum products qunatity
     */
    public function getLargestQuantityIncrement()
    {
        $discount = $this->getDiscount();
        if($discount){
            $discountType = class_basename($discount->type);

            if ($discount && $discountType == 'BuyXGetY') {
                if (isset($discount->data['min_qty']) && isset($discount->data['reward_qty'])) {
                    // $this->rewardItems = ( $this->maxQuantityIncrement / $discount->data['min_qty'] ) * $discount->data['reward_qty'];
                    // if (is_int($this->rewardItems)) {
                    //     $this->maxQuantityIncrement = $this->maxQuantityIncrement + $this->rewardItems;
                    // }
                    $this->rewardItems = $discount->data['reward_qty'];

                    $this->maxQuantityIncrement = $discount->data['min_qty'] + $this->rewardItems;
                }
            }
        }
    }

    /**
     * Sum of the selected toggles
     */
    public function getSumOfSelectedToggles()
    {
        $this->sumOfSelectedToggles = 0;

        foreach ($this->toggles as $key => $isSelected) {
            if ($isSelected && isset($this->quantities[$key])) {
                $this->sumOfSelectedToggles += $this->quantities[$key];
            }
        }
        return $this->sumOfSelectedToggles;
    }

    /**
     * Reset qunatities and toggles
     * @return void
     */
    protected function initializeQuantities()
    {
        foreach ($this->loadVariations() as $variant) {
            $this->quantities[$variant['id']] = 1;
            $this->toggles[$variant['id']] = false;
        }
    }

    /**
     * Bulk Order Popup Add to Cart Action
     */
    public function addSelectedToCart()
    {
        $validatedData = $this->validate([
            'quantities.*' => 'required|numeric|min:1',
            'toggles.*' => 'nullable|boolean',
        ]);

        if ($this->getSumOfSelectedToggles() > $this->maxQuantityIncrement) {
            $this->addError('bulk-popup-error', "Please select {$this->maxQuantityIncrement} variant(s) only.");
            return;
        }

        if ($this->getSumOfSelectedToggles() < $this->maxQuantityIncrement) {
            $this->addError('bulk-popup-error', "Please select {$this->maxQuantityIncrement} variant(s).");
            return;
        }

        $linesToAdd = [];
        $hasError = false;

        foreach ($this->loadVariations() as $variant) {
            $variantId = $variant['id'];
            $quantity = $this->quantities[$variantId] ?? 0;

            // Only add to cart if toggle is enabled or if you want all variants
            if ($this->toggles[$variantId] && $quantity > 0) {
                $purchasable = ProductVariant::find($variantId);

                if ($purchasable->stock < $quantity) {
                    $this->addError('bulk-popup-error', "Not enough stock for {$variant['name']}");
                    $hasError = true;
                    continue;
                }

                $linesToAdd[] = [
                    'purchasable' => $purchasable,
                    'quantity' => $quantity,
                    'meta' => [
                        'from_popup' => true
                    ]
                ];
            }
        }

        if ($hasError) {
            return;
        }

        if (empty($linesToAdd)) {
            $this->addError('bulk-popup-error', 'Please select at least one variant');
            return;
        }

        // Add all selected items to cart
        foreach ($linesToAdd as $line) {
            $existing = CartSession::lines()
                ->get()
                ->first(fn ($l) => ($l->purchasable_id === $line['purchasable']->id) && empty($l->meta['free']));

            if ($existing) {
                CartSession::updateLines(collect([[
                    'id' => $existing->id,
                    'quantity' => $existing->quantity + $line['quantity'],
                    'meta' => [
                        'from_popup' => true
                    ]
                ]]));
            } else {
                CartSession::manager()->add(
                    $line['purchasable'], 
                    $line['quantity'],
                    $line['meta']
                );
            }
        }

        $discount = $this->getDiscount();

        if (!$discount) {
            abort(404, 'Discount not found.');
        }

        $cart = CartSession::current();
        if(!$cart){
            $cart = Cart::create([
                'currency_id' => Currency::getDefault()->id,
                'channel_id' => Channel::getDefault()->id,
            ]);
        }
        $cart->coupon_code = $discount->coupon;
        $cart->calculate();
        $cart->save();

        $this->dispatch('add-to-cart');
        $this->dispatch('cart-updated');
        $this->showBulkAddToCartPopup = false;
    }

    /**
     * Get Price Range for Individual Products
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

    /**
     * Get Discount
     */
    public function getDiscount()
    {
        $discount = Discount::find($this->discountId);
        return $discount;
    }

    public function render(): View
    {
        return view('livewire.product-page');
    }
}
