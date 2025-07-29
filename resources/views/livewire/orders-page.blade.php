<div class="max-w-[1280px] relative mx-auto px-4">
    <div class="pt-5 flex w-full justify-start">
        <h1 class="font-semibold text-[30px] text-[#111111]">Your Orders</h1>
    </div>

    
    <div class="py-5 flex items-center gap-6 w-full">
        <p class="text-black text-[14px]">
            <span class="font-bold"></span>
            @if($orderCount > 0)
                <span class="font-normal"><strong>{{sprintf('%02d', $orderCount)}} {{$orderCount == 1 ? 'order' : 'orders'}}</strong> placed in</span>
            @else
                <span class="font-normal"><strong>0</strong> orders placed in</span>
            @endif
        </p>
        <div class="w-[60%] md:w-[25%] lg:w-[15%]">
            <label for="underline_select" class="sr-only">Underline select</label>
            <select id="underline_select" wire:model.live="timeFilter" class="block py-2.5 px-2 w-full text-sm text-black rounded-[6px] border bg-[#D9D9D9] border-[#D9D9D9] appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option value="all">All</option>
                <option value="past-three-months">Past three months</option>
                <option value="past-two-months">Past two months</option>
                <option value="past-month">Past month</option>
            </select>
        </div>
    </div>

    <div class="flex gap-6 items-start flex-col md:flex-row">
        <div class="w-full md:w-[75%]">
            @if ($orderCount > 0)
                @foreach ($orders as $order)
                    <x-product-cards.order-card :order="$order"/>
                @endforeach
            @else
                <div class="py-5 text-[16px] text-gray-600 font-semibold">
                    No orders found.
                </div>
            @endif

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>

        <div class="w-full md:w-[25%]">
            @php
            $orderItems = $this->getRandomOrderItems()
            @endphp
            <div class="border border-[#000000] rounded-[6px] p-5">
                <h2 class="font-inter font-semibold text-[16px] text-black">Buy it again</h2>
                @foreach ($orderItems as $orderItem)
                    <div class="flex gap-3 items-start py-3 flex-col lg:flex-row">
                        <img class="mx-auto w-[35%] lg:w-[25%]" src="{{ $orderItem['product']->thumbnail?->getUrl() }}" alt="">
                        <div class="flex flex-col gap-1 pr-5">
                            <a href="{{ route('product.view', $orderItem['product']->defaultUrl->slug) }}"><p class="font-inter text-[#1275EE] font-normal text-[15px]">{{ $orderItem['product']->translateAttribute('name') }}</p></a>
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">{{$orderItem['line'] ? $orderItem['line']->option : ''}}</p>

                            <p class="text-black text-[14px] font-inter">
                                <span class="font-normal">Buy from </span>
                                @php
                                    // if ($orderItem['product']->prices['compare_price'] > 0) {
                                    //     $productPrice = $orderItem['product']->compare_price->formatted;
                                    // } else {
                                    //     $productPrice = $orderItem['product']->price->formatted;
                                    // }
                                    //dd($orderItem['product']->prices->compare_price);
                                @endphp
                                <span class="font-bold">{{$orderItem['line'] ? $orderItem['line']->unit_price->formatted : ''}}</span>
                            </p>
                            <p class="text-black text-[14px] font-normal font-inter">{{ $orderItem['order_created_at'] ? 'Purchased ' . $orderItem['order_created_at']->format('M Y') : 'Not ordered yet'}}</p>

                            @if(!empty($orderItem['line']->purchasable))
                                <livewire:components.order-page-add-to-cart 
                                    :purchasable="$orderItem['line']->purchasable"
                                    wire:key="$orderItem['line']->purchasable_id"
                                    :quantity="$orderItem['line']->quantity"
                                    :type="'suggestBtn'"
                                />
                            @else
                                <a href="{{ route('product.view', $orderItem['product']->defaultUrl->slug) }}" class="bg-[#1275EE] rounded-[12px] w-full py-1 text-white font-inter font-normal text-[12px] text-center">Buy now</a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
