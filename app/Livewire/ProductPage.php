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
use Lunar\Base\Purchasable;
use App\Models\ProductReview;
use Livewire\WithFileUploads;
use Lunar\Facades\CartSession;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
     * Selected KITs Variant Quantities
     */
    public array $kitsQuantities = [];

    /**
     * Selected PODs Variant Quantities
     */
    public array $podsQuantities = [];

    /**
     * Selected Variant Toggles
     */
    public array $toggles = [];

    /**
     * Selected KITs Variant Toggles
     */
    public array $kitsToggles = [];

    /**
     * Selected PODs Variant Toggles
     */
    public array $podsToggles = [];

    /**
     * Maximum outer box quantity
     */
    public $maxQuantityIncrement = 1;

    /**
     * Rewarded items(free items)
     */
    public $rewardItems;

    /**
     * Min items qty to get reward
     */
    public $minItemsQty;

    /**
     * Sum of the selected toggles
     */
    public $sumOfSelectedToggles;

    /**
     * Sum of the selected KITs toggles
     */
    public $sumOfSelectedKitsToggles;

    /**
     * Sum of the selected PODs toggles
     */
    public $sumOfSelectedPodsToggles;

    /**
     * Show Flavors Add to Cart Popup
     */
    public bool $showFlavorsAddToCartPopup = false;

    /**
     * Selected Flavors Quantities
     */
    public array $flavorQty = [];

    /**
     * Is KITs/PODs Combination
     */
    public bool $isKitsPodsCombination = false;

    public ?int $loadingVariantId = null;

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
            abort(404, 'Product not found.');
        }

        $this->selectedOptionValues = $this->productOptions->mapWithKeys(function ($data) {
            return [$data['option']->id => $data['values']->first()->id];
        })->toArray();

        $this->initializeQuantities();
        $this->getLargestQuantityIncrement();
        $this->checkDiscountCombination();
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
    public function getProductProperty(): ?Product
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
                    'unit_price_per_outer_box' => $basePrice ? ( new Price(intval($unitPricePerOuterBox), $basePrice->currency, intval($basePrice->unitQty)) )->formatted() : null,
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
     * Get Discount Product Variant Name
     */
    protected function getDiscountVariantName($discountable, $variant)
    {
        $productName = $discountable->translate('name');
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
     * Get Discount product Variant Image
     */
    protected function getDiscountVariantImage($discountable, $variant)
    {
        if ($variant->images->isNotEmpty()) {
            return $variant->images->first()->getUrl();
        }

        if ($discountable->images->isNotEmpty()) {
            return $discountable->images->first()->getUrl();
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
                    $this->minItemsQty = $discount->data['min_qty'];
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
     * Sum of the selected discount KITs toggles
     */
    public function getSumOfSelectedKitsToggles()
    {
        $this->sumOfSelectedKitsToggles = 0;

        foreach ($this->kitsToggles as $key => $isSelected) {
            if ($isSelected && isset($this->kitsQuantities[$key])) {
                $this->sumOfSelectedKitsToggles += $this->kitsQuantities[$key];
            }
        }
        return $this->sumOfSelectedKitsToggles;
    }

    /**
     * Sum of the selected discount PODs toggles
     */
    public function getSumOfSelectedPodsToggles()
    {
        $this->sumOfSelectedPodsToggles = 0;

        foreach ($this->podsToggles as $key => $isSelected) {
            if ($isSelected && isset($this->podsQuantities[$key])) {
                $this->sumOfSelectedPodsToggles += $this->podsQuantities[$key];
            }
        }
        return $this->sumOfSelectedPodsToggles;
    }

    /**
     * Reset qunatities and toggles
     * @return void
     */
    protected function initializeQuantities()
    {
        if($this->loadVariations()) {
            foreach ($this->loadVariations() as $variant) {
                $this->quantities[$variant['id']] = 1;
                $this->toggles[$variant['id']] = false;
                $this->flavorQty[$variant['id']] = 0;
            }
        }

        if($this->loadConditionProducts()) {
            foreach ($this->loadConditionProducts() as $variant) {
                $this->kitsQuantities[$variant['id']] = 1;
                $this->kitsToggles[$variant['id']] = false;
            }
        }

        if($this->loadRewardedProducts()) {
            foreach ($this->loadRewardedProducts() as $variant) {
                $this->podsQuantities[$variant['id']] = 1;
                $this->podsToggles[$variant['id']] = false;
            }
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
                    'quantity' => $existing->quantity + $line['quantity']
                ]]));
            } else {
                CartSession::manager()->add(
                    $line['purchasable'], 
                    $line['quantity']
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

    public function flavorAddToCart($variantId, $quantity): void
    {
        // Find the purchasable item
        $purchasable = ProductVariant::find($variantId);;

        if (!$purchasable) {
            $this->addError('flavor-error', 'Product not found.');
            return;
        }

        // Validate quantity
        $validator = Validator::make(
            ['quantity' => $quantity],
            ['quantity' => 'required|numeric|min:0|max:10000']
        );

        if ($validator->fails()) {
            $this->addError('flavor-error', 'Invalid quantity.');
            return;
        }

        if ($purchasable->stock < $quantity) {
            $this->addError('flavor-error', 'The quantity exceeds the available stock.');
            return;
        }

        $existing = CartSession::lines()
            ->get()
            ->first(fn ($l) => $l->purchasable_id === $purchasable->id && empty($l->meta['free']));

        if ($existing) {
            CartSession::updateLines(collect([[
                'id' => $existing->id,
                'quantity' => $existing->quantity + $quantity
            ]]));
        } else {
            CartSession::manager()->add($purchasable, $quantity);
        }

        $this->dispatch('add-to-cart');

            $this->loadingVariantId = null;
       
    }

    /**
     * Load all discount products - Conditions
     * @return array|null
     */
    public function loadConditionProducts()
    {
        $discount = $this->getDiscount();

        if($discount && $discount->status == "active") {
            $conditionProducts = $discount->discountableConditions()
                                    ->where('discountable_type', Product::morphName())
                                    ->with('discountable')
                                    ->get()
                                    ->pluck('discountable');

            $allConditionVariations = [];

            foreach($conditionProducts as $conditionProduct) {
                $variationsConditionProduct = $conditionProduct?->variants()
                        ->with(['values.option', 'images'])
                        ->get()
                        ->map(function ($variant) use ($conditionProduct) {
                            $outerBoxQty = $conditionProduct->attr('outer-box') ?? 1;
                            $basePrice = $variant->basePrices->first()->price;
                            $unitPricePerOuterBox = $basePrice?->value / $outerBoxQty;

                            return [
                                'id' => $variant->id,
                                'name' => $this->getDiscountVariantName($conditionProduct, $variant),
                                'image_url' => $this->getDiscountVariantImage($conditionProduct, $variant),
                                'sku' => $variant->sku,
                                'price' => $variant->basePrices->first()->price?->formatted(),
                                'outer_box_qty' => $outerBoxQty,
                                'unit_price_per_outer_box' => $basePrice ? ( new Price(intval($unitPricePerOuterBox), $basePrice->currency, intval($basePrice->unitQty)) )->formatted() : null,
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

                $allConditionVariations = array_merge($allConditionVariations, $variationsConditionProduct);
            }

            return !empty($allConditionVariations) ? $allConditionVariations : null;

        } else {
            return null;
        }
    }

    /**
     * Load all discount products - Rewards
     * @return array|null
     */
    public function loadRewardedProducts()
    {
        $discount = $this->getDiscount();

        if($discount && $discount->status == "active") {
            $rewardProducts = $discount->discountableRewards()
                                    ->where('discountable_type', Product::morphName())
                                    ->with('discountable')
                                    ->get()
                                    ->pluck('discountable');

            $allRewardVariations = [];

            foreach($rewardProducts as $rewardProduct) {
                $variationsRewardProduct = $rewardProduct?->variants()
                        ->with(['values.option', 'images'])
                        ->get()
                        ->map(function ($variant) use ($rewardProduct) {
                            $outerBoxQty = $rewardProduct->attr('outer-box') ?? 1;
                            $basePrice = $variant->basePrices->first()->price;
                            $unitPricePerOuterBox = $basePrice?->value / $outerBoxQty;

                            return [
                                'id' => $variant->id,
                                'name' => $this->getDiscountVariantName($rewardProduct, $variant),
                                'image_url' => $this->getDiscountVariantImage($rewardProduct, $variant),
                                'sku' => $variant->sku,
                                'price' => $variant->basePrices->first()->price?->formatted(),
                                'outer_box_qty' => $outerBoxQty,
                                'unit_price_per_outer_box' => $basePrice ? ( new Price(intval($unitPricePerOuterBox), $basePrice->currency, intval($basePrice->unitQty)) )->formatted() : null,
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

                $allRewardVariations = array_merge($allRewardVariations, $variationsRewardProduct);
            }

            return !empty($allRewardVariations) ? $allRewardVariations : null;

        } else {
            return null;
        }
    }

    /**
     * Claim now Popup Add to Cart Action - New
     */
    public function addDiscountablesToCart()
    {
        // $validatedData = $this->validate([
        //     'quantities.*' => 'required|numeric|min:1',
        //     'toggles.*' => 'nullable|boolean',
        //     'podsQuantities.*' => 'required|numeric|min:1',
        //     'podsToggles.*' => 'nullable|boolean',
        // ]);

        if ($this->getSumOfSelectedKitsToggles() > $this->minItemsQty) {
            $this->addError('kits-pods-popup-error', "Please select {$this->minItemsQty} KITs only.");
            return;
        }

        if ($this->getSumOfSelectedKitsToggles() < $this->minItemsQty) {
            $this->addError('kits-pods-popup-error', "Please select {$this->minItemsQty} KITs.");
            return;
        }

        if ($this->getSumOfSelectedPodsToggles() > $this->rewardItems) {
            $this->addError('kits-pods-popup-error', "Please select {$this->rewardItems} PODs only.");
            return;
        }

        if ($this->getSumOfSelectedPodsToggles() < $this->rewardItems) {
            $this->addError('kits-pods-popup-error', "Please select {$this->rewardItems} PODs.");
            return;
        }

        $linesToAdd = [];
        $hasError = false;

        foreach ($this->loadConditionProducts() as $variant) {
            $variantId = $variant['id'];
            $quantity = $this->kitsQuantities[$variantId] ?? 0;

            // Only add to cart if toggle is enabled or if you want all variants
            if (isset($this->kitsToggles[$variantId]) && $this->kitsToggles[$variantId] && $quantity > 0) {
                $purchasable = ProductVariant::find($variantId);

                if ($purchasable->stock < $quantity) {
                    $this->addError('kits-pods-popup-error', "Not enough stock for {$variant['name']}");
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

        foreach ($this->loadRewardedProducts() as $podVariant) {
            $variantId = $podVariant['id'];
            $quantity = $this->podsQuantities[$variantId] ?? 0;
 
            // Only add to cart if toggle is enabled or if you want all variants
            if (isset($this->podsToggles[$variantId]) && $this->podsToggles[$variantId] && $quantity > 0) {
                $purchasable = ProductVariant::find($variantId);

                if ($purchasable->stock < $quantity) {
                    $this->addError('kits-pods-popup-error', "Not enough stock for {$podVariant['name']}");
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
            $this->addError('kits-pods-popup-error', 'Please select at least one variant');
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
                    'quantity' => $existing->quantity + $line['quantity']
                ]]));
            } else {
                CartSession::manager()->add(
                    $line['purchasable'], 
                    $line['quantity']
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
     * Check whether this is KITs/PODs Combination
     */
    public function checkDiscountCombination() 
    {
        $discountables = $this->getDiscount()?->discountables;
        
        if($discountables) {
            $discountableIds = $discountables->pluck('discountable_id')->unique();
            if($discountableIds->count() == 1) {
                $this->isKitsPodsCombination = false;
            }else{
                $this->isKitsPodsCombination = true;
            }
        }
    }

    public function render(): View
    {
        return view('livewire.product-page');
    }
}
