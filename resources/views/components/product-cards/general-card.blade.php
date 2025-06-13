@props(['product'])
<div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
    <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
        <p class="font-semibold text-white text-[14px]">56% OFF</p>
    </div>
    <div class="p-3">
        <img class="w-full h-[180px] object-contain" src="{{ $product->images->first()->getUrl() }}" alt="">
    </div>
    <div class="bg-white rounded-b-[16px] p-3">
        <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">{{$product->translateAttribute('name')}}</h2>
        <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">{{$product->prices->first()->price->formatted}}</p>
        <hr>
        
        @php
            $price = $product->prices->first();
            $saveAmount =  $price->price->decimal - $price->compare_price->decimal;
            
        @endphp
        <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">
            Save - {{ $saveAmount > 0 ? $price->price->currency->code . ' ' . number_format($saveAmount / 100, 2) : $price->price->currency->code . ' 0.00' }}
        </p>
    </div>
</div>