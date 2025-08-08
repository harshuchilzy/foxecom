<div>
    <span {{ $attributes }}>
        @if ($price?->compare_price->decimal > 0)
            <p class="line-through text-[22px] md:text-[28px] font-normal text-black hidden md:block">
                {{ $price?->price->formatted() }}
            </p>
            <p class="text-[30px] md:text-[40px] text-[#1275EE] font-normal">
                {{ $price?->compare_price->formatted }}<span class="text-lg font-semibold "> + VAT</span>
            </p>
        @else
            <p class="text-[30px] md:text-[40px] text-[#1275EE] font-normal">
                {{ $price?->price->formatted() }}<span class="text-lg font-semibold "> + VAT</span>
            </p>
        @endif
    </span>
</div>
@if ($outerBoxQty)
   <div class="bg-green-100 text-green-600 text-sm font-semibold py-1 rounded-full mt-2 clear-both inline-block px-4">
        Outer Case ({{ $outerBoxQty }} Units - £{{number_format(($price?->price->value/100) * $outerBoxQty, 2)}})
    </div> 
@endif
