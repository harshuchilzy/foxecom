<?php

namespace App\Livewire;

use Lunar\Models\Url;
use Livewire\Component;
use Lunar\Models\Product;
use Lunar\Models\Discount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfferPage extends Component
{
    /**
     * Discount collect
     */
    public Discount $discount;

    /**
     * Discount Id
     */
    public int $id;
    public $product = null; 
    public $productUrl = null;

    public function mount( int $id ): void
    {
        $this->discount = Discount::findOrFail($id);

        $productId = DB::table('lunar_discount_purchasables')
            ->where('discount_id', $id)
            ->where('purchasable_type', 'product')
            ->value('purchasable_id');

        if ($productId) {
            $this->product = Product::with('defaultUrl')->find($productId);
        }

        $this->discount->linked_product = $this->product;

        $this->getProductUrl();
    }

    public function getProductUrl()
    {
        if ($this->product->id) {
            $this->productUrl = Url::where('element_type', 'product')
                ->where('element_id', $this->product->id)
                ->where('default', true)
                ->value('slug');

            if (!$this->productUrl) {
                $this->productUrl = Url::where('element_type', 'product')
                    ->where('element_id', $this->product->id)
                    ->orderByDesc('default')
                    ->value('slug');
            }
        }

        if(empty($this->productUrl)){
            $this->productUrl = $this->discount->discountables?->where('type', 'reward')->first()->discountable->defaultUrl->slug;
        }

        return $this->productUrl;
        
    }


    public function render()
    {
        $bannerImage = $this->discount->data['banner_image'] ?? null;
        $mobileBannerImage = $this->discount->data['mobile_banner_image'] ?? $bannerImage;
        $discountType = class_basename($this->discount->type);
        $couponAmount = $discount->data['coupon_amount'] ?? 0;
        $couponCode = $this->discount->coupon;
        $displayText = match ($discountType) {
            'percentage' => "{$couponAmount}% off",
            'fixed_cart' => "Save $ {$couponAmount} on cart",
            'fixed_product' => "$ {$couponAmount } off each item",
            default => "Redeem offer"
        };

        return view('livewire.offer-page', [
            'bannerImage' => $bannerImage,
            'mobileBannerImage' => $mobileBannerImage,
            'discountType' => $discountType,
            'couponAmount' => $couponAmount,
            'displayText' => $displayText,
            'couponCode' => $couponCode
        ]);
    }
}
