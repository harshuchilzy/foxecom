<x-layouts.app.layout>
    <div class="pt-5 flex w-full justify-center">
        <h1 class="font-semibold text-[30px] text-[#111111]">Checkout</h1>
    </div>
    <div class="max-w-[1440px] mx-auto px-5 py-12 flex flex-col lg:flex-row gap-12 justify-center items-start">
        <div class="w-full lg:w-[60%] flex flex-col gap-3">
            <div>
                <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white text-gray-900" data-inactive-classes="text-gray-500">
                    {{-- Delivery Options Section --}}
                    <h2 id="accordion-delivery-options">
                        <button type="button" class="flex items-center justify-start w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                            <span class="font-semibold text-[24px] text-[#111111]">Delivery Option</span>
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 14.5C5 14.5 6.5 14.5 8.5 18C8.5 18 14.059 8.833 19 7" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </h2>
                    <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-delivery-options">
                        <div class="py-5 border-b border-gray-200">
                            <div class="lg:w-[40%] xl:w-[30%]">
                                <button class="border border-[#000000] bg-white rounded-[6px] flex items-center justify-center gap-4 w-full py-5">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 6L12.954 9.86C13.0344 10.1854 13.2215 10.4744 13.4854 10.6811C13.7493 10.8877 14.0748 11 14.41 11H20" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2 6H13.069C14.618 6 15.392 6 16.049 6.346C16.705 6.692 17.143 7.331 18.019 8.608C18.632 9.504 19.277 10.154 20.183 10.733C21.095 11.315 21.529 11.6 21.769 12.057C22 12.494 22 13.012 22 14.049C22 15.416 22 16.099 21.587 16.533L21.533 16.587C21.1 17 20.416 17 19.05 17M5 17C4.68 17 4.385 17 4.23 16.967C4.074 16.933 3.928 16.867 3.635 16.736L2 16C2 12.806 2.479 10.962 3.106 9.45C3.516 8.458 3.722 7.962 3.636 7.52C3.553 7.08 2.5 6 2.5 6M9 17H15" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17 19C18.1046 19 19 18.1046 19 17C19 15.8954 18.1046 15 17 15C15.8954 15 15 15.8954 15 17C15 18.1046 15.8954 19 17 19Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 19C8.10457 19 9 18.1046 9 17C9 15.8954 8.10457 15 7 15C5.89543 15 5 15.8954 5 17C5 18.1046 5.89543 19 7 19Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="text-[#111111] font-normal text-[16px]">Delivery</span>
                                </button>
                            </div>

                            <div class="py-5">
                                <form action="" class="flex flex-col gap-3">
                                    <div class="w-full">
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="Email" />
                                    </div>
                                    <div class="w-full flex items-center justify-between gap-4">
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="First Name" />
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="Last Name" />
                                    </div>
                                    <div class="w-full relative">
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4 pl-10" placeholder="Start typing address" />
                                        <div class="absolute top-3.5 md:top-5.5 left-4">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.0641 3.93601C9.66304 3.52755 9.18507 3.20259 8.65775 2.97989C8.13043 2.7572 7.56422 2.64119 6.99181 2.63856C6.41941 2.63593 5.85215 2.74673 5.32281 2.96457C4.79347 3.18241 4.31253 3.50296 3.90777 3.90772C3.50302 4.31248 3.18246 4.79341 2.96462 5.32276C2.74679 5.8521 2.63598 6.41935 2.63861 6.99176C2.64124 7.56417 2.75726 8.13038 2.97995 8.6577C3.20264 9.18501 3.5276 9.66299 3.93606 10.064C4.75123 10.8643 5.84945 11.3104 6.99181 11.3051C8.13417 11.2999 9.22825 10.8438 10.036 10.036C10.8438 9.2282 11.2999 8.13412 11.3052 6.99176C11.3104 5.8494 10.8644 4.75118 10.0641 3.93601ZM2.99339 2.99334C4.01527 1.97171 5.38883 1.37906 6.83318 1.33656C8.27753 1.29406 9.68356 1.80494 10.7637 2.76472C11.8439 3.7245 12.5166 5.06067 12.6443 6.49999C12.772 7.93931 12.3451 9.37305 11.4507 10.508L15.0141 14.0713L14.0714 15.014L10.5081 11.4507C9.37273 12.3417 7.94022 12.766 6.50277 12.6371C5.06531 12.5081 3.7312 11.8356 2.77258 10.7567C1.81396 9.67787 1.30306 8.27392 1.34409 6.83127C1.38512 5.38862 1.975 4.01598 2.99339 2.99334Z" fill="black"/></svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[#111111] font-normal text-[13px] underline">Enter address manually</p>
                                    </div>
                                    <div class="lg:w-[40%] xl:w-[30%]">
                                        <input type="tel" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="Phone number" />
                                    </div>
                                    <div class="lg:w-[40%] xl:w-[30%]">
                                        <button class="w-full bg-[#0066FF] rounded-[30px] h-[60px] text-white text-[16px] font-normal text-center">Save & Continue</button>
                                    </div>
                                </form>
                            </div>

                            <div>
                                <h3 class="font-semibold text-[16px] text-[#111111]">Delivery Address</h3>
                                <p class="font-semibold text-[16px] text-[#70707C]">Joseph Conniff-Jenkins</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">14 South Place</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">Porthcawl, CF36 3DB, GB</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">joecjenkins@hotmail.com</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">447564425877</p>
                            </div>

                            <div class="pt-5">
                                <h3 class="font-semibold text-[16px] text-[#111111]">Delivery</h3>
                                <p class="font-semibold text-[16px] text-[#70707C]">Free</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">Arrives by Tue 15 Apr</p>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Section --}}
                    <h2 id="accordion-flush-heading-2">
                        <button type="button" class="flex items-center justify-start w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                            <span class="font-semibold text-[24px] text-[#111111]">Payment</span>
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 14.5C5 14.5 6.5 14.5 8.5 18C8.5 18 14.059 8.833 19 7" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </h2>

                    <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                        <div class="py-5 border-b border-gray-200">
                            <div class="pt-3">
                                <h3 class="font-semibold text-[16px] text-[#111111]">Billing Country/Region</h3>
                                <p class="font-semibold text-[16px] text-[#70707C]">United Kingdom</p>
                            </div>
                            <div class="pt-3">
                                <h3 class="font-semibold text-[16px] text-[#111111]">Select payment method</h3>
                                <div class="flex items-center gap-4 py-2">
                                    <input checked id="default-radio-2" type="radio" value="" name="default-radio" class="w-4 h-4 text-black bg-gray-100 border-gray-300">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" /></svg>
                                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-black">Credit or Debit Card</label>
                                    </div>
                                </div>
                            </div>

                            <div class="my-3 border rounded-[7px] border-[#000000] p-5">
                                <form action="" class="flex gap-3">
                                    <div class="w-full">
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="Card Number" />
                                    </div>
                                    <div class="w-full flex items-center justify-between gap-4">
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="MM/YY" />
                                        <input type="text" class="border border-[#000000] bg-white rounded-[6px] w-full py-2 md:py-4" placeholder="CVC" />
                                    </div>
                                </form>
                            </div>

                            <div class="flex items-center">
                                <input checked id="checked-checkbox" type="checkbox" value="" class="w-4 h-4 text-black bg-gray-100 border-gray-300 rounded-sm">
                                <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900">Billing Address same as delivery</label>
                            </div>

                            <div class="pt-5">
                                <h3 class="font-semibold text-[16px] text-[#111111]">Payment Method</h3>
                                <div class="flex items-center justify-start gap-3">
                                    <img class="w-[20px]" src="{{ asset('images/mastercard.png') }}" alt="">
                                    <p>3963 Exp 04/2026</p>
                                </div>
                            </div>

                            <div class="pt-5">
                                <h3 class="font-semibold text-[16px] text-[#111111]">Delivery Address</h3>
                                <p class="font-semibold text-[16px] text-[#70707C]">Joseph Conniff-Jenkins</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">Church Street Hafod</p>
                                <p class="font-semibold text-[16px] text-[#70707C]">Porthcawl, CF36 5NP, GB</p>
                            </div>

                            <div class="lg:w-[40%] xl:w-[30%] mt-5">
                                <button class="w-full bg-[#0066FF] rounded-[30px] h-[60px] text-white text-[16px] font-normal text-center">Continue to Order Review</button>
                            </div>
                        </div>
                    </div>

                    {{-- Order Review Section --}}
                    <h2 id="accordion-flush-heading-3">
                        <button type="button" class="flex items-center justify-start w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 gap-3" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                            <span class="font-semibold text-[24px] text-[#111111]">Order Review</span>
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 14.5C5 14.5 6.5 14.5 8.5 18C8.5 18 14.059 8.833 19 7" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </h2>

                    <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                        <div class="py-5 border-b border-gray-200">
                            <div class="pt-5">
                                <p class="text-[16px] font-semibold text-[#70707C]">By clicking the 'Submit payment' button, you confirm that you have read, understand and accept our Terms of Use, Terms of Sale and Returns Policy, and acknowledge that you have read FOX ERGO's Privacy Policy.</p>
                            </div>
                            <div class="lg:w-[40%] xl:w-[30%] mt-5">
                                <button class="w-full bg-[#0066FF] rounded-[30px] h-[60px] text-white text-[16px] font-normal text-center">Submit Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full lg:w-[40%] flex flex-col gap-3">
            <h2 class="text-[#000000] font-bold text-[28px]">In Your Bag</h2>

            <div>
                <div class="w-full">
                    <div class="py-2 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">Subtotal</h3>
                        <p class="text-[14px] font-normal text-[#111111]">£0.00</p>
                    </div>

                    <div class="py-2 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">Estimated Delivery & Handling</h3>
                        <p class="text-[14px] font-normal text-[#111111]">£0.00</p>
                    </div>

                    <div class="py-2 flex justify-between items-center">
                        <h3 class="text-[16px] font-normal text-[#111111]">Total</h3>
                        <p class="text-[14px] font-normal text-[#111111]">£0.00</p>
                    </div>

                    <div class="pt-5">
                        <h3 class="text-[16px] font-normal text-[#111111] pb-5">Arrives by Sun, 13 Apr</h3>
                        <div class="flex gap-5 items-center justify-start">
                            <div class="">
                                <img class="w-[60px] h-[60px] object-contain" src="{{ asset('images/tiktokmagic.png') }}" alt="">
                            </div>
                            <div>
                                <h2 class="font-semibold text-[16px] text-black">Tick Tock 8K Magic - Lemon & Lime (Try For Free)</h2>
                                <p class="font-normal text-[16px] text-black">Qty: 1 @ £0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.layout>
