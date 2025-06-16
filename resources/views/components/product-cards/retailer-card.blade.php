@props(['relatedProduct'])
<div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] ">
    <div class="p-3">
        <a href="/products/{{$relatedProduct->id}}"><img class="w-full h-[180px] object-contain" src="{{ $relatedProduct->images->first()->getUrl() }}" alt=""></a>
    </div>
    <div class="bg-white rounded-b-[16px] p-3 h-[45%]">
        <a href="/products/{{$relatedProduct->id}}"><h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">{{$relatedProduct->translateAttribute('name')}}</h2></a>
        <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">{{$relatedProduct->prices->first()->price->formatted}}</p>
        <hr>
        <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
    </div>
</div>
