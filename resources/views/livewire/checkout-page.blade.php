<div
    x-data="{ currentStep: @entangle('currentStep'), showAddressEdit: @entangle('showAddressEdit'), deliveryOptionVerified: @entangle('deliveryOptionVerified') }">
    <div class="pt-5 flex w-full justify-center">
        <h1 class="font-bold text-[30px] text-[#111111]">Checkout</h1>
    </div>

    <div class="max-w-[1280px] mx-auto px-5 py-12 flex flex-col lg:flex-row gap-12 justify-center items-start">

        <div class="flex w-full lg:flex-row gap-20">
            {{-- <span class="gggg">{{$currentStep}}</span> --}}
            <div class="lg:w-[60%]" id="accordion-flush" data-accordion="collapse"
                 data-active-classes="bg-white text-gray-900" data-inactive-classes="text-gray-500">
                {{-- Delivery Options Section --}}
                <h2 id="accordion-delivery-options">
                    <button type="button"
                            @click="$wire.set('currentStep', 1), $wire.set('deliveryOptionVerified', false)"
                            class="flex cursor-pointer items-center justify-start w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3"
                            data-accordion-target="#accordion-flush-body-1" aria-expanded="true"
                            aria-controls="accordion-flush-body-1">
                        <span class="font-semibold text-[24px] text-[#111111]">Delivery Option</span>
                        <svg class="{{ $deliveryOptionVerified == true ? '' : 'hidden'}}" width="26" height="26"
                             viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 14.5C5 14.5 6.5 14.5 8.5 18C8.5 18 14.059 8.833 19 7" stroke="black"
                                  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-flush-body-1"
                     aria-labelledby="accordion-delivery-options">
                    <div class="py-5 border-b border-gray-200">

                        <div class="" delivery>
                            <div class="flex flex-col gap-3">
                                <div x-show="!showAddressEdit"
                                     class="{{ $currentStep != 1 ? 'hidden w-full relative' : 'w-full relative' }}">
                                    <ul class="flex text-sm font-medium text-center w-full pb-5"
                                        id="delivery-option-tab" data-tabs-toggle="#delivery-option-tab-content"
                                        data-tabs-active-classes="text-purple-600 hover:text-purple-600 border-purple-600"
                                        data-tabs-inactive-classes="text-gray-500 hover:text-gray-600 border-gray-100 hover:border-gray-300"
                                        role="tablist">
                                        <li class="me-2 w-1/2 border-black" role="presentation">
                                            <button
                                                class="border cursor-pointer rounded-[6px] flex items-center justify-center gap-4 w-full py-4"
                                                id="style-shipping-address-tab"
                                                data-tabs-target="#style-shipping-address" type="button" role="tab"
                                                aria-controls="profile" aria-selected="false">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 6L12.954 9.86C13.0344 10.1854 13.2215 10.4744 13.4854 10.6811C13.7493 10.8877 14.0748 11 14.41 11H20"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path
                                                        d="M2 6H13.069C14.618 6 15.392 6 16.049 6.346C16.705 6.692 17.143 7.331 18.019 8.608C18.632 9.504 19.277 10.154 20.183 10.733C21.095 11.315 21.529 11.6 21.769 12.057C22 12.494 22 13.012 22 14.049C22 15.416 22 16.099 21.587 16.533L21.533 16.587C21.1 17 20.416 17 19.05 17M5 17C4.68 17 4.385 17 4.23 16.967C4.074 16.933 3.928 16.867 3.635 16.736L2 16C2 12.806 2.479 10.962 3.106 9.45C3.516 8.458 3.722 7.962 3.636 7.52C3.553 7.08 2.5 6 2.5 6M9 17H15"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path
                                                        d="M17 19C18.1046 19 19 18.1046 19 17C19 15.8954 18.1046 15 17 15C15.8954 15 15 15.8954 15 17C15 18.1046 15.8954 19 17 19Z"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                    <path
                                                        d="M7 19C8.10457 19 9 18.1046 9 17C9 15.8954 8.10457 15 7 15C5.89543 15 5 15.8954 5 17C5 18.1046 5.89543 19 7 19Z"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                </svg>
                                                <span class="font-normal text-[16px] text-[#111111]">Delivery</span>

                                            </button>
                                        </li>

                                    </ul>

                                </div>

                                <div class="w-full shipping-address-select-wrapper">
                                    <div x-show="!showAddressEdit" class="{{ $currentStep != 1 ? 'hidden' : '' }}">
                                        <x-wui-select wire:model.live="selectedShippingAddress" label=""
                                                      placeholder="Start typing address"
                                                      :async-data="route('api.address.search')" option-label="address"
                                                      option-value="id"/>
                                    </div>
                                    {{-- Delivery Address --}}

                                    @if (isset($shipping['postcode']) && !empty($shipping['postcode']))
                                        <div class="py-5" x-show="!showAddressEdit">
                                            <h3 class="font-semibold text-[18px] text-[#111111] mb-2">
                                                {{ __('Delivery Address') }}</h3>

                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['first_name'] . ' ' . $shipping['last_name'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['company_name'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['line_one'] }} {{ $shipping['line_two'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['line_three'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">{{ $shipping['city'] }}
                                            </p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['state'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['postcode'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['contact_email'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['contact_phone'] }}</p>
                                            <p class="font-semibold text-[16px] text-[#70707C]">
                                                {{ $shipping['delivery_instructions'] }}</p>

                                        </div>
                                    @endif
                                    <div delivery class="{{ $currentStep != 1 ? 'hidden' : 'py-2' }}">
                                        <div x-show="!showAddressEdit">
                                            <button type="button" x-on:click="showAddressEdit = true"
                                                    class="text-[#111111] font-normal text-[13px] underline cursor-pointer">
                                                Enter address manually
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="showAddressEdit">
                                    {{-- Shipping Address Form --}}
                                    @include('partials.checkout.address', [
                                        'type' => 'delivery'
                                    ])

                                </div>

                            </div>

                            <div class="pt-5" x-show="!showAddressEdit">
                                {{-- <h3 class="font-semibold text-[16px] text-[#111111]">Delivery</h3>
                                <p class="font-semibold text-[16px] text-[#70707C]">Free</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">Arrives by Tue 15 Apr</p> --}}
                                @include('partials.checkout.shipping_option', ['step' => $steps['shipping_option']])
                            </div>


                            <a x-show="!showAddressEdit" @click="$wire.saveAndContinueToNext()"
                               class="{{ $currentStep != 1 ? 'hidden' : 'mt-3 block px-5 py-4 w-1/2 text-white bg-[#0066FF] h-14 text-[16px] text-inter cursor-pointer rounded-full hover:bg-blue-500 font-normal text-center' }}">Save
                                & Continue</a>

                        </div>
                    </div>
                </div>

                <h2 id="accordion-flush-heading-2">
                    <button type="button"
                            class="flex items-center cursor-pointer justify-start w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3"
                            data-accordion-target="#accordion-flush-body-2"
                            aria-expanded="false" aria-controls="accordion-flush-body-2">

                        <span class="font-semibold text-[24px] text-[#111111]">Payment</span>
                        <svg width="26" height="26"
                             viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 14.5C5 14.5 6.5 14.5 8.5 18C8.5 18 14.059 8.833 19 7" stroke="black"
                                  stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </h2>

                @include('partials.checkout.payment')

                {{-- Order Review Section --}}
                <h2 id="accordion-flush-heading-3">
                    <button type="button"
                            class="flex items-center justify-start w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3 cursor-pointer"
                            data-accordion-target="#accordion-flush-body-3" @click="$wire.set('currentStep', 3)"
                            aria-expanded="false" aria-controls="accordion-flush-body-3">
                        <span class="font-semibold text-[24px] text-[#111111]">Order Review</span>
                        {{-- <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 14.5C5 14.5 6.5 14.5 8.5 18C8.5 18 14.059 8.833 19 7" stroke="black"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> --}}
                    </button>
                </h2>

                <div id="accordion-flush-body-3"
                     {{--                     class="{{ $currentStep != 3 ? 'hidden' : '' }}"--}}
                     aria-labelledby="accordion-flush-heading-3">
                    <div class="py-5 border-b border-gray-200">
                        <div class="pt-5">
                            <p class="text-[16px] font-semibold text-[#70707C]">By clicking the 'Submit
                                payment'
                                button, you confirm that you have read, understand and accept our Terms of Use,
                                Terms of Sale and Returns Policy, and acknowledge that you have read FOX ERGO's
                                Privacy Policy.</p>
                        </div>
                        <div class="w-full mt-5"
                             x-data="{ isDisabled: true }"
                             @switchsubmitpaymentbtn.window="isDisabled = $event.detail.switch; console.log(isDisabled)"
                        >
                            <button
                                id="payBtn"
                                x-bind:disabled="isDisabled"
                                :class="isDisabled
                                  ? 'bg-gray-400 cursor-not-allowed'
                                  : '!bg-blue-500 hover:bg-blue-500 cursor-pointer'"
                                class="mt-3 block px-5 py-4 w-1/2 text-white h-14 text-[16px] text-inter rounded-full font-normal text-center transition-colors"
                                {{-- @click.prevent="$wire.checkout()" --}}
                            >
                                Enter card details
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            {{-- In Your Bag Section --}}
            {{--            <div class="w-full lg:w-[40%] flex flex-col gap-3">--}}
            {{--                <h2 class="text-[#000000] font-bold text-[24px]">In Your Bag</h2>--}}
            {{--                <div class="w-full">--}}
            {{--                    <div class="py-2 flex justify-between items-center">--}}
            {{--                        <h3 class="text-[16px] font-normal text-[#111111]">Subtotal</h3>--}}
            {{--                        <p class="text-[14px] font-normal text-[#111111]">{{ $cart?->subTotal->formatted() }}</p>--}}
            {{--                    </div>--}}

            {{--                    @if ($this->shippingOption)--}}
            {{--                        <div class="py-2 flex justify-between items-center">--}}
            {{--                            <h3 class="text-[16px] font-normal text-[#111111]">{{ $this->shippingOption->getDescription() }}</h3>--}}
            {{--                            <p class="text-[14px] font-normal text-[#111111]">{{ $this->shippingOption->getPrice()->formatted() }}</p>--}}
            {{--                        </div>--}}
            {{--                    @endif--}}

            {{--                    <div class="py-2 flex justify-between items-center">--}}
            {{--                        <h3 class="text-[16px] font-normal text-[#111111]">Total</h3>--}}
            {{--                        <p class="text-[14px] font-normal text-[#111111]">{{ $cart?->total->formatted() }}</p>--}}
            {{--                    </div>--}}

            {{--                    <div class="pt-5">--}}
            {{--                        <h3 class="text-[16px] font-normal text-[#111111] pb-5">Arrives by Sun, 13 Apr</h3>--}}

            {{--                        @foreach ( $cart?->lines as $line )--}}
            {{--                            --}}{{-- {{dd($line->purchasable->prices->first()->price)}} --}}
            {{--                            @php--}}
            {{--                                $product = $line->purchasable->product;--}}
            {{--                                $product_prices = $line->purchasable->prices->first();--}}

            {{--                                if ( $product_prices->compare_price?->decimal > 0 ) {--}}
            {{--                                    $product_price = $product_prices->compare_price->formatted;--}}
            {{--                                } else {--}}
            {{--                                    $product_price = $product_prices->price?->formatted();--}}
            {{--                                }--}}
            {{--                            @endphp--}}
            {{--                            <div class="flex gap-5 items-center justify-start">--}}
            {{--                                <div class="">--}}
            {{--                                    <img class="w-[60px] h-[60px] object-contain"--}}
            {{--                                         src="{{ $product->thumbnail?->getUrl() }}" alt="">--}}
            {{--                                </div>--}}
            {{--                                <div>--}}
            {{--                                    --}}{{-- <pre>--}}
            {{--                                    {{dd($line)}}--}}
            {{--                                    </pre> --}}
            {{--                                    <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate>--}}
            {{--                                        <h2--}}
            {{--                                            class="font-semibold text-[16px] text-black">{{ $product->translateAttribute('name') }} {{ $line->option ? ' - ' . $line->option : '' }}--}}
            {{--                                        </h2>--}}
            {{--                                    </a>--}}

            {{--                                    <p class="font-normal text-[16px] text-black">{{ 'Qty: ' . $line->quantity . ' @ ' . $product_price }}</p>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        @endforeach--}}

            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}


            <div class="w-full lg:w-[40%] flex flex-col gap-3">
                @php
                    // Total quantities
                    $totalQty = $cart?->lines->sum('quantity') ?? 0;
                    $freeQty  = $cart?->lines
                        ->filter(fn($L) => $L->meta['free'] ?? false)
                        ->sum('quantity') ?? 0;
                    $paidQty  = $totalQty - $freeQty;
                @endphp

                <h2 class="text-[#000000] font-bold text-[24px]">In Your Bag</h2>

                {{--                Total Products--}}
                <div class="py-2 flex justify-between items-center border-b">
                    <h3 class="text-[16px] font-normal text-[#111111]">Total Products</h3>
                    <p class="text-[14px] font-normal text-[#111111]">
                        {{ $totalQty }} items
                        <span class="text-[12px] text-gray-500">({{ $paidQty }} paid, {{ $freeQty }} free)</span>
                    </p>
                </div>

                {{--                Subtotal--}}
                <div class="py-2 flex justify-between items-center">
                    <h3 class="text-[16px] font-normal text-[#111111]">Subtotal</h3>
                    <p class="text-[14px] font-normal text-[#111111]">{{ $cart?->subTotal->formatted() }}</p>
                </div>

                {{--                Shipping--}}
                @if ($this->shippingOption)
                    <div class="py-2 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">
                            {{ $this->shippingOption->getDescription() }}
                        </h3>
                        <p class="text-[14px] font-normal text-[#111111]">
                            {{ $this->shippingOption->getPrice()->formatted() }}
                        </p>
                    </div>
                @endif

                    @if ($this->shippingOption)
                        <div class="py-2 flex justify-between items-center">
                            <h3 class="text-[16px] font-normal text-[#111111]">{{ $this->shippingOption->getName() }}</h3>
                            <p class="text-[14px] font-normal text-[#111111]">{{ $this->shippingOption->getPrice()->formatted() }}</p>
                        </div>
                    @endif

                    @if($cart?->taxBreakdown)
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

                {{--                Discount--}}
                @if ($cart?->discountTotal && $cart->discountTotal->value > 0)
                    <div class="py-2 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">Discount</h3>
                        <p class="text-[14px] font-normal text-[#111111]">
                            -{{ $cart->discountTotal->formatted() }}
                        </p>
                    </div>
                @endif

                {{--                Total--}}
                <div class="py-2 flex justify-between items-center border-b">
                    <h3 class="text-[16px] font-normal text-[#111111]">Total</h3>
                    <p class="text-[14px] font-normal text-[#111111]">{{ $cart?->total->formatted() }}</p>
                </div>

                <div class="pt-5">

                    {{--                    Line Items--}}
                    @foreach ($cart?->lines as $line)
                        @php
                            $product   = $line->purchasable->product;
                            $isFree    = $line->meta['free'] ?? false;

                            if ($isFree) {
                                $displayPrice = $line->unitPrice?->formatted() ?? '$0.00';
                                $priceLabel   = "{$displayPrice} (Free)";
                            } else {
                                $priceObj     = $product->prices->first();
                                $displayPrice = $priceObj->compare_price?->decimal > 0
                                    ? $priceObj->compare_price->formatted
                                    : $priceObj->price?->formatted();
                                $priceLabel   = $displayPrice;
                            }
                        @endphp

                        <div class="flex gap-5 items-center justify-start py-3 border-b last:border-none">
                            <div>
                                <img class="w-[60px] h-[60px] object-contain"
                                     src="{{ $product->thumbnail?->getUrl() }}"
                                     alt="{{ $product->translateAttribute('name') }}">
                            </div>
                            <div class="flex-1">
                                <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate>
                                    <h2 class="font-semibold text-[16px] text-black">
                                        {{ $product->translateAttribute('name') }}
                                        {{ $line->option ? ' - ' . $line->option : '' }}
                                        @if ($isFree)
                                            <span class="text-green-600 text-sm font-medium">(FREE)</span>
                                        @endif
                                    </h2>
                                </a>
                                <p class="font-normal text-[16px] text-black">
                                    Qty: {{ $line->quantity }} @ {{ $priceLabel }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


        </div>

    </div>


    {{-- <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3 lg:items-start">
                <div
                    class="px-6 py-8 space-y-4 bg-white border border-gray-100 lg:sticky lg:top-8 rounded-xl lg:order-last">
                    <h3 class="font-medium">
                        Order Summary
                    </h3>

                    <div class="flow-root">
                        <div class="-my-4 divide-y divide-gray-100">
                            @foreach ($cart->lines as $line)
                            <div class="flex items-center py-4" wire:key="cart_line_{{ $line->id }}">
                                <img class="object-cover w-16 h-16 rounded"
                                    src="{{ $line->purchasable->getThumbnail()->getUrl() }}" />

                                <div class="flex-1 ml-4">
                                    <p class="text-sm font-medium max-w-[35ch]">
                                        {{ $line->purchasable->getDescription() }}
                                    </p>

                                    <span class="block mt-1 text-xs text-gray-500">
                                        {{ $line->quantity }} @ {{ $line->subTotal->formatted() }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flow-root">
                        <dl class="-my-4 text-sm divide-y divide-gray-100">
                            <div class="flex flex-wrap py-4">
                                <dt class="w-1/2 font-medium">
                                    Sub Total
                                </dt>

                                <dd class="w-1/2 text-right">
                                    {{ $cart->subTotal->formatted() }}
                                </dd>
                            </div>

                            @if ($this->shippingOption)
                            <div class="flex flex-wrap py-4">
                                <dt class="w-1/2 font-medium">
                                    {{ $this->shippingOption->getDescription() }}
                                </dt>

                                <dd class="w-1/2 text-right">
                                    {{ $this->shippingOption->getPrice()->formatted() }}
                                </dd>
                            </div>
                            @endif

                            @foreach ($cart->taxBreakdown->amounts as $tax)
                            <div class="flex flex-wrap py-4">
                                <dt class="w-1/2 font-medium">
                                    {{ $tax->description }}
                                </dt>

                                <dd class="w-1/2 text-right">
                                    {{ $tax->price->formatted() }}
                                </dd>
                            </div>
                            @endforeach

                            <div class="flex flex-wrap py-4">
                                <dt class="w-1/2 font-medium">
                                    Total
                                </dt>

                                <dd class="w-1/2 text-right">
                                    {{ $cart->total->formatted() }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <div class="space-y-6 lg:col-span-2">
                    @include('partials.checkout.address', [
                    'type' => 'shipping',
                    'step' => $steps['shipping_address'],
                    ])

                    @include('partials.checkout.shipping_option', [
                    'step' => $steps['shipping_option'],
                    ])

                    @include('partials.checkout.address', [
                    'type' => 'billing',
                    'step' => $steps['billing_address'],
                    ])

                    @include('partials.checkout.payment', [
                    'step' => $steps['payment'],
                    ])
                </div>
            </div>
        </div>
        </div> --}}
</div>

