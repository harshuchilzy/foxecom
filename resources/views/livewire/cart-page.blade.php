<div class="max-w-[1440px] mx-auto px-5 py-12 flex flex-col lg:flex-row gap-8 justify-center items-start">
    <div class="w-full lg:w-2/3 flex flex-col gap-3">
        <h2 class="text-[#000000] font-bold text-[28px]">Bag</h2>
        @if ($this->cart)
            {{dd($lines)}}
            @if ($lines)
                <div>
                    @foreach ($lines as $index => $line)
                        <div class="flex flex-row gap-8 border-b border-[#D9D9D9] pb-5">
                            <div class="bg-[#D9D9D9] w-1/3 flex justify-center items-center">
                                @if ($line['thumbnail'])
                                    <img class="w-[60%]" src="{{ $line['thumbnail'] }}" alt="">
                                @else 
                                    <img class="w-[60%]" src="{{ asset('images/placeholder.jpg') }}" alt="">
                                @endif
                            </div>
                            <div class="w-2/3 flex flex-col gap-2 justify-between">
                                <div>
                                    <h3 class="font-bold text-[16px] text-black">{{ $line['description'] }}</h3>
                                    <p class="font-normal text-[16px] text-black">{{ $line['identifier'] }} / {{ $line['options'] }}</p>
                                    <p class="font-normal text-[16px]">
                                        {{-- <span class="text-black">Availability:</span>
                                        <span class="text-[#249B3E]">In Stock</span> --}}
                                    </p>
                                </div>

                                <div class="flex flex-row gap-3 items-center mt-auto pb-3">
                                    <p class="font-normal text-[16px] text-black">Quantity</p>
                                    <div class="border border-[#757575] rounded-[50px] flex flex-row items-center gap-2 px-2 py-2 w-[80%] lg:w-[30%]" x-data="{quantity_{{$index}}: $wire.entangle('lines.{{ $index }}.quantity')}">
                                        <button class="px-2 border-r border-[#757575] cursor-pointer" @click="quantity_{{$index}}--">-</button>
                                        <input type="number" value="1" class="w-full text-center flex justify-center" wire:model.live="lines.{{ $index }}.quantity"/>
                                        <button class="px-2 border-l border-[#757575] cursor-pointer" @click="quantity_{{$index}}++">+</button>
                                    </div>
                                </div>
                                <button
                                    class="p-2 ml-auto text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-red-700 cursor-pointer"
                                    type="button" wire:click="removeLine('{{ $line['id'] }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach

                   
                    <div class="mt-4 space-y-4 text-center float-end">
                        <button
                            class="block py-3 px-6 cursor-pointer text-sm font-medium text-blue-800 border border-blue-600 rounded-[100px] hover:ring-1 hover:ring-blue-600"
                            type="button" wire:click="updateLines">
                            Update Cart
                        </button>
                    </div>
                    
                </div>
            @else
                <div>Cart is empty!</div>
            @endif
        @endif
    </div>
    <div class="w-full lg:w-1/3 flex flex-col gap-3">
        <h2 class="text-[#000000] font-bold text-[28px]">Summary</h2>

        <div>
            <div x-data="{ expanded: false }" class="w-full">
            <div class="flex justify-between items-center">
                <h2 class="text-[16px] font-normal text-[#111111]">Do you have a Promo Code?</h2>

                <button @click="expanded = !expanded" class="text-black focus:outline-none">
                    <template x-if="expanded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.708l-3.71 4.06a.75.75 0 11-1.1-1.02l4.25-4.65a.75.75 0 011.1 0l4.25 4.65c.28.3.27.77-.02 1.06z" clip-rule="evenodd" />
                        </svg>
                    </template>
                    <template x-if="!expanded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.65a.75.75 0 01-1.1 0L5.25 8.27a.75.75 0 01-.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </template>
                </button>
            </div>

            <div x-show="expanded" x-transition class="flex flex-row gap-4 items-center">
                <p class="text-gray-700 w-full">Coupon Code:</p>
                <input type="text" placeholder="Type here..." class="mt-2 w-full border rounded px-3 py-2 focus:outline-none focus:ring" />
            </div>

            <div class="py-3 flex justify-between items-center">
                <h3 class="text-[16px] font-normal text-[#111111]">Subtotal</h3>
                <p class="text-[14px] font-normal text-[#111111]">-</p>
            </div>

            <div class="py-3 flex justify-between items-center">
                <h3 class="text-[16px] font-normal text-[#111111]">Estimated Delivery & Handling</h3>
                <p class="text-[14px] font-normal text-[#111111]">FREE</p>
            </div>

            <hr>

            <div class="py-3 flex justify-between items-center">
                <h3 class="text-[16px] font-normal text-[#111111]">Total</h3>
                <p class="text-[14px] font-normal text-[#111111]">-</p>
            </div>

            <hr>

            <div class="flex flex-col gap-3 mt-5">
                <button class="bg-[#0066FF] w-full h-[50px] rounded-[30px] text-center text-white text-[16px] flex justify-center items-center">Checkout</button>
                <button class="bg-[#F5F5F5] w-full h-[50px] rounded-[30px] text-center text-white text-[16px] flex justify-center items-center">
                    <img src="{{ asset('images/paypal.png') }}" alt="">
                </button>
            </div>
        </div>
        </div>
    </div>
</div>
