<span {{ $attributes }}>
    <p class="line-through text-[22px] md:text-[28px] font-normal text-black hidden md:block">
        {{ $price?->price->formatted() }}
    </p>
    <p class="text-[30px] md:text-[40px] text-[#1275EE] font-normal">
        {{ $price?->compare_price->formatted }}
    </p>
</span>
