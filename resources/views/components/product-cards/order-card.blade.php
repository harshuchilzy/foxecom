@props(['order'])
<div class="w-full border border-[#008ECC] rounded-[6px] bg-white mb-3">
    <div class="bg-[#D9D9D966] rounded-tl-[6px] rounded-tr-[6px] p-4 flex justify-between flex-col md:flex-row gap-3 md:gap-0">
        <div class="flex gap-3 w-full md:w-[70%] lg:w-[50%]">
            <div class="flex flex-col gap-1 w-[30%]">
                <p class="font-inter text-normal text-[12px] text-black uppercase">{{ __('Order Placed') }}</p>
                <p class="font-inter text-normal text-[12px] text-black">{{date_format($order->created_at,"d F Y")}}</p>
            </div>
            <div class="flex flex-col gap-1 w-[20%]">
                <p class="font-inter text-normal text-[12px] text-black uppercase">{{ __('Total') }}</p>
                <p class="font-inter text-normal text-[12px] text-black">{{$order->total->formatted}}</p>
            </div>
            <div class="flex flex-col gap-1 w-[50%]">
                <p class="font-inter text-normal text-[12px] text-black uppercase">{{ __('Dispatch to') }}</p>
                <p class="font-inter text-normal text-[12px] text-black">{{$order->billingAddress->first_name}} {{$order->billingAddress->last_name}}</p>
            </div>
        </div>
        <div>
            <p class="font-inter text-normal text-[12px] text-black uppercase">{{ __('ORDER:') }} <span>{{$order->reference}}</span></p>
        </div>
    </div>

    <div class="p-5 flex gap-5 flex-col lg:flex-row">
        <div class="w-full lg:w-3/4">
            <div class="flex flex-col gap-1">
                <h3 class="font-inter font-semibold text-[16px]">{{ucfirst(str_replace('-', ' ', $order->status))}}</h3>
                <p class="font-inter font-normal text-[12px] text-black">{{$order->note}}</p>
            </div>
            @foreach($order->lines as $line)
                @if($line->type == 'physical')
                    @php
                        $product = $line->purchasable->product;
                    @endphp
                    <div class="flex justify-start py-4 flex-col md:flex-row gap-3 md:gap-1">
                        <img class="w-[50%] md:w-[20%] object-cover" src="{{ $product->thumbnail?->getUrl('small') }}" alt=""/>
                        <div>
                            <a href="{{ route('product.view', $product->defaultUrl->slug) }}" wire:navigate><p class="text-[15px] font-roboto font-semibold text-black">{{ $product->translateAttribute('name') }}</p></a>
                            <div class="relative overflow-x-auto py-2">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                                    @if($line->purchasable_type == 'product_variant')
                                        <thead class="text-xs text-gray-900 uppercase">
                                            <tr>
                                                <th scope="col" class="px-1 py-2">
                                                    {{ __('Flavours ordered :') }}
                                                </th>
                                                <th scope="col" class="px-3 py-2 text-normal">
                                                    {{ __('Quantity (Outers):') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="bg-white">
                                                <th scope="row" class="px-1 py-2 font-normal text-black whitespace-nowrap">
                                                    {{$line->option}}
                                                </th>
                                                <td class="px-1 py-2 text-black font-normal font-inter">
                                                    {{$line->quantity}}
                                                </td>
                                            </tr>
                                        </tbody>

                                    @else
                                        <thead class="text-xs text-gray-900 uppercase">
                                            <tr>
                                                <th scope="col" class="px-1 py-2">
                                                    {{ __('Quantity (Outers):') }}
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

                            @php
                                if($line->purchasable_type == 'product_variant') {
                                    $formattedQuantity = $line->quantity;
                                } else {
                                    $formattedQuantity = $line->unit_quantity;
                                }
                            @endphp

                            <div class="flex justify-start items-center gap-3">
                                <livewire:components.order-page-add-to-cart
                                    :purchasable="$line->purchasable"
                                    wire:key="add-to-cart-{{ $line->id }}"
                                    :quantity="$formattedQuantity"
                                    :type="'orderBtn'"
                                />
                                <a href="{{ route('product.view', $product->defaultUrl->slug) }}" class="bg-[#FFFFFF] border border-[#33A5D6] rounded-[15px] px-4 py-2 text-black font-roboto text-normal text-[12px] hover:bg-[#D9D9D966] hover:shadow-lg">{{ __('View your item') }}</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <div class="w-full lg:w-1/4 flex flex-col gap-2">
            <button wire:click.prevent="downloadInvoice({{$order->id}})" class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1 cursor-pointer hover:bg-[#D9D9D966] hover:shadow-lg">
                <span wire:loading.remove wire:target="downloadInvoice()">{{ __('Download Invoice') }}</span>
                <span wire:loading wire:target="downloadInvoice()">{{ __('Downloading...') }}</span>
            </button>
        </div>
    </div>
</div>
