<x-layouts.app.layout>
    <div class="max-w-[1280px] relative mx-auto px-4">
        <div class="pt-5 flex w-full justify-start">
            <h1 class="font-semibold text-[30px] text-[#111111]">Your Orders</h1>
        </div>

        <div class="py-5 flex items-center gap-6 w-full">
            <p class="text-black text-[14px]">
                <span class="font-bold">10 orders</span>
                <span class="font-normal"> placed in</span>
            </p>
            <div class="w-[60%] md:w-[25%] lg:w-[15%]">
                <form class="max-w-md mx-auto w-full">
                <label for="underline_select" class="sr-only">Underline select</label>
                <select id="underline_select" class="block py-2.5 px-2 w-full text-sm text-black rounded-[6px] border bg-[#D9D9D9] border-[#D9D9D9] appearance-nonefocus:outline-none focus:ring-0 focus:border-gray-200 peer">
                    <option selected>Past three months</option>
                    <option value="US">Past two months</option>
                    <option value="CA">Past month</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                </select>
                </form>
            </div>
        </div>

        <div class="flex gap-6 items-start flex-col md:flex-row">
            <div class="w-full md:w-[75%]">
                <div class="w-full border border-[#008ECC] rounded-[6px] bg-white">
                    <div class="bg-[#D9D9D966] rounded-tl-[6px] rounded-tr-[6px] p-4 flex justify-between flex-col md:flex-row gap-3 md:gap-0">
                        <div class="flex gap-3 w-full md:w-[70%] lg:w-[50%]">
                            <div class="flex flex-col gap-1 w-[30%]">
                                <p class="font-inter text-normal text-[12px] text-black uppercase">Order Placed</p>
                                <p class="font-inter text-normal text-[12px] text-black">10 April 2025</p>
                            </div>
                            <div class="flex flex-col gap-1 w-[20%]">
                                <p class="font-inter text-normal text-[12px] text-black uppercase">Total</p>
                                <p class="font-inter text-normal text-[12px] text-black">£144.99</p>
                            </div>
                            <div class="flex flex-col gap-1 w-[50%]">
                                <p class="font-inter text-normal text-[12px] text-black uppercase">Dispatch to</p>
                                <p class="font-inter text-normal text-[12px] text-black">Joseph Jenkins</p>
                            </div>
                        </div>
                        <div>
                            <p class="font-inter text-normal text-[12px] text-black uppercase">ORDER 7990-4458-7765</p>
                        </div>
                    </div>

                    <div class="p-5 flex gap-5 flex-col lg:flex-row">
                        <div class="w-full lg:w-3/4">
                            <div class="flex flex-col gap-1">
                                <h3 class="font-inter font-semibold text-[16px]">Delivered 11 April </h3>
                                <p class="font-inter font-normal text-[12px] text-black">The shopkeeper received your parcel</p>
                            </div>
                            <div class="flex justify-start py-4 flex-col md:flex-row gap-3 md:gap-1">
                                <img class="w-[50%] md:w-[20%] object-cover" src="{{ asset('images/elfbar1.png') }}" alt="">
                                <div>
                                    <p class="text-[15px] font-roboto font-semibold text-black">ELF BAR AF5000 Disposable Vape </p>
                                    <div class="relative overflow-x-auto py-2">
                                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                                                        Lemon Lime
                                                    </th>
                                                    <td class="px-1 py-2 text-black font-normal font-inter">
                                                        4
                                                    </td>
                                                </tr>
                                                <tr class="bg-white">
                                                    <th scope="row" class="px-1 py-2 font-normal text-black whitespace-nowrap">
                                                        Grape
                                                    </th>
                                                    <td class="px-1 py-2 text-black">
                                                        3
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="flex justify-start items-center gap-3">
                                        <button class="bg-[#FFD200] rounded-[15px] px-4 py-2 text-black font-roboto text-normal text-[12px]">Buy it again</button>
                                        <button class="bg-[#FFFFFF] border border-[#33A5D6] rounded-[15px] px-4 py-2 text-black font-roboto text-normal text-[12px]">View your item</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full lg:w-1/4 flex flex-col gap-2">
                            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">Track package</button>
                            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">Return items</button>
                            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">View Invoice</button>
                            <button class="border border-[#626262] rounded-[15px] bg-white text-black font-roboto text-normal text-[14px] w-full py-1">Leave a product review</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-[25%]">
                <div class="border border-[#000000] rounded-[6px] p-5">
                    <h2 class="font-inter font-semibold text-[16px] text-black">Buy it again</h2>
                    <div class="flex gap-3 items-start py-3 flex-col lg:flex-row">
                        <img class="mx-auto w-[35%] lg:w-[25%]" src="{{ asset('images/tiktokmagic.png') }}" alt="">
                        <div class="flex flex-col gap-1 pr-5">
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lost Mary BM6000</p>
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lemon Lime</p>

                            <p class="text-black text-[14px] font-inter">
                                <span class="font-normal">Buy from </span>
                                <span class="font-bold">£8.59</span>
                            </p>
                            <p class="text-black text-[14px] font-normal font-inter">Purchased Jan 2025</p>

                            <button class="bg-[#1275EE] rounded-[12px] w-full py-1 text-white font-inter font-normal text-[12px]">Buy Again</button>
                        </div>
                    </div>

                    <div class="flex gap-3 items-start py-3 flex-col lg:flex-row">
                        <img class="mx-auto w-[35%] lg:w-[25%]" src="{{ asset('images/tiktokmagic.png') }}" alt="">
                        <div class="flex flex-col gap-1 pr-5">
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lost Mary BM6000</p>
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lemon Lime</p>

                            <p class="text-black text-[14px] font-inter">
                                <span class="font-normal">Buy from </span>
                                <span class="font-bold">£8.59</span>
                            </p>
                            <p class="text-black text-[14px] font-normal font-inter">Purchased Jan 2025</p>

                            <button class="bg-[#1275EE] rounded-[12px] w-full py-1 text-white font-inter font-normal text-[12px]">Buy Again</button>
                        </div>
                    </div>

                    <div class="flex gap-3 items-start py-3 flex-col lg:flex-row">
                        <img class="mx-auto w-[35%] lg:w-[25%]" src="{{ asset('images/tiktokmagic.png') }}" alt="">
                        <div class="flex flex-col gap-1 pr-5">
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lost Mary BM6000</p>
                            <p class="font-inter text-[#1275EE] font-normal text-[15px]">Lemon Lime</p>

                            <p class="text-black text-[14px] font-inter">
                                <span class="font-normal">Buy from </span>
                                <span class="font-bold">£8.59</span>
                            </p>
                            <p class="text-black text-[14px] font-normal font-inter">Purchased Jan 2025</p>

                            <button class="bg-[#1275EE] rounded-[12px] w-full py-1 text-white font-inter font-normal text-[12px]">Buy Again</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.layout>
