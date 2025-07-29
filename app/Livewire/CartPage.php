<?php

namespace App\Livewire;

use App\Traits\DeletesFreeChildLines;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Facades\CartSession;
use Illuminate\Support\Collection;
use Lunar\Facades\ShippingManifest;

class CartPage extends Component
{
    use DeletesFreeChildLines;

    /**
     * The editable cart lines.
     */
    public array $lines;

    public bool $linesVisible = false;

    public int $cart_count;

    public string $couponCode;


    protected $listeners = [
        'add-to-cart' => 'handleAddToCart',
    ];

    public function rules(): array
    {
        return [
            'lines.*.quantity' => 'required|numeric|min:1|max:10000',
        ];
    }

    // public function mount(): void
    // {

    //     $this->mapLines();

    //     $cart = \Lunar\Facades\CartSession::current();

    //     $this->cart_count = $cart?->lines->count() ?? 0;
    // }

    public function mount(): void
    {
        // Apply discount if query param exists
        if (request()->has('discount')) {
            $discountId = request()->get('discount');

            $discount = \Lunar\Models\Discount::find($discountId);

            if ($discount && $discount->coupon) {
                $cart = \Lunar\Facades\CartSession::current();
                $cart->coupon_code = $discount->coupon;
                $cart->calculate();
                $cart->save();

                session()->put('coupon_code', $discount->coupon);
                session()->put('active_discount_id', $discount->id);
            }
        }

        $this->mapLines();

        $cart = \Lunar\Facades\CartSession::current();
        $this->cart_count = $cart?->lines->count() ?? 0;
    }

    /**
     * Get the current cart instance.
     */
    public function getCartProperty()
    {
        return CartSession::current();
    }

    /**
     * Return the cart lines from the cart.
     */
    public function getCartLinesProperty(): Collection
    {
        return $this->cart->lines ?? collect();
    }

    /**
     * Update the cart lines.
     */
    public function updateLines(): void
    {
        $this->validate();

        // foreach ($this->lines as $line) {
        //     if ($line['quantity_increment'] > 0) {
        //         $quantity = (int) $line['quantity'];
        //         $increment = (int) $line['quantity_increment'];
        //         if ($quantity % $increment !== 0) {
        //             $this->addError('cart-quantity', 'Quantity for ' . ($line['description'] ?? 'item') . ' must be a multiple of ' . $increment . '.');
        //             return;
        //         }
        //     } 
        // }

        CartSession::updateLines(
            collect($this->lines)
        );

        // $paidLines = collect($this->lines)
        //     ->filter(fn ($line) => empty($line['meta']['free']))
        //     ->map(fn ($line) => [
        //         'id' => $line['id'],
        //         'quantity' => (int)$line['quantity'],
        //     ]);

        // CartSession::updateLines($paidLines);

        $this->cleanupFreeChildren();

        $this->dispatch('cartUpdated');
        $this->dispatch('add-to-cart');
    }

    public function removeLine($id): void
    {
        if($this->cart->lines->where('id', $id)->first()){
            CartSession::remove($id);
            $this->mapLines();
            $this->dispatch('add-to-cart');
        }
    }

    /**
     * Map the cart lines.
     *
     * We want to map out our cart lines like this so we can
     * add some validation rules and make them editable.
     */
    public function mapLines(): void
    {

        $this->lines = $this->cartLines->map(function ($line) {
            // Log::info($line->purchasable);
            return [
                'id' => $line->id,
                'identifier' => $line->purchasable->getIdentifier(),
                'quantity' => $line->quantity,
                'quantity_increment' => $line->purchasable->quantity_increment,
                'description' => $line->purchasable->getDescription(),
                'thumbnail' => $line->purchasable->getThumbnail()?->getUrl(),
                'option' => $line->purchasable->getOption(),
                'options' => $line->purchasable->getOptions()->implode(' / '),
                'sub_total' => $line->subTotal->formatted(),
                'unit_price' => $line->unitPrice->formatted(),
                'stock' => $line->purchasable->stock,
                'meta' => (array)$line->meta,
            ];
        })->toArray();
    }

    public function handleAddToCart(): void
    {

        $this->mapLines();

        $cart = \Lunar\Facades\CartSession::current();

        $this->cart_count = $cart?->lines->count() ?? 0;

        $this->linesVisible = true;

        $this->dispatch('cartupdated');
    }

    /**
     * Return the shipping option.
     */
    public function getShippingOptionProperty()
    {
        $shippingAddress = $this->cart?->shippingAddress;

        if (!$shippingAddress) {
            return;
        }

        if ($option = $shippingAddress->shipping_option) {
            return ShippingManifest::getOptions($this->cart)->first(function ($opt) use ($option) {
                return $opt->getIdentifier() == $option;
            });
        }

        return null;
    }

    public function getCartItem($product_id)
    {
        return Product::with([
            'variants.prices',
            'thumbnail',
            'defaultUrl',
        ])
            ->where('id', $product_id)
            ->first();
    }

    function updatedCouponCode($couponCode = null): void
    {
        $cart = \Lunar\Facades\CartSession::current();
        $cart->coupon_code = $couponCode ?? $this->couponCode;

        $cart->calculate();

        $this->mapLines();

        $cart->save();
    }

    function removeCoupons(): void
    {
        $cart = \Lunar\Facades\CartSession::current();
        $cart->coupon_code = '';
        $cart->save();
    }

    public function getStockForProduct($productVariantId)
    {

        $line = $this->cart->lines->firstWhere('purchasable_id', $productVariantId);

        if ($line && $line->purchasable) {
            return $line->purchasable->stock;
        }

        return 0;
    }

    public function relatedProducts()
    {

        return Product::with([
            'variants.prices',
            'thumbnail',
            'brand',
            'defaultUrl',
        ])
            ->limit(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
