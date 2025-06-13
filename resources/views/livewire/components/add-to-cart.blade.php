<div>
    <div class="flex w-full">
        <button type="submit"
                class="bg-[#282828] px-[24px] h-12 rounded-[100px] text-white text-center text-[18px] font-bold !w-full md:w-1/2 cursor-pointer font-inter"
                wire:click.prevent="addToCart">
            Add to Cart
        </button>
    </div>

    @if ($errors->has('quantity'))
        <div class="p-2 mt-4 text-xs font-medium text-center text-red-700 rounded bg-red-50"
             role="alert">
            @foreach ($errors->get('quantity') as $error)
                {{ $error }}
            @endforeach
        </div>
    @endif
</div>
