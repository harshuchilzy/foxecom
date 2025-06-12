<x-layouts.app.layout>
    <div class="max-w-[1440px] mx-auto px-5 py-12 flex flex-col lg:flex-row gap-8 justify-center items-start">
        <div class="w-full lg:w-2/3 flex flex-col gap-3">
            <h2 class="text-[#000000] font-bold text-[28px]">Bag</h2>
            <div>
                <div class="flex flex-row gap-8 border-b border-[#D9D9D9] pb-5">
                    <div class="bg-[#D9D9D9] w-1/3 flex justify-center items-center">
                        <img class="w-[60%]" src="{{ asset('images/tiktokmagic.png') }}" alt="">
                    </div>
                    <div class="w-2/3 flex flex-col gap-2 justify-between">
                        <div>
                            <h3 class="font-bold text-[16px] text-black">Tick Tock 8K Magic - Lemon & Lime</h3>
                            <p class="font-normal text-[16px] text-black">Box of 10</p>
                            <p class="font-normal text-[16px]">
                                <span class="text-black">Availability:</span>
                                <span class="text-[#249B3E]">In Stock</span>
                            </p>
                        </div>

                        <div class="flex flex-row gap-3 items-center mt-auto pb-3">
                            <p class="font-normal text-[16px] text-black">Quantity</p>
                            <div class="border border-[#757575] rounded-[50px] flex flex-row items-center gap-2 px-2 py-2 w-[80%] lg:w-[30%]">
                                <button class="px-2 border-r border-[#757575]">-</button>
                                <input type="number" value="1" class="w-full text-center flex justify-center"/>
                                <button class="px-2 border-l border-[#757575]">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row gap-8 border-b border-[#D9D9D9] py-5">
                    <div class="bg-[#D9D9D9] w-1/3 flex justify-center items-center">
                        <img class="w-[60%]" src="{{ asset('images/tiktokmagic.png') }}" alt="">
                    </div>
                    <div class="w-2/3 flex flex-col gap-2 justify-between">
                        <div>
                            <h3 class="font-bold text-[16px] text-black">Tick Tock 8K Magic - Lemon & Lime</h3>
                            <p class="font-normal text-[16px] text-black">Box of 10</p>
                            <p class="font-normal text-[16px]">
                                <span class="text-black">Availability:</span>
                                <span class="text-[#249B3E]">In Stock</span>
                            </p>
                        </div>

                        <div class="flex flex-row gap-3 items-center mt-auto pb-3">
                            <p class="font-normal text-[16px] text-black">Quantity</p>
                            <div class="border border-[#757575] rounded-[50px] flex flex-row items-center gap-2 px-2 py-2 w-[80%] lg:w-[30%]">
                                <button class="px-2 border-r border-[#757575]">-</button>
                                <input type="number" value="1" class="w-full text-center flex justify-center"/>
                                <button class="px-2 border-l border-[#757575]">+</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
</x-layouts.app.layout>
