@props(['product'])

@php
    $price = $product->prices->first();
    $comparePrice = $price->compare_price;
    $priceRange = $this->getPriceRangeForProducts($product);

    if ( $priceRange ) {
        if ($priceRange['basePrice']['min'] == $priceRange['basePrice']['max']) {
            $priceRangeFormatted = $priceRange['basePrice']['min_formatted'];
        } else {
            $priceRangeFormatted = $priceRange['basePrice']['min_formatted'] . ' - ' . $priceRange['basePrice']['max_formatted'];
        }
    } else {
        $priceRangeFormatted = $price->price->formatted;
    }

    if ( $priceRange ) {
        if ($priceRange['comparePrice']['min'] == $priceRange['comparePrice']['max']) {
            $salePriceRangeFormatted = $priceRange['comparePrice']['min_formatted'];
        } else {
            $salePriceRangeFormatted = $priceRange['comparePrice']['min_formatted'] . ' - ' . $priceRange['comparePrice']['max_formatted'];
        }
    } else {
        $salePriceRangeFormatted = $price->compare_price->formatted;
    }

    if ( $priceRange ) {
        if ( $priceRange['comparePrice']['min'] > 0 && $priceRange['comparePrice']['max'] > 0) {
            $hasDiscount = true;
        } else {
            $hasDiscount = false;
        }
    } else {
        $hasDiscount = $price->compare_price->decimal > 0;
    }

    $saveAmount = $hasDiscount ? ($price->price->decimal - $comparePrice->decimal) : 0;
    $discountPercentage = $hasDiscount ? round(($saveAmount / $price->price->decimal) * 100) : 0;
    
@endphp
{{-- {{dd($product->outer-box)}} --}}
<div class="bg-white border border-[#008ECC] rounded-[16px] relative group hover:shadow-lg transition-shadow overflow-hidden shadow-[0px_4px_45px_0px_#00000020]">
    @if($hasDiscount)
        <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px] z-10">
            <p class="font-semibold text-white text-[14px]">{{ $discountPercentage }}% OFF</p>
        </div>
    @endif

    <div class="p-3 hover:cursor-pointer bg-[#F5F5F5] ">
        <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate>
            <img
                class="w-full h-[180px] object-contain transition-transform group-hover:scale-105"
                src="{{ $product->thumbnail?->getUrl('small') }}"
                alt="{{ $product->translateAttribute('name') }}"
                loading="lazy"
            >
        </a>
    </div>

    <div class="bg-white rounded-b-[16px] p-3 space-y-2">
        <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate>
            <h2 class="text-[#222222] text-lg md:text-xl font-semibold line-clamp-2 min-h-[4rem] hover:cursor-pointer">
                {{ $product->translateAttribute('name') }}
            </h2>
        </a>

        @if (auth()->check())
            <div class="flex items-center gap-2 flex-wrap">
                @if($hasDiscount)
                    <span class="text-gray-400 text-sm line-through">
                        {{ $priceRangeFormatted }}
                    </span>
                @endif
                @if($hasDiscount)
                    <span class="text-[#1275EE] text-[16px] md:text-lg font-semibold">
                        {{ $salePriceRangeFormatted }} + VAT
                    </span>
                @else
                    <span class="text-[#1275EE] text-[16px] md:text-lg font-semibold">
                        {{ $priceRangeFormatted }} + VAT
                    </span>
                @endif
            </div>

            {{-- @if($hasDiscount)
                <hr class="border-gray-200">
                <p class="text-[#249B3E] font-semibold text-[16px] md:text-lg">
                    Save {{ $price->price->currency->code }} {{ number_format($saveAmount, 2) }}
                </p>
            @endif --}}
        @else
            <p class="text-[#1275EE] font-semibold text-[16px] md:text-lg">
                Register to see the price
            </p>
        @endif
    </div>
</div>
