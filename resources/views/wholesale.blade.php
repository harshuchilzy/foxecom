<x-layouts.app.layout>
    <div class="w-full h-[320px] wholesale-hero-img bg-no-repeat"></div>

    <div class="bg-[#D9D9D97D] py-8">
        <div class="">
            <h2 class="text-center text-[20px] lg:text-[28px]">
                <span class="font-bold text-black">Wholesale Spotlight.</span>
                <span class="font-semibold text-[#6E6E73] italic">Our best sellers</span>
            </h2>
        </div>


        <div class="swiper mySecondSwiper px-5">
            <div class="swiper-wrapper py-8 px-5">
                <div class="swiper-slide">
                    <img class="w-[90%] h-[220px] rounded-[4px] object-cover shadow-xl" src="{{ asset('images/bigpuffcat.png') }}" alt="Big Puff" />
                    <p class="text-left mt-2 text-[28px] font-semibold">Big Puff</p>
                </div>
                <div class="swiper-slide">
                    <img class="w-[90%] h-[220px] rounded-[4px] object-cover" src="{{ asset('images/liquidcat.jpg') }}" alt="Liquids" />
                    <p class="text-left mt-2 text-[28px] font-semibold">Liquids</p>
                </div>
                <div class="swiper-slide">
                    <img class="w-[90%] h-[220px] rounded-[4px] object-cover" src="{{ asset('images/snuscat.jpg') }}" alt="Liquids" />
                    <p class="text-left mt-2 text-[28px] font-semibold">Snus</p>
                </div>
                <div class="swiper-slide">
                    <img class="w-[90%] h-[220px] rounded-[4px] object-cover" src="{{ asset('images/candy.png') }}" alt="Liquids" />
                    <p class="text-left mt-2 text-[28px] font-semibold">Candy</p>
                </div>
                <div class="swiper-slide">
                    <img class="w-[90%] h-[220px] rounded-[4px] object-cover" src="{{ asset('images/liquidcat.jpg') }}" alt="Liquids" />
                    <p class="text-left mt-2 text-[28px] font-semibold">Liquids</p>
                </div>
                <div class="swiper-slide">
                    <img class="w-[90%] h-[220px] rounded-[4px] object-cover shadow-xl" src="{{ asset('images/bigpuffcat.png') }}" alt="Big Puff" />
                    <p class="text-left mt-2 text-[28px] font-semibold">Big Puff</p>
                </div>
            </div>

        </div>

        <div class="max-w-[1280px] relative mx-auto">
            <div class="w-full relative">
                <span class="absolute top-1/2 left-1 transform -translate-y-1/2">
                    <svg width="35" height="35" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 29C25.4183 29 29 25.4183 29 21C29 16.5817 25.4183 13 21 13C16.5817 13 13 16.5817 13 21C13 25.4183 16.5817 29 21 29Z" stroke="#ABB7C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M31.0002 31.0002L26.7002 26.7002" stroke="#ABB7C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <input type="text" class="w-full h-[50px] pl-10 text-[16px] border border-[#FFFFFF66] rounded-[32px] focus:outline-none focus:border-[#6E6E73]" placeholder="Search for products..." />
                <span class="absolute top-1/2 right-2 transform -translate-y-1/2">
                    <svg width="35" height="35" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M31 14H24" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 14H13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 22H22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 22H13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 30H26" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M22 30H13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 12V16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 20V24" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M26 28V32" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
            </div>

            <div class="pt-6 w-full flex justify-center items-center gap-5">
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="filter_select" class="sr-only">Filter select</label>
                        <select id="filter_select" class="block py-2 w-full text-sm text-[#000000] font-semibold text-[18px] px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option selected>Filter</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg width="30" height="30" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.25 11.6665C6.25 11.335 6.3817 11.017 6.61612 10.7826C6.85054 10.5482 7.16848 10.4165 7.5 10.4165H32.5C32.8315 10.4165 33.1495 10.5482 33.3839 10.7826C33.6183 11.017 33.75 11.335 33.75 11.6665C33.75 11.998 33.6183 12.316 33.3839 12.5504C33.1495 12.7848 32.8315 12.9165 32.5 12.9165H7.5C7.16848 12.9165 6.85054 12.7848 6.61612 12.5504C6.3817 12.316 6.25 11.998 6.25 11.6665ZM10.4167 19.9998C10.4167 19.6683 10.5484 19.3504 10.7828 19.116C11.0172 18.8815 11.3351 18.7498 11.6667 18.7498H28.3333C28.6649 18.7498 28.9828 18.8815 29.2172 19.116C29.4516 19.3504 29.5833 19.6683 29.5833 19.9998C29.5833 20.3314 29.4516 20.6493 29.2172 20.8837C28.9828 21.1181 28.6649 21.2498 28.3333 21.2498H11.6667C11.3351 21.2498 11.0172 21.1181 10.7828 20.8837C10.5484 20.6493 10.4167 20.3314 10.4167 19.9998ZM15.4167 28.3332C15.4167 28.0016 15.5484 27.6837 15.7828 27.4493C16.0172 27.2149 16.3351 27.0832 16.6667 27.0832H23.3333C23.6649 27.0832 23.9828 27.2149 24.2172 27.4493C24.4516 27.6837 24.5833 28.0016 24.5833 28.3332C24.5833 28.6647 24.4516 28.9826 24.2172 29.2171C23.9828 29.4515 23.6649 29.5832 23.3333 29.5832H16.6667C16.3351 29.5832 16.0172 29.4515 15.7828 29.2171C15.5484 28.9826 15.4167 28.6647 15.4167 28.3332Z" fill="black"/></svg>
                        </span>
                    </form>
                </div>
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="sort_select" class="sr-only">Sort select</label>
                        <select id="sort_select" class="block py-2 w-full text-sm text-[#000000] font-semibold text-[18px] px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option selected>Sort</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.3674 8.11859C12.1003 7.8079 11.9502 7.38657 11.9502 6.94725C11.9502 6.50793 12.1003 6.0866 12.3674 5.77591L16.6424 0.805597C16.7738 0.647359 16.9311 0.521142 17.1049 0.434313C17.2788 0.347483 17.4658 0.301779 17.655 0.299867C17.8442 0.297956 18.0318 0.339875 18.207 0.423179C18.3821 0.506483 18.5412 0.629503 18.675 0.785062C18.8088 0.940621 18.9146 1.1256 18.9863 1.32921C19.0579 1.53282 19.094 1.75099 19.0923 1.97097C19.0907 2.19096 19.0514 2.40836 18.9767 2.61049C18.902 2.81262 18.7934 2.99544 18.6573 3.14827L14.3824 8.11859C14.1151 8.42918 13.7527 8.60367 13.3749 8.60367C12.997 8.60367 12.6346 8.42918 12.3674 8.11859Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M22.9321 8.1184C22.6649 8.42899 22.3025 8.60348 21.9247 8.60348C21.5468 8.60348 21.1844 8.42899 20.9172 8.1184L16.6422 3.14808C16.3826 2.83561 16.239 2.41711 16.2422 1.98271C16.2455 1.54831 16.3954 1.13277 16.6596 0.825589C16.9238 0.51841 17.2812 0.344169 17.6548 0.340395C18.0284 0.33662 18.3884 0.503613 18.6571 0.805407L22.9321 5.77572C23.1993 6.08641 23.3493 6.50774 23.3493 6.94706C23.3493 7.38638 23.1993 7.80771 22.9321 8.1184Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.6492 3.63379C18.0272 3.63379 18.3896 3.80834 18.6569 4.11905C18.9241 4.42975 19.0742 4.85116 19.0742 5.29056V18.5447C19.0742 18.9841 18.9241 19.4055 18.6569 19.7162C18.3896 20.0269 18.0272 20.2015 17.6492 20.2015C17.2713 20.2015 16.9089 20.0269 16.6416 19.7162C16.3744 19.4055 16.2242 18.9841 16.2242 18.5447V5.29056C16.2242 4.85116 16.3744 4.42975 16.6416 4.11905C16.9089 3.80834 17.2713 3.63379 17.6492 3.63379ZM11.5317 15.7166C11.7989 16.0273 11.949 16.4486 11.949 16.888C11.949 17.3273 11.7989 17.7486 11.5317 18.0593L7.25675 23.0296C6.98799 23.3314 6.62804 23.4984 6.25441 23.4946C5.88078 23.4909 5.52337 23.3166 5.25917 23.0094C4.99496 22.7022 4.8451 22.2867 4.84185 21.8523C4.8386 21.4179 4.98224 20.9994 5.24181 20.6869L9.51679 15.7166C9.78402 15.406 10.1464 15.2315 10.5243 15.2315C10.9021 15.2315 11.2645 15.406 11.5317 15.7166Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M0.967024 15.7165C1.23425 15.4059 1.59664 15.2314 1.97449 15.2314C2.35235 15.2314 2.71474 15.4059 2.98197 15.7165L7.25695 20.6868C7.39305 20.8397 7.50161 21.0225 7.57629 21.2246C7.65098 21.4268 7.69029 21.6442 7.69193 21.8641C7.69357 22.0841 7.65752 22.3023 7.58587 22.5059C7.51422 22.7095 7.40841 22.8945 7.27461 23.05C7.14082 23.2056 6.98171 23.3286 6.80659 23.4119C6.63146 23.4952 6.44382 23.5372 6.25461 23.5352C6.0654 23.5333 5.87841 23.4876 5.70455 23.4008C5.5307 23.314 5.37346 23.1878 5.24201 23.0295L0.967024 18.0592C0.699878 17.7485 0.549805 17.3272 0.549805 16.8879C0.549805 16.4485 0.699878 16.0272 0.967024 15.7165Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.24921 20.2015C5.87128 20.2015 5.50883 20.0269 5.24159 19.7162C4.97435 19.4055 4.82422 18.9841 4.82422 18.5447V5.29056C4.82422 4.85116 4.97435 4.42975 5.24159 4.11905C5.50883 3.80834 5.87128 3.63379 6.24921 3.63379C6.62715 3.63379 6.9896 3.80834 7.25684 4.11905C7.52407 4.42975 7.67421 4.85116 7.67421 5.29056V18.5447C7.67421 18.9841 7.52407 19.4055 7.25684 19.7162C6.9896 20.0269 6.62715 20.2015 6.24921 20.2015Z" fill="black"/></svg>
                        </span>
                    </form>
                </div>
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="price_select" class="sr-only">Price select</label>
                        <select id="price_select" class="block py-2 w-full text-sm text-[#000000] font-semibold text-[18px] px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option selected>Price</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>
                        </span>
                    </form>
                </div>
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="brand_select" class="sr-only">Brand select</label>
                        <select id="brand_select" class="block py-2 w-full text-sm text-[#000000] font-semibold text-[18px] px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option selected>Brands</option>
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="FR">France</option>
                            <option value="DE">Germany</option>
                        </select>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-[1280px] mx-auto px-2 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
            {{-- <x-product-cards.retailer-card /> --}}
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/titan10k.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/elfbar1.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] ">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/titan10k.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/elfbar1.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] ">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/titan10k.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/elfbar1.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] ">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] relative">
                <div class="bg-[#008ECC] p-3 w-[25%] flex justify-center items-center absolute top-0 right-0 rounded-bl-[16px] rounded-tr-[16px]">
                    <p class="font-semibold text-white text-[14px]">56% OFF</p>
                </div>
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/elfbar1.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
            <div class="bg-[#F5F5F5] border border-[#008ECC] rounded-[16px] ">
                <div class="p-3">
                    <img class="w-full h-[180px] object-contain" src="{{ asset('images/lostmarybm6.png') }}" alt="">
                </div>
                <div class="bg-white rounded-b-[16px] p-3">
                    <h2 class="text-[#222222] text-[18px] md:text-[24px] font-semibold">Elf Bar AF5000</h2>
                    <p class="text-[#000000] text-[16px] md:text-[20px] font-normal mb-2">£8.50</p>
                    <hr>
                    <p class="text-[#249B3E] font-semibold text-[20px] md:text-[24px] mt-2">Save - £1.20</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app.layout>
