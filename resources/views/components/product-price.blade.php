<span {{ $attributes }}>
    @if ($price?->compare_price->decimal > 0)
        <p class="line-through text-[22px] md:text-[28px] font-normal text-black hidden md:block">
            {{ $price?->price->formatted() }}
        </p>
        <p class="text-[30px] md:text-[40px] text-[#1275EE] font-normal">
            {{ $price?->compare_price->formatted }}<span class="text-lg font-semibold "> + {{ __('VAT') }}</span>
        </p>
    @else
        <p class="text-[30px] md:text-[40px] text-[#1275EE] font-normal">
            {{ $price?->price->formatted() }}<span class="text-lg font-semibold "> + {{ __('VAT') }}</span>
        </p>
    @endif
</span>
