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

    // Get product variant from pivot table
    $variantId = DB::table('lunar_discountables')
        ->where('discount_id', $discount->id)
        ->value('discountable_id');

    $product = null;

    if ($variantId) {
        // $variant = ProductVariant::with('product')->find($variantId);
        $variant = ProductVariant::with('product.defaultUrl')->find($variantId);
        $product = $variant?->product;
    }

@endphp
<div class="w-full h-[90vh] lg:h-[100vh] relative" style="background-image: url('{{ asset('storage/' . $bannerImage) }}'); background-size: cover; background-position: center;">
    <div class="hidden lg:flex gap-5 items-center justify-between px-10 py-20 bg-no-repeat absolute top-[35%] right-0 offer-txt-bg">
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

    <div class="lg:hidden absolute top-3/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center">
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
            background: #3B82F6;
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var inputRange = document.getElementsByClassName('pullee')[0],
                maxValue = 150,
                speed = 12,
                currValue, rafID;

            inputRange.min = 0;
            inputRange.max = maxValue;

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
                window.location.href = "{{ route('product.view', ['slug' => $productUrl]) }}?discount={{ $discount->id }}";
            }

            inputRange.addEventListener('mousedown', unlockStartHandler, false);
            inputRange.addEventListener('touchstart', unlockStartHandler, false);
            inputRange.addEventListener('mouseup', unlockEndHandler, false);
            inputRange.addEventListener('touchend', unlockEndHandler, false);
        });
    </script>
</div>


