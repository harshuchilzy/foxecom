<div>
    <!-- Hero banner section -->
    <div class="w-full">
        <img class="w-full h-[35vh] lg:h-auto object-cover object-top-right" src="{{asset('/images/wholesale-hero.jpg')}}"/>
    </div>

    <!-- Collection of products and filter section -->
    <div class="bg-[#D9D9D97D] py-8">
        <div class="max-w-[1280px] relative mx-auto">
            <h2 class="text-center text-[20px] lg:text-[28px]">
                <span class="font-bold text-black opacity-90">{{ __('Wholesale Spotlight.') }}</span>
                <span class="font-bold text-[#6E6E73]">{{ __('Our best sellers') }}</span>
            </h2>
        </div>

        <!-- Collection of products subsection -->
        <div class="swiper mySecondSwiper px-5 max-w-[1280px] relative mx-auto">
            <div class="swiper-wrapper py-8 px-5 !h-[200px] lg:!h-full">
                @foreach ($this->collections as $collection)
                    <x-product-cards.category-card :collection="$collection" />
                @endforeach
            </div>

        </div>

        <!-- Filter subsection -->
        <div class="max-w-[1280px] relative mx-auto" x-data="{show: false}">
            <div class="w-full relative px-3 lg:px-0">
                <span class="absolute top-1/2 lg:left-1 transform -translate-y-1/2">
                    <svg width="35" height="35" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 29C25.4183 29 29 25.4183 29 21C29 16.5817 25.4183 13 21 13C16.5817 13 13 16.5817 13 21C13 25.4183 16.5817 29 21 29Z" stroke="#ABB7C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M31.0002 31.0002L26.7002 26.7002" stroke="#ABB7C2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <input type="text" wire:model.live="term" wire:keydown.enter="$refresh" class="w-full h-[50px] pl-10 text-[16px] border border-[#FFFFFF66] rounded-[32px] focus:outline-none focus:border-[#6E6E73]" placeholder="{{ __('Search for products...') }}" />
                <span class="absolute top-1/2 right-4 lg:right-2 transform -translate-y-1/2 cursor-pointer" @click="show = !show">
                    <svg width="35" height="35" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M31 14H24" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 14H13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 22H22" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 22H13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M31 30H26" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M22 30H13" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M24 12V16" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 20V24" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M26 28V32" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
            </div>

            <div class="pt-6 w-full grid grid-cols-3 gap-3 lg:gap-5 px-3 lg:px-0" x-show="show" x-cloak>
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="sort_select" class="sr-only">{{ __('Sort select') }}</label>
                        <select id="sort_select" wire:model.live="sortOption" class="block py-1.5 lg:py-2 w-full text-sm text-[#000000] font-semibold text-[15px] lg:text-[18px] px-8 lg:px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option class="pl-4" value="">{{ __('Sort') }}</option>
                            <option value="latest">{{ __('Newest First') }}</option>
                            <option value="oldest">{{ __('Oldest First') }}</option>
                            <option value="price_asc">{{ __('Price: Low to High') }}</option>
                            <option value="price_desc">{{ __('Price: High to Low') }}</option>
                        </select>
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="w-[14px] lg:w-[18px] h-[14px] lg:h-[18px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.3674 8.11859C12.1003 7.8079 11.9502 7.38657 11.9502 6.94725C11.9502 6.50793 12.1003 6.0866 12.3674 5.77591L16.6424 0.805597C16.7738 0.647359 16.9311 0.521142 17.1049 0.434313C17.2788 0.347483 17.4658 0.301779 17.655 0.299867C17.8442 0.297956 18.0318 0.339875 18.207 0.423179C18.3821 0.506483 18.5412 0.629503 18.675 0.785062C18.8088 0.940621 18.9146 1.1256 18.9863 1.32921C19.0579 1.53282 19.094 1.75099 19.0923 1.97097C19.0907 2.19096 19.0514 2.40836 18.9767 2.61049C18.902 2.81262 18.7934 2.99544 18.6573 3.14827L14.3824 8.11859C14.1151 8.42918 13.7527 8.60367 13.3749 8.60367C12.997 8.60367 12.6346 8.42918 12.3674 8.11859Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M22.9321 8.1184C22.6649 8.42899 22.3025 8.60348 21.9247 8.60348C21.5468 8.60348 21.1844 8.42899 20.9172 8.1184L16.6422 3.14808C16.3826 2.83561 16.239 2.41711 16.2422 1.98271C16.2455 1.54831 16.3954 1.13277 16.6596 0.825589C16.9238 0.51841 17.2812 0.344169 17.6548 0.340395C18.0284 0.33662 18.3884 0.503613 18.6571 0.805407L22.9321 5.77572C23.1993 6.08641 23.3493 6.50774 23.3493 6.94706C23.3493 7.38638 23.1993 7.80771 22.9321 8.1184Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M17.6492 3.63379C18.0272 3.63379 18.3896 3.80834 18.6569 4.11905C18.9241 4.42975 19.0742 4.85116 19.0742 5.29056V18.5447C19.0742 18.9841 18.9241 19.4055 18.6569 19.7162C18.3896 20.0269 18.0272 20.2015 17.6492 20.2015C17.2713 20.2015 16.9089 20.0269 16.6416 19.7162C16.3744 19.4055 16.2242 18.9841 16.2242 18.5447V5.29056C16.2242 4.85116 16.3744 4.42975 16.6416 4.11905C16.9089 3.80834 17.2713 3.63379 17.6492 3.63379ZM11.5317 15.7166C11.7989 16.0273 11.949 16.4486 11.949 16.888C11.949 17.3273 11.7989 17.7486 11.5317 18.0593L7.25675 23.0296C6.98799 23.3314 6.62804 23.4984 6.25441 23.4946C5.88078 23.4909 5.52337 23.3166 5.25917 23.0094C4.99496 22.7022 4.8451 22.2867 4.84185 21.8523C4.8386 21.4179 4.98224 20.9994 5.24181 20.6869L9.51679 15.7166C9.78402 15.406 10.1464 15.2315 10.5243 15.2315C10.9021 15.2315 11.2645 15.406 11.5317 15.7166Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M0.967024 15.7165C1.23425 15.4059 1.59664 15.2314 1.97449 15.2314C2.35235 15.2314 2.71474 15.4059 2.98197 15.7165L7.25695 20.6868C7.39305 20.8397 7.50161 21.0225 7.57629 21.2246C7.65098 21.4268 7.69029 21.6442 7.69193 21.8641C7.69357 22.0841 7.65752 22.3023 7.58587 22.5059C7.51422 22.7095 7.40841 22.8945 7.27461 23.05C7.14082 23.2056 6.98171 23.3286 6.80659 23.4119C6.63146 23.4952 6.44382 23.5372 6.25461 23.5352C6.0654 23.5333 5.87841 23.4876 5.70455 23.4008C5.5307 23.314 5.37346 23.1878 5.24201 23.0295L0.967024 18.0592C0.699878 17.7485 0.549805 17.3272 0.549805 16.8879C0.549805 16.4485 0.699878 16.0272 0.967024 15.7165Z" fill="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.24921 20.2015C5.87128 20.2015 5.50883 20.0269 5.24159 19.7162C4.97435 19.4055 4.82422 18.9841 4.82422 18.5447V5.29056C4.82422 4.85116 4.97435 4.42975 5.24159 4.11905C5.50883 3.80834 5.87128 3.63379 6.24921 3.63379C6.62715 3.63379 6.9896 3.80834 7.25684 4.11905C7.52407 4.42975 7.67421 4.85116 7.67421 5.29056V18.5447C7.67421 18.9841 7.52407 19.4055 7.25684 19.7162C6.9896 20.0269 6.62715 20.2015 6.24921 20.2015Z" fill="black"/></svg>
                        </span>
                    </form>
                </div>
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="price_select" class="sr-only">{{ __('Price select') }}</label>
                        <select wire:model.live="selectedPriceRange" class="block py-1.5 lg:py-2 w-full text-sm text-[#000000] font-semibold text-[15px] lg:text-[18px] px-6 lg:px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option value="">{{ __('Select Price Range') }}</option>
                            @foreach ($this->priceRanges as $range)
                                <option value="{{ $range['min'] }}-{{ $range['max'] }}">
                                    {{ $range['label'] }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="w-[14px] lg:w-[18px] h-[14px] lg:h-[18px]" fill="#000000" height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M361.739,278.261c-27.664,0-50.087,22.423-50.087,50.087s22.423,50.087,50.087,50.087H512V278.261H361.739z M361.739,345.043c-9.22,0-16.696-7.475-16.696-16.696s7.475-16.696,16.696-16.696s16.696,7.475,16.696,16.696 S370.96,345.043,361.739,345.043z"></path> </g> </g> <g> <g> <path d="M361.739,244.87h83.478v-50.087c0-27.619-22.468-50.087-50.087-50.087H16.696C7.479,144.696,0,152.174,0,161.391v333.913 C0,504.521,7.479,512,16.696,512H395.13c27.619,0,50.087-22.468,50.087-50.087v-50.087h-83.478 c-46.032,0-83.478-37.446-83.478-83.478C278.261,282.316,315.707,244.87,361.739,244.87z"></path> </g> </g> <g> <g> <path d="M461.913,144.696h-0.158c10.529,13.973,16.854,31.282,16.854,50.087v50.087H512v-50.087 C512,167.164,489.532,144.696,461.913,144.696z"></path> </g> </g> <g> <g> <path d="M478.609,411.826v50.087c0,18.805-6.323,36.114-16.854,50.087h0.158C489.532,512,512,489.532,512,461.913v-50.087H478.609 z"></path> </g> </g> <g> <g> <path d="M273.369,4.892c-6.521-6.521-17.087-6.521-23.609,0l-14.674,14.674l91.74,91.738h52.956L273.369,4.892z"></path> </g> </g> <g> <g> <path d="M173.195,4.892c-6.521-6.522-17.086-6.522-23.608,0L43.174,111.304h236.435L173.195,4.892z"></path> </g> </g> </g></svg>
                        </span>
                    </form>
                </div>
                <div>
                    <form class="max-w-sm mx-auto relative">
                        <label for="brand_select" class="sr-only">{{ __('Brand select') }}</label>
                        <select id="brand_select" wire:model.live="selectedBrand" class="block py-1.5 lg:py-2 w-full text-sm text-[#000000] font-semibold text-[15px] lg:text-[18px] px-6 lg:px-12 border border-[#008ECC] rounded-[30px] bg-white appearance-none focus:outline-none focus:ring-0 peer">
                            <option value="">{{ __('All Brands') }}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 pointer-events-none">
                            <svg class="w-[14px] lg:w-[18px] h-[14px] lg:h-[18px]" fill="#000000" width="64px" height="64px" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="m 2.4647118,12.970648 c -0.1645962,-0.057 -0.1862164,-0.1182 -0.2355523,-0.6644 -0.024567,-0.272 -0.081059,-0.7789 -0.1255367,-1.1265 -0.044478,-0.3475 -0.080845,-0.669 -0.080817,-0.7143 1.648e-4,-0.2657 0.1986163,-0.5224003 0.4649246,-0.6014003 0.082074,-0.024 0.1809812,-0.044 0.2197931,-0.044 0.08666,8e-4 0.2649771,0.08 0.4207654,0.1867003 0.3954246,0.271 0.6369116,0.3072 0.9691385,0.1449 C 4.485448,9.9622477 4.8659124,9.4559477 4.97817,8.9796477 c 0.058965,-0.2502 0.039501,-0.6652 -0.043719,-0.9323 -0.1686371,-0.5411 -0.4499393,-0.7712 -0.9368418,-0.7666 -0.1921009,0 -0.2335047,0.013 -0.5082716,0.1423 -0.3946801,0.185 -0.5654783,0.2163 -0.7676026,0.1407 -0.1933602,-0.072 -0.2961039,-0.1602 -0.3582666,-0.3061 -0.06799,-0.1597 -0.061598,-0.5534 0.025987,-1.6005 0.037917,-0.4533 0.077171,-0.9455 0.087231,-1.0937 0.015263,-0.2248 0.028654,-0.2815 0.080876,-0.3422 l 0.062584,-0.073 1.538364,0.01 c 1.5182161,0.01 1.5398503,0.01 1.6518357,-0.05 0.1611106,-0.082 0.261467,-0.2442 0.2632397,-0.425 0.00113,-0.1157 -0.020267,-0.1845 -0.1123742,-0.3613 -0.062577,-0.1201 -0.1328765,-0.2829 -0.1562221,-0.3617 -0.1611081,-0.544 -0.018007,-1.0732 0.4057527,-1.5006 0.4758571,-0.47989996 1.0721404,-0.58899996 1.660203,-0.3036 0.2383193,0.1156 0.5191555,0.4127 0.6593119,0.6974 0.2462141,0.5002 0.2474469,0.8464 0.00487,1.3687 -0.1868643,0.4023 -0.2354378,0.5996 -0.1921053,0.7803 0.062621,0.261 0.2820421,0.4061 0.6140133,0.4061 0.2327398,0 2.2335919,-0.2577 2.4789469,-0.3193 0.05234,-0.013 0.06189,-5e-4 0.07891,0.1041 0.07264,0.4466 0.279078,1.6173 0.372796,2.1142 0.127652,0.6769 0.124417,0.7418 -0.04636,0.9308 -0.230345,0.255 -0.46144,0.2761 -0.933568,0.085 -0.546094,-0.2208 -0.902292,-0.1898 -1.2975195,0.113 -0.2426434,0.1858 -0.403607,0.5347 -0.434025,0.9405 -0.019887,0.2654 0.014053,0.4658 0.1264308,0.7464 0.2109885,0.5269 0.5352829,0.7847 0.9902587,0.7872 0.209623,10e-4 0.377238,-0.063 0.562163,-0.2143 0.122479,-0.1004 0.319388,-0.1777 0.451237,-0.1772 0.106208,4e-4 0.334173,0.1178 0.432896,0.223 0.131052,0.1396 0.153335,0.2652003 0.119972,0.6761003 -0.02612,0.3216 -0.08919,1.3431 -0.128525,2.0815 -0.0098,0.1845 -0.03102,0.3261 -0.05438,0.3635 -0.04184,0.067 -0.191148,0.1551 -0.226068,0.1336 -0.01201,-0.01 -0.292916,-0.051 -0.62423,-0.096 -2.5001053,-0.3445 -4.2265073,-0.3728 -6.6604362,-0.1094 -0.5124598,0.055 -1.4896908,0.1817 -1.5660261,0.2024 -0.022666,0.01 -0.083325,0 -0.1347975,-0.021 z"></path></g></svg>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Product boxes section -->
    <div class="max-w-[1280px] mx-auto px-2 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
            @foreach ($this->products as $product)
                <x-product-cards.general-card :product="$product" />
            @endforeach
        </div>
    </div>
    
</div>
