@props(['relatedProduct'])

@php
    $priceRange = $this->getPriceRangeForProducts($relatedProduct);
@endphp

<div class="bg-white border border-[#008ECC] rounded-[16px] relative group hover:shadow-lg transition-shadow overflow-hidden shadow-[0px_4px_45px_0px_#00000020]">
   
    <div class="p-3 hover:cursor-pointer bg-[#F5F5F5] ">
        <a href="{{ route('product.view', $relatedProduct->defaultUrl->slug) }}" wire:navigate>
            <img
                class="w-full h-[180px] object-contain transition-transform group-hover:scale-105"
                src="{{ $relatedProduct->thumbnail?->getUrl('small') }}"
                alt="{{ $relatedProduct->translateAttribute('name') }}"
                loading="lazy"
            >
        </a>
    </div>

    <div class="bg-white rounded-b-[16px] p-3 space-y-2">
        <a href="{{ route('product.view', $relatedProduct->defaultUrl->slug) }}" wire:navigate>
            <h2 class="text-[#222222] text-lg md:text-xl font-semibold line-clamp-2 min-h-[4rem] hover:cursor-pointer">
                {{ $relatedProduct->translateAttribute('name') }}
            </h2>
        </a>

        @if (auth()->check())
            <div class="flex items-center gap-2 flex-wrap">
    
                @if(isset($priceRange['discount']) && !empty($priceRange['discount']))
                    <span class="text-gray-400 text-sm line-through">
                        {{ $priceRange['discount'] }}
                    </span>
                    <span class="text-[#1275EE] text-[16px] md:text-lg font-semibold">
                        {{ $priceRange['price'] }} + {{ __('VAT') }}
                    </span>
                @else
                    <span class="text-[#1275EE] text-[16px] md:text-lg font-semibold">
                        {{ $priceRange['price'] }} + {{ __('VAT') }}
                    </span>
                @endif
            </div>

        @else
            <p class="text-[#1275EE] font-semibold text-[16px] md:text-lg">
                {{ __('Register to see the price') }}
            </p>
        @endif
    </div>
</div>
