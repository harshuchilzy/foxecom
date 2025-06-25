<div class="max-w-[1280px] relative mx-auto px-4">
    <div class="pt-5 flex w-full justify-start">
        <h1 class="font-semibold text-[30px] text-[#111111]">Your Orders</h1>
    </div>

    @if ($orderCount > 0)
        <div class="py-5 flex items-center gap-6 w-full">
            <p class="text-black text-[14px]">
                <span class="font-bold"></span>
                <span class="font-normal"><strong>{{sprintf('%02d', $orderCount)}} {{$orderCount == 1 ? 'order' : 'orders'}}</strong> placed in</span>
            </p>
            <div class="w-[60%] md:w-[25%] lg:w-[15%]">
                <form class="max-w-md mx-auto w-full">
                    <label for="underline_select" class="sr-only">Underline select</label>
                    <select id="underline_select" wire:model.live="timeFilter" class="block py-2.5 px-2 w-full text-sm text-black rounded-[6px] border bg-[#D9D9D9] border-[#D9D9D9] appearance-none focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                        <option value="all">All</option>
                        <option value="past-three-months">Past three months</option>
                        <option value="past-two-months">Past two months</option>
                        <option value="past-month">Past month</option>
                    </select>
                </form>
            </div>
        </div>
    @else
        <div class="py-5 text-[16px] text-gray-600 font-semibold">
            No orders found.
        </div>
    @endif

    <div class="flex gap-6 items-start flex-col md:flex-row">
        <div class="w-full md:w-[75%]">
            @foreach ($orders as $order)
                <x-product-cards.order-card :order="$order"/>
            @endforeach

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>

        <div class="w-full md:w-[25%]">
            {{-- {{dd($this->getRandomOrderItems())}} --}}
            <div class="border border-[#000000] rounded-[6px] p-5">
                <h2 class="font-inter font-semibold text-[16px] text-black">Buy it again</h2>

                @foreach ($this->getRandomOrderItems() as $orderItem)
                    <div class="flex gap-3 items-start py-3 flex-col lg:flex-row">
                        <img class="mx-auto w-[35%] lg:w-[25%]" src="{{ $orderItem->thumbnail->getUrl() }}" alt="">
                        <div class="flex flex-col gap-1 pr-5">
                            <a href="{{ route('product.view', $orderItem->defaultUrl->slug) }}"><p class="font-inter text-[#1275EE] font-normal text-[15px]">Lost Mary BM6000</p></a>
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lemon Lime</p>

                            <p class="text-black text-[14px] font-inter">
                                <span class="font-normal">Buy from </span>
                                <span class="font-bold">£8.59</span>
                            </p>
                            <p class="text-black text-[14px] font-normal font-inter">Purchased Jan 2025</p>

                            <button class="bg-[#1275EE] rounded-[12px] w-full py-1 text-white font-inter font-normal text-[12px]">Buy Again</button>
                        </div>
                    </div>
                @endforeach
                
            </div>
        </div>
    </div>
</div>
