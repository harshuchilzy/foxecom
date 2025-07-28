@php
    use Lunar\Models\ProductVariant;
    use Lunar\Models\Product;
    use Lunar\Models\Url;

    $bannerImage = $discount->data['banner_image'] ?? null;
    $discountType = class_basename($discount->type);
    $couponAmount = $discount->data['coupon_amount'] ?? 0;
    $displayText = match ($discountType) {
        'percentage' => "{$couponAmount}% off",
        'fixed_cart' => "Save $ {$couponAmount} on cart",
        'fixed_product' => "${$couponAmount} off each item",
        default => "Redeem offer"
    };

    // Old variant-based logic
    /*
    $variantId = DB::table('lunar_discount_purchasables')
        ->where('discount_id', $discount->id)
        ->value('purchasable_id');

    $product = null;
    $productUrl = null;

    if ($variantId) {
        $variant = ProductVariant::with('product.defaultUrl')->find($variantId);
        $product = $variant?->product;

        if ($product) {
            $productUrl = optional($product->defaultUrl)->slug;

            if (!$productUrl) {
                $productUrl = Url::where('element_type', 'product')
                    ->where('element_id', $product->id)
                    ->where('default', true)
                    ->value('slug');
            }

            if (!$productUrl) {
                $productUrl = Url::where('element_type', 'product')
                    ->where('element_id', $product->id)
                    ->orderByDesc('default')
                    ->value('slug');
            }
        }
    }
    */

    // New logic: use lunar_discountables and lunar_urls directly
    $productId = DB::table('lunar_discount_purchasables')
            ->where('discount_id', $id)
            ->where('purchasable_type', 'product')
            ->value('purchasable_id');

    $productUrl = null;

    if ($productId) {
        $productUrl = Url::where('element_type', 'product')
            ->where('element_id', $productId)
            ->where('default', true)
            ->value('slug');

        if (!$productUrl) {
            $productUrl = Url::where('element_type', 'product')
                ->where('element_id', $productId)
                ->orderByDesc('default')
                ->value('slug');
        }
    }

    $couponCode = $discount->coupon;

@endphp
<div class="w-full h-[100vh] relative" style="background-image: url('{{ asset('storage/' . $bannerImage) }}'); background-size: cover; background-position: center;">
    <div class="block lg:hidden absolute top-8 left-5">
        <button onclick="window.history.back()">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="14" cy="14" r="14" fill="#D9D9D9" fill-opacity="0.5"/><path fill-rule="evenodd" clip-rule="evenodd" d="M11.343 13.9999L18.414 21.0709L17 22.4849L9.22199 14.7069C9.03451 14.5194 8.9292 14.2651 8.9292 13.9999C8.9292 13.7347 9.03451 13.4804 9.22199 13.2929L17 5.51489L18.414 6.92889L11.343 13.9999Z" fill="white"/></svg>
        </button>
    </div>
    <div class="hidden lg:flex gap-5 items-center justify-between px-10 py-26 bg-no-repeat absolute top-[35%] right-0 offer-txt-bg">
        <div class="claim-offer-label">
            <h2 class="text-[#FEE8FF] text-[32px] font-extrabold">{{ $discount->name }}</h2>
            <p class="font-bold text-white text-[24px]">{{ $displayText }}</p>

            @if (auth()->check())
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
            @else
                <a href="{{ route('register') }}"
                class="bg-[#1275EE] rounded-[45px] px-12 py-3 text-white mt-4 inline-block">
                    Register now
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

    <div class="lg:hidden absolute top-10/12 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
        <h1 class="text-white text-sm tracking-wider mb-2 absolute top-[15px] left-[85px] font-semibold">Slide to Claim Offer</h1>
        <input type="range" value="0" class="pullee mx-auto" placeholder="Slide to Claim Offer" />
    </div>

    <style>
        .offer-txt-bg {
            background-image: url(/images/offer-text-bg.png);
            background-size: 100%;
            background-position: center;
        }
        .pullee {
            width: 18rem;
            appearance: none;
        }
        .pullee:active::-webkit-slider-thumb {
            transform: scale(1.1);
            cursor: grabbing;
        }
        .pullee:focus {
            outline: none;
        }
        .pullee::-webkit-slider-thumb {
            appearance: none;
            display: block;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 100%;
            background-color: #3B82F6;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='15' height='12' viewBox='0 0 15 28' fill='none'><path d='M2.34 0C2.63883 -0.00096 2.93405 0.06499 3.20401 0.19304C3.47397 0.3211 3.7118 0.50802 3.9 0.74006L13.56 12.7401C13.8542 13.0979 14.015 13.5468 14.015 14.0101C14.015 14.4733 13.8542 14.9222 13.56 15.2801L3.56 27.2801C3.22056 27.6885 2.73274 27.9453 2.20389 27.9941C1.67503 28.0429 1.14847 27.8795 0.74 27.5401C0.33161 27.2006 0.07476 26.7128 0.026 26.1839C-0.02276 25.6551 0.14056 25.1285 0.48 24.7201L9.42 14.0001L0.78 3.28006C0.53548 2.98649 0.38012 2.62901 0.33236 2.24991C0.2846 1.87081 0.34644 1.48596 0.51055 1.14091C0.67466 0.79585 0.93418 0.50503 1.2584 0.30285C1.58262 0.10067 1.95797 -0.00441 2.34 0Z' fill='white'/></svg>");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 60%;
            transform: scale(1);
            transition: transform ease-out 100ms;
            cursor: grab;
        }
        .pullee::-webkit-slider-runnable-track {
            height: 2.5rem;
            border-radius: 2.5rem;
            background-color: #0a0019d1;
            padding: .25rem;
            box-sizing: content-box;
        }

        @media screen and (max-width: 1023px){
            header.w-full.bg-themeblack.text-white.relative {
                display: none !important;
            }
        }

    </style>
@if ($productUrl)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputRange = document.getElementsByClassName('pullee')[0],
                maxValue = 150,
                speed = 12,
                currValue, rafID;

            inputRange.min = 0;
            inputRange.max = maxValue;

            var authStatus = {{ auth()->check() ? 1 : 0 }};

            function unlockStartHandler() {
                window.cancelAnimationFrame(rafID);
                currValue = +this.value;
            }

            function unlockEndHandler() {
                currValue = +this.value;
                if (currValue >= maxValue) {
                    successHandler();
                } else {
                    rafID = window.requestAnimationFrame(animateHandler);
                }
            }

            function animateHandler() {
                inputRange.value = currValue;
                if (currValue > -1) {
                    window.requestAnimationFrame(animateHandler);
                }
                currValue = currValue - speed;
            }

            function successHandler() {
                if(authStatus) {
                    window.location.href = "{{ route('product.view', ['slug' => $productUrl]) }}?discount={{ $discount->id }}";
                } else {
                    window.location.href = "{{ route('register') }}";
                }
            }

            inputRange.addEventListener('mousedown', unlockStartHandler, false);
            inputRange.addEventListener('touchstart', unlockStartHandler, false);
            inputRange.addEventListener('mouseup', unlockEndHandler, false);
            inputRange.addEventListener('touchend', unlockEndHandler, false);
        });
    </script>
@endif
</div>
