@props(['product'])

@php
    $price = $product->prices->first();
    $hasDiscount = $price->compare_price->decimal > 0;
    $comparePrice = $price->compare_price;
    $saveAmount = $hasDiscount ? ($price->price->decimal - $comparePrice->decimal) : 0;
    $discountPercentage = $hasDiscount ? round(($saveAmount / $price->price->decimal) * 100) : 0;
@endphp

<div class="bg-white border border-[#008ECC] rounded-[16px] relative group hover:shadow-lg transition-shadow overflow-hidden">
    @if($hasDiscount)
        <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px] z-10">
            <p class="font-semibold text-white text-[14px]">{{ $discountPercentage }}% OFF</p>
        </div>
    @endif

    <div class="p-3 hover:cursor-pointer bg-[#F5F5F5] ">
        <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate>
            <img 
                class="w-full h-[180px] object-contain transition-transform group-hover:scale-105" 
                src="{{ $product->thumbnail->getUrl() }}" 
                alt="{{ $product->translateAttribute('name') }}"
                loading="lazy"
            >
        </a>
    </div>

    <div class="bg-white rounded-b-[16px] p-3 space-y-2">
        <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate>
            <h2 class="text-[#222222] text-lg md:text-xl font-semibold line-clamp-2 min-h-[3rem] hover:cursor-pointer">
                {{ $product->translateAttribute('name') }}
            </h2>
        </a>

        <div class="flex items-center gap-2">
            @if($hasDiscount)
                <span class="text-gray-400 text-sm line-through">
                    {{ $price->price->formatted }}
                </span>
            @endif
            @if($hasDiscount)
                <span class="text-[#000000] text-[16px] md:text-[20px] font-normal ">
                    {{ $comparePrice->formatted }}
                </span>
            @else
                <span class="text-[#000000] text-[16px] md:text-[20px] font-normal ">
                    {{ $price->price->formatted }}
                </span>
            @endif
        </div>

        @if($hasDiscount)
            <hr class="border-gray-200">
            <p class="text-[#249B3E] font-semibold text-lg md:text-xl">
                Save {{ $price->price->currency->code }} {{ number_format($saveAmount, 2) }}
            </p>
        @endif
    </div>
</div>
