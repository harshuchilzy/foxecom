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
        // Log::info(print_r($this->discount, true));

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
        $productQuantity = $this->discount->data['min_qty'] ?? 0;
        $rewardQuantity = $this->discount->data['reward_qty'] ?? 0;
        $labelTitle = $this->discount->data['label_title'] ?? null;
        $labelContent = $this->discount->data['label_content'] ?? null;
        $claimed = (int)( (($this->discount->uses > 0 ? $this->discount->uses : 1) / ($this->discount->max_uses > 0 ? $this->discount->max_uses : 1)) * 100 );
        $displayText = match ($discountType) {
            'percentage' => "{$couponAmount}% off",
            'fixed_cart' => "Save {$couponAmount} on cart",
            'fixed_product' => "{$couponAmount} off each item",
            'BuyXGetY'     => "Buy {$productQuantity} Outers </br>Get {$rewardQuantity} FREE!",
            default => "Redeem offer"
        };

        return view('livewire.offer-page', [
            'bannerImage' => $bannerImage,
            'mobileBannerImage' => $mobileBannerImage,
            'discountType' => $discountType,
            'couponAmount' => $couponAmount,
            'displayText' => $displayText,
            'couponCode' => $couponCode,
            'claimed' => $claimed,
            'labelTitle' => $labelTitle,
            'labelContent' => $labelContent,
        ]);
    }
}
