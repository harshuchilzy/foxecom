@props(['order'])
<div class="w-full border border-[#008ECC] rounded-[6px] bg-white mb-3">
    <div class="bg-[#D9D9D966] rounded-tl-[6px] rounded-tr-[6px] p-4 flex justify-between flex-col md:flex-row gap-3 md:gap-0">
        <div class="flex gap-3 w-full md:w-[70%] lg:w-[50%]">
            <div class="flex flex-col gap-1 w-[30%]">
                <p class="font-inter text-normal text-[12px] text-black uppercase">Order Placed</p>
                <p class="font-inter text-normal text-[12px] text-black">{{date_format($order->created_at,"d F Y")}}</p>
            </div>
            <div class="flex flex-col gap-1 w-[20%]">
                <p class="font-inter text-normal text-[12px] text-black uppercase">Total</p>
                <p class="font-inter text-normal text-[12px] text-black">{{$order->total->formatted}}</p>
            </div>
            <div class="flex flex-col gap-1 w-[50%]">
                <p class="font-inter text-normal text-[12px] text-black uppercase">Dispatch to</p>
                <p class="font-inter text-normal text-[12px] text-black">{{$order->billingAddress->first_name}} {{$order->billingAddress->last_name}}</p>
                {{-- <pre>
                {{print_r($order->shippingAddress)}}
                </pre> --}}
            </div>
        </div>
        <div>
            <p class="font-inter text-normal text-[12px] text-black uppercase">ORDER: <span>{{$order->reference}}</span></p>
        </div>
    </div>

    <div class="p-5 flex gap-5 flex-col lg:flex-row">
        <div class="w-full lg:w-3/4">
            <div class="flex flex-col gap-1">
                <h3 class="font-inter font-semibold text-[16px]">{{ucfirst(str_replace('-', ' ', $order->status))}}</h3>
                <p class="font-inter font-normal text-[12px] text-black">{{$order->note}}</p>
            </div>
            @foreach($order->lines as $line)
                {{-- {{dd($line)}} --}}
                @if($line->type == 'physical')
                    @php
                        // $product = $this->getOrderItems($line->purchasable_id);
                        $product = $line->purchasable->product;
                    @endphp
                    <div class="flex justify-start py-4 flex-col md:flex-row gap-3 md:gap-1">
                        <img class="w-[50%] md:w-[20%] object-cover" src="{{ $product->thumbnail?->getUrl() }}" alt=""/>
                        <div>
                            <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate><p class="text-[15px] font-roboto font-semibold text-black">{{ $product->translateAttribute('name') }}</p></a>
                            <div class="relative overflow-x-auto py-2">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    @if($line->purchasable_type == 'product_variant')
                                        <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-1 py-2">
                                                    Flavours ordered :
                                                </th>
                                                <th scope="col" class="px-3 py-2 text-normal">
                                                    Quantity (Outers):
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white">
                                                <th scope="row" class="px-1 py-2 font-normal text-black whitespace-nowrap">
                                                    {{$line->option}}
                                                </th>
                                                <td class="px-1 py-2 text-black font-normal font-inter">
                                                    {{$line->unit_quantity}}
                                                </td>
                                            </tr>
                                        </tbody>

                                    @else

                                        <thead class="text-xs text-gray-900 uppercase dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-1 py-2">
                                                    Quantity (Outers):
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white">
                                                <th scope="row" class="px-1 py-2 font-normal text-black whitespace-nowrap">
                                                    {{$line->unit_quantity}}
                                                </th>
                                            </tr>
                                        </tbody>
                                    @endif
                                </table>
                            </div>

                            <div class="flex justify-start items-center gap-3">
                                <a href="" class="bg-[#FFD200] rounded-[15px] px-4 py-2 text-black font-roboto text-normal text-[12px]">Buy it again</a>
                                <a href="{{ route('product.view', $product->defaultUrl->slug) }}" class="bg-[#FFFFFF] border border-[#33A5D6] rounded-[15px] px-4 py-2 text-black font-roboto text-normal text-[12px]">View your item</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="w-full lg:w-1/4 flex flex-col gap-2">
            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">Track package</button>
            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">Return items</button>
            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">View Invoice</button>
            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">Leave a product review</button>
        </div>
    </div>
</div>
