@php
    use Lunar\Models\ProductVariant;

    $bannerImage = $discount->data['banner_image'] ?? null;
    // $discountType = $discount->data['discount_type'] ?? 'percentage';
    $discountType = class_basename($discount->type); // e.g., "AmountOff"
    $couponAmount = $discount->data['coupon_amount'] ?? 0;
    $displayText = match ($discountType) {
        'percentage' => "{$couponAmount}% off",
        'fixed_cart' => "Save $ {$couponAmount} on cart",
        'fixed_product' => "${$couponAmount} off each item",
        default => "Redeem offer"
    };

    $product = optional($discount->purchasables?->first()?->purchasable?->product);

@endphp
<div class="w-full h-[100vh] relative" style="background-image: url('{{ asset('storage/' . $bannerImage) }}'); background-size: cover;">
    <div class="flex gap-5 items-center justify-between px-10 py-20 bg-no-repeat absolute top-[35%] right-0 offer-txt-bg">
        <div>
            <h2 class="text-[#FEE8FF] text-[32px] font-extrabold">{{ $discount->name }}</h2>
            <p class="font-bold text-white text-[24px]">{{ $displayText }}</p>

            {{-- If you plan to link to a product manually: --}}
            {{-- Optional: Create a `product_slug` field in discount->data --}}
            @php
                $productUrl = $product?->defaultUrl?->slug ?? $product?->slug ?? null;
            @endphp

            @php
                $couponCode = $discount->coupon; // assuming you want to support cart-wide discounts
            @endphp

            @if ($productUrl)
                <a href="{{ route('product.view', ['slug' => $productUrl]) }}?discount={{ $discount->id }}"
                class="bg-[#1275EE] rounded-[45px] px-12 py-3 text-white mt-4 inline-block">
                    Claim here
                </a>
            @elseif ($discountType === 'AmountOff' && $couponCode)
                <a href="{{ route('cart', ['discount' => $discount->id]) }}"
                    class="bg-[#1275EE] rounded-[45px] px-12 py-3 text-white mt-4 inline-block">
                    Claim here
                </a>
            @endif
        </div>

        <div>
            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 32L32 24M32 24L24 16M32 24H16M44 24C44 35.0457 35.0457 44 24 44C12.9543 44 4 35.0457 4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24Z"
                      stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>

    <style>
        .offer-txt-bg {
            background-image: url(/images/offer-text-bg.png);
            background-size: 100%;
            background-position: center;
        }
    </style>
</div>
