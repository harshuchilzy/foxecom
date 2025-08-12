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
        $this->getProductUrl();
    }

    public function getProductUrl()
    {
        $this->productUrl = $this->discount->discountables?->where('type', 'condition')->first()?->discountable->defaultUrl->slug;
    
        if(empty($this->productUrl)){
            $this->productUrl = $this->discount->discountables?->where('type', 'reward')->first()?->discountable->defaultUrl->slug;
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
            'fixed_product' => "$ {$couponAmount} off each item",
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
