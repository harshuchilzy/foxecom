<div>
    <div class="flex w-full">
        <div class="relative flex items-center" x-data="{ quantity : $wire.entangle('quantity') }">
            <button type="button" id="decrement-button" x-on:click="quantity > 1 ? quantity-- : 1" data-input-counter-decrement="quantity" class="bg-gray-50 border border-[#282828] text-gray-900 text-sm block px-[24px] rounded-tl-[100px] rounded-bl-[100px] h-12 cursor-pointer font-inter">
                <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/>
                </svg>
            </button>
            <input class="bg-gray-50 border-t border-b border-r-0 border-l-0 border-[#282828] text-gray-900 text-center text-sm block px-[24px] w-[30%] h-12 cursor-pointer font-inter"
                type="number"
                id="quantity"
                min="1"
                value="1"
                wire:model.live="quantity" />
            <button type="button" id="increment-button" x-on:click="quantity++" data-input-counter-increment="quantity" class="bg-gray-50 border border-[#282828] text-gray-900 text-sm block px-[24px] rounded-tr-[100px] rounded-br-[100px] h-12 cursor-pointer font-inter">
                <svg class="w-3 h-3 text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                </svg>
            </button>
        </div>
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
