<div class="max-w-[1440px] mx-auto px-2 lg:px-5 py-6 lg:py-12">
    <div class="max-w-[1440px] mx-auto px-2 lg:px-5 py-6 lg:py-12 flex flex-col lg:flex-row gap-8 justify-center items-start">
        <div class="w-full lg:w-2/3 flex flex-col gap-3">
            <h2 class="text-[#000000] font-bold text-[28px] hidden lg:block">Bag</h2>
            <h2 class="text-[#000000] font-bold text-[28px] block lg:hidden text-center">Cart</h2>
            <div class="block lg:hidden absolute top-14 left-5">
                <button onclick="window.history.back()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.825 13L13.425 18.6L12 20L4 12L12 4L13.425 5.4L7.825 11H20V13H7.825Z" fill="black"/></svg>
                </button>
            </div>
            @if ($this->cart)
                @if ($lines)
                    <div>
                        @foreach ($lines as $index => $line)
                            <div class="flex flex-row gap-8 border-b border-[#D9D9D9] py-5 relative">
                                <div class="bg-[#D9D9D9] w-1/3 flex justify-center items-center">
                                    @if ($line['thumbnail'])
                                        <img class="w-[60%] object-contain lg:h-[200px]" src="{{ $line['thumbnail'] }}" alt="">
                                    @else
                                        <img class="w-[60%] object-contain lg:h-[200px]" src="{{ asset('images/placeholder.jpg') }}" alt="">
                                    @endif
                                </div>

                                <div class="w-2/3 flex flex-col gap-2 justify-between">
                                    <div>
                                        <h3 class="font-bold text-[16px] text-black">{{ $line['description'] }}</h3>
                                        <p class="font-normal text-[16px] text-black">
                                            {{ $line['identifier'] }} / {{ $line['options'] }}
                                        </p>
                                        <p class="font-normal text-[16px]">
                                            <span class="text-black">Availability:</span>
                                            <span class="text-[#249B3E]">In Stock</span>
                                        </p>
                                    </div>

                                    <div class="flex flex-row gap-3 items-center mt-auto pb-3">
                                        <p class="font-normal text-[16px] text-black">Quantity</p>

                                        @if (empty($line['meta']['free']))
                                            <div
                                                x-data="{
                                                idx: @js($index),
                                                qty: @js($line['quantity']),
                                                step: Math.max(1, @js($line['quantity_increment'])),
                                                init() {
                                                    Livewire.on('cartUpdated', () => {
                                                        if (! this.$el.isConnected) return;
                                                        const fresh = $wire.lines?.[this.idx]?.quantity;
                                                        if (typeof fresh === 'number') {
                                                            this.qty = fresh;
                                                        }
                                                    });
                                                },

                                                sanitize() {
                                                    let cleaned = String(this.qty).replace(/\D+/g, '');
                                                    if (!cleaned || +cleaned < this.step) cleaned = this.step;
                                                    this.qty = +cleaned;
                                                    this.sync();
                                                },

                                                snap() {
                                                    let snapped = Math.round(this.qty / this.step) * this.step;
                                                    if (snapped < this.step) snapped = this.step;
                                                    this.qty = snapped;
                                                    this.sync();
                                                },

                                                increment() {
                                                    this.qty += this.step;
                                                    this.sync();
                                                },

                                                decrement() {
                                                    if (this.qty - this.step >= this.step) {
                                                        this.qty -= this.step;
                                                        this.sync();
                                                    }
                                                },

                                                sync() {
                                                    $wire.set(`lines.${this.idx}.quantity`, this.qty);
                                                }
                                            }
                                                "
                                                class="border border-[#757575] rounded-[50px] flex flex-row items-center gap-2 px-1 py-1.5 w-[80%] lg:w-[30%]"
                                            >
                                                <button
                                                    class="px-2 border-0 border-[#757575] cursor-pointer text-3xl"
                                                    type="button"
                                                    @click="decrement()"
                                                    :disabled="qty <= step"
                                                >−</button>

                                                <input
                                                    x-model.number="qty"
                                                    x-on:input="sanitize()"
                                                    x-on:blur="snap()"
                                                    x-on:keydown.enter.prevent="snap()"
                                                    type="number"
                                                    :step="step"
                                                    :min="step"
                                                    inputmode="numeric"
                                                    pattern="\d*"
                                                    class="w-full text-center flex justify-center border-0 p-0 m-0 nobutton"
                                                />

                                                <button
                                                    class="px-2 border-0 border-[#757575] cursor-pointer text-3xl"
                                                    type="button"
                                                    @click="increment()"
                                                >＋</button>
                                            </div>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-md"
                                            >
                                                {{ $line['quantity'] }} FREE
                                            </span>
                                        @endif
                                    </div>

                                    @if (empty($line['meta']['free']))
                                        <button
                                            class="p-2 ml-auto text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-red-700 cursor-pointer"
                                            type="button"
                                            wire:click="removeLine('{{ $line['id'] }}')"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4 space-y-4 text-center float-end">
                            <button
                                class="block py-3 px-6 cursor-pointer text-sm font-medium text-blue-800 border border-blue-600 rounded-[100px] hover:ring-1 hover:ring-blue-600"
                                type="button"
                                wire:click="updateLines"
                            >
                                Update Cart
                            </button>
                        </div>

                        {{-- Alpine component (place once at the bottom of your page) --}}
                        <script>
                            function quantityControl(initial, step, idx) {
                            }
                        </script>
                    </div>
                @else
                    <div class="mt-4">Your bag is empty!</div>
                    <a href="{{ route('products.index')}}"
                       class="bg-[#11316d] hover:bg-[#1275EE] cursor-pointer text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-200 ease-in-out mt-2 max-w-fit">
                        Shop now
                    </a>
                @endif
            @else
                <div class="mt-4">Your bag is empty!</div>
                <a href="{{ route('products.index')}}"
                   class="bg-[#11316d] hover:bg-[#1275EE] cursor-pointer text-white font-semibold py-2 px-6 rounded-full shadow-md transition duration-200 ease-in-out mt-2 max-w-fit">
                    Shop now
                </a>
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.708l-3.71 4.06a.75.75 0 11-1.1-1.02l4.25-4.65a.75.75 0 011.1 0l4.25 4.65c.28.3.27.77-.02 1.06z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </template>
                            <template x-if="!expanded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 inline" viewBox="0 0 20 20"
                                     fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.292l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.65a.75.75 0 01-1.1 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </template>
                        </button>
                    </div>

                    <div x-show="expanded" x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="flex flex-row gap-4 items-center">
                        <p class="text-gray-700 w-full">Coupon Code:</p>
                        <input type="text" placeholder="Type here..." wire:model="couponCode"
                               class="mt-2 w-full border rounded px-3 py-2 focus:outline-none focus:ring"/>
                    </div>

                    <div class="py-3 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">Subtotal</h3>
                        <p class="text-[14px] font-normal text-[#111111]">{{$this->cart?->subTotal->formatted()}}</p>
                    </div>

                    @if ($this->shippingOption)
                        <div class="py-3 flex justify-between items-center">
                            <h3 class="text-[16px] font-normal text-[#111111]">{{ $this->shippingOption->getDescription() }}
                            </h3>
                            <p class="text-[14px] font-normal text-[#111111]">{{
                            $this->shippingOption->getPrice()->formatted() }}</p>
                        </div>
                    @else
                        {{-- <div class="py-3 flex justify-between items-center">
                            <h3 class="text-[16px] font-normal text-[#111111]">Estimated Delivery & Handling</h3>
                            <p class="text-[14px] font-normal text-[#111111]">FREE</p>
                        </div> --}}
                    @endif

                    @if ($this->cart?->discountTotal && $this->cart?->discountTotal->value > 0)
                        <div class="py-3 flex justify-between items-center">
                            <div class="flex gap-4 items-center">
                                <h3 class="text-[16px] font-normal text-[#111111]">{{ __('Discount') }}</h3>
                                <x-wui-mini-button rounded 2xs negative icon="x-mark" wire:click="removeCoupons"/>
                            </div>
                            <p class="text-[14px] font-normal text-[#111111]">-{{ $this->cart?->discountTotal->formatted()
                            }}</p>
                        </div>
                    @endif

                    @if($this->cart?->taxBreakdown)
                        @foreach ($this->cart?->taxBreakdown->amounts as $tax)
                            <div class="py-3 flex justify-between items-center">
                                <h3 class="text-[16px] font-normal text-[#111111]">
                                    {{ $tax->description }} : {{ $tax->percentage }}%
                                </h3>

                                <p class="text-[14px] font-normal text-[#111111]">
                                    {{ $tax->price->formatted() }}
                                </p>
                            </div>
                        @endforeach
                    @endif

                    <hr>

                    <div class="py-3 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">Total</h3>
                        <p class="text-[14px] font-normal text-[#111111]">{{$this->cart?->total->formatted()}}</p>
                    </div>

                    <hr>

                    <div class="flex flex-col gap-3 mt-5">
                        <a href="{{ route('checkout.view') }}"
                           class="bg-[#0066FF] w-full h-[50px] rounded-[30px] text-center text-white text-[16px] flex justify-center items-center">Checkout</a>
                        <button
                            class="bg-[#F5F5F5] w-full h-[50px] rounded-[30px] text-center text-white text-[16px] flex justify-center items-center">
                            <img src="{{ asset('images/paypal.png') }}" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <di class="hidden lg:block">
        <h2 class="font-bold text-[28px] text-black mb-5">You Might Also Like</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if (count($this->relatedProducts()) > 0)
                @foreach ($this->relatedProducts() as $relatedProduct)
                    @php
                        $productUrl = $relatedProduct?->defaultUrl?->slug;
                    @endphp
                    <div>
                        <div class="bg-[#F6F6F6]">
                            <a href="{{ route('product.view', ['slug' => $productUrl]) }}">
                                @if($relatedProduct->thumbnail)
                                    <img class="object-contain h-[320px] lg:h-[400px]" src="{{ $relatedProduct->thumbnail->getUrl() }}" alt="">
                                @else
                                    <img class="object-contain h-[320px] lg:h-[400px]" src="{{ asset('images/a87364c32f2e8ab940fc2972ecaaa2ab07e6fa92.png') }}" alt="">
                                @endif
                            </a>
                        </div>
                        <div class="py-3 flex flex-col gap-1 px-1">
                            <h2 class="text-black font-bold text-lg">{{$relatedProduct->brand?->translate('name')}}</h2>
                            <a href="{{ route('product.view', ['slug' => $productUrl]) }}">
                                <p class="text-black font-normal text-base">{{ $relatedProduct->translate('name') }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div>
                    Items not found.
                </div>
            @endif
        </div>
        <div class="w-full text-right mt-6"><a class="text-themeblue text-[16px]  font-bold" href="{{ route('products.index') }}"><div class="flex items-center justify-end">Continue Shopping <svg width="16px" height="16px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="#1275EE"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill="#1275EE" fill-rule="evenodd" d="M5.29289,3.70711 C4.90237,3.31658 4.90237,2.68342 5.29289,2.29289 C5.68342,1.90237 6.31658,1.90237 6.70711,2.29289 L11.7071,7.29289 C12.0976,7.68342 12.0976,8.31658 11.7071,8.70711 L6.70711,13.7071 C6.31658,14.0976 5.68342,14.0976 5.29289,13.7071 C4.90237,13.3166 4.90237,12.6834 5.29289,12.2929 L9.58579,8 L5.29289,3.70711 Z"></path> </g></svg></div></a></div>

        <style>
            @media screen and (max-width: 1023px){
                header.w-full.bg-themeblack.text-white.relative {
                    display: none !important;
                }
            }
        </style>
    </div>
</div>
