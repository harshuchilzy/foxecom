<div>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col bg-[#FFFFFF]">
            <!-- Hero video section -->
            @if(empty($metaFields['hero-video-link']))
                <div class="hero-section-gif relative bg-cover bg-no-repeat bg-center h-[35vh] lg:h-[90vh] w-full">
                    @if(empty($metaFields['hero-video-link']))
                        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover">
                            <source src="{{ asset('images/herovid.mp4') }}" type="video/mp4">
                        </video>
                    @else
                        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover">
                            <source src="{{ asset('storage/' . $mediaCollection['hero-section-video']) }}"
                                    type="video/mp4">
                        </video>
                    @endif
                    <div class="w-full h-full flex items-end justify-end relative">
                        <a class="bg-themeblue rounded-[45px] text-white px-6 py-2 absolute bottom-8 right-8 hidden lg:block"
                           href="{{ $metaFields['redeem-offer-link'] ?? '#' }}">Redeem Free Offer</a>
                    </div>
                </div>
            @else
                <div class="hero-section-gif w-full relative">
                    <div class="foxecom-youtube-container w-full overflow-hidden aspect-[16/9] pointer-events-none">
                        <iframe class=""
                                src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($metaFields['hero-video-link'], 'v=') }}?autoplay=1&mute=1&loop=1&color=white&controls=0&modestbranding=1&playsinline=1&rel=0&enablejsapi=1&playlist={{ \Illuminate\Support\Str::afterLast($metaFields['hero-video-link'], 'v=') }}"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                    </div>
                    <style>
                        .foxecom-youtube-container {
                            overflow: hidden;
                            width: 100%;
                            aspect-ratio: 16/9;
                            pointer-events: none;

                            iframe {
                                width: 300%;
                                height: 100%;
                                margin-left: -100%;
                            }
                        }
                    </style>
                    <div class="absolute bottom-[156px] right-[120px]  z-10">
                        <a class="bg-themeblue rounded-[45px] text-white px-6 py-2 bottom-8 right-8 hidden lg:block hover:bg-[#11316d] hover:shadow-lg" href="{{ $metaFields['redeem-offer-link'] ?? '#' }}">Redeem Free Offer</a>
                    </div>

                    @php
                        $brandName = $metaFields['hero-sale-brand-name'] ?? 'Al Fakir';
                        $brandOffer = $metaFields['hero-sale-brand-offer'] ?? 'BUY 4 OUTERS AND GET 1 FREE';
                    @endphp

                </div>
            @endif

            <!-- Promotion Spotlight slider section -->    
            <div class="flex flex-col bg-[#ECECEC]">
                <div class="py-8 lg:pt-12 lg:pb-8">
                    <h2 class="text-center text-[20px] lg:text-[28px]">
                        <span class="font-bold text-black">{{$metaFields['promotion-section-bold-title'] ?? 'Promotion Spotlight.'}}</span>
                        <span class="font-normal text-[#6E6E73] italic">{{$metaFields['promotion-section-title'] ?? 'Our monthly offer selection for you.'}}</span>
                    </h2>

                    <section class="py-8">
                        <div class="swiper mySwiper w-full mx-auto">
                            <div class="swiper-wrapper">
                                @foreach ($discounts as $discount)
                                    @php
                                        if (isset($discount->data['display_type']) && !in_array('spotlight', $discount->data['display_type'])) {
                                            continue;
                                        }
                                        $data = $discount->data;
                                        $bannerImage = $data['banner_image'] ?? null;

                                        $claimed = (($discount->uses > 0 ? $discount->uses : 1) / ($discount->max_uses > 0 ? $discount->max_uses : 1 )) * 100; // rand(60, 98); // Simulate claimed percentage

                                    @endphp

                                    @if ($bannerImage)
                                        <div class="swiper-slide rounded-xl">
                                            <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                                <div
                                                    class="h-[250px] lg:h-[350px] xl:h-[450px] rounded-[16px] overflow-hidden">
                                                    <img src="{{ asset('storage/' . $bannerImage) }}"
                                                        class="w-full h-full rounded-xl object-cover transition-transform duration-300 hover:scale-105"
                                                        alt="{{ $discount->name }}">
                                                        <div class="swiper-slider-claim-progress hidden bg-white rounded-[20px] h-[16px] absolute bottom-6 w-[90%] left-1/2 -translate-x-1/2 border-3 border-white overflow-hidden">
                                                            <div
                                                            class="bg-gradient-to-r from-[#FFFFFF] to-[#1681FF] h-[10px] rounded-[20px]"
                                                            style="width: {{ $claimed }}%"
                                                            ></div>
                                                        </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <div class="flex items-center justify-center mt-2 flex-col gap-3 px-5 lg:px-0">
                        <h3 class="text-[22px] font-semibold bg-gradient-to-r from-[#2A86F8] via-[#E64889] to-[#F4530C] text-transparent bg-clip-text">{{$metaFields['promotion-subtitle'] ?? 'Claim Your Free Outer Here'}}</h3>
                        <p class="text-[16px] font-normal text-black font-inter">{{$metaFields['promotion-text-line'] ?? 'Limited-time promotion for verified retailers. Claim it fast'}}  </p>
                    </div>
                </div>
            </div>

            <!-- Latest Promotions section --> 
            <div class="bg-white px-4 lg:px-8 xl:px-16 py-12 max-w-[1440px] mx-auto w-full">
                <div class="flex w-full justify-start pb-5">
                    <h2 class="text-left text-[16px] lg:text-[28px] font-inter">
                        <span class="font-bold text-black opacity-90">{{$metaFields['latest-promotion-bold-title'] ?? 'The latest promotions.'}}</span>
                        <span class="font-bold text-[#6E6E73]">{{$metaFields['latest-promotion-title'] ?? 'Take a look what’s new.'}}</span>
                    </h2>
                </div>

                <div class="overflow-x-auto pb-2">
                    <div class="md:w-full relative flex md:grid md:grid-cols-3 gap-3 md:gap-6">
                        @foreach ($latestDiscounts as $discount)
                            @php
                                if (isset($discount->data['display_type']) && !in_array('latest-promotions', $discount->data['display_type'])) {
                                    continue;
                                }

                                $title = $discount->name;
                                $data = $discount->data;
                                $image = isset($data['promo_image']) && $data['promo_image']
                                    ? asset('storage/' . $data['promo_image'])
                                    : asset('images/fallback.png');

                                $mobileImage = isset($data['mobile_promo_image']) && $data['mobile_promo_image']
                                    ? asset('storage/' . $data['promo_image'])
                                    : $image;

                                $promoCoverImage = isset($data['promo_cover_image']) && $data['promo_cover_image']
                                    ? asset('storage/' . $data['promo_cover_image'])
                                    : null;

                                $claimed = (int)(
                                    (($discount->uses > 0 ? $discount->uses : 1)
                                    /
                                    ($discount->max_uses > 0 ? $discount->max_uses : 1)
                                    ) * 100
                                );

                                if ($claimed >= 100) {
                                    $claimed = 100;
                                    $barColor = 'bg-[linear-gradient(360deg,_#F9F671_0%,_#4B7A0A_100%)]';
                                    $cardBg = 'bg-[linear-gradient(180deg,_#FFFFFF_0%,_#EFFF86_100%)]';
                                    $textClass = 'text-black';
                                }  elseif ($claimed >= 90) {
                                    $barColor = 'bg-[linear-gradient(360deg,_#F9F671_0%,_#4B7A0A_100%)]';
                                    $cardBg = 'bg-[linear-gradient(180deg,_#F4F4F4_0%,_rgba(176,_204,_111,_0.2)_100%)]';
                                    $textClass = 'text-black';
                                } elseif ($claimed >= 70) {
                                    $barColor = 'bg-[linear-gradient(90deg,_#95D7EF_0%,_#2E6EA2_100%)]';
                                    $cardBg = 'bg-[linear-gradient(360deg,_#F3F7F9_0%,_#D6EBF6_100%)]';
                                    $textClass = 'text-[#1D1D1F]';
                                } else {
                                    $barColor = 'bg-[linear-gradient(90deg,_#95D7EF_0%,_#2E6EA2_100%)]';
                                    $cardBg = 'bg-[linear-gradient(270deg,_#E5E5E5_0%,_#EEEEEE_100%)]';
                                    $textClass = 'text-[#1D1D1F]';
                                }

                                // Get linked product slug for "Claim" button
                                $product = $discount->purchasables ? $discount->purchasables->first()?->product : null;
                                $productUrl = $product?->defaultUrl?->slug;

                                $productBrand = $discount->products->first()?->brand?->name ?? '';

                                $productBrandId = $discount->products->first()?->brand?->id ?? null;
                                $productBrandSlug = $this->getBrandSlug($productBrandId);
                            @endphp

                            <div class="overflow-hidden rounded-[20px] h-[200px] !w-[150px] sm:!w-auto lg:h-[350px] p-4 lg:p-8 {{ $cardBg }} shadow-[0_4px_4px_0_rgba(0,0,0,0.25)] w-full" style="background-image: url({{ $promoCoverImage }}); background-repeat: no-repeat; background-size: cover;">
                                <div class="items-center justify-between w-full lg:flex hidden">
                                    <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                        <h3 class="font-semibold text-2xl mt-2 {{ $textClass }} ">{{ $title }}</h3>
                                    </a>
                                </div>

                                <div class="items-center justify-between w-full lg:hidden block">
                                    @if(!empty($productBrandSlug) && !empty($productBrand))
                                        <a href="{{ route('brand.view', ['slug' => $productBrandSlug]) }}">
                                            <div class="mb-1 uppercase text-xs sm:text-lg font-semibold bg-gradient-to-r from-[#2A86F8] via-[#E64889] to-[#F4530C] text-transparent bg-clip-text">{{ $productBrand }}</div>
                                        </a>
                                    @endif
                                    <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                        <h3 class="font-semibold text-xs sm:text-lg uppercase mt-2 {{ $textClass }} ">{{ $title }}</h3>
                                    </a>
                                </div>

                                <p class="text-[15px] font-semibold bg-gradient-to-r from-[#2A86F8] via-[#E64889] to-[#F4530C] text-transparent bg-clip-text mt-2 lg:block hidden">Tap to reveal offer</p>

                                <div class="w-full bg-[#D9D9D9] rounded-[20px] h-[8px] mt-2">
                                    <div class="{{ $barColor }} h-[8px] rounded-[20px]" style="width: {{ $claimed }}%"></div>
                                </div>

                                <p class="text-[12px] font-semibold mt-2 hidden lg:flex {{ $textClass }}">{{ $claimed }}%
                                    claimed</p>

                                <div class="w-full justify-center items-center mt-4 lg:mt-8 xl:mt-0 lg:flex hidden">
                                    <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                        <img class="w-[180px] lg:w-[200px] xl:w-[350px] xl:h-[240px] object-contain" src="{{ $image }}" alt="{{ $title }}">
                                    </a>
                                </div>

                                <div class="w-full justify-center items-center mt-4 lg:mt-8 xl:mt-0 lg:hidden flex">
                                    <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                        <img class="w-[180px] lg:w-[200px] xl:w-[350px] xl:h-[240px] object-contain" src="{{ $mobileImage }}" alt="{{ $title }}">
                                    </a>
                                </div>

                                @if ($productUrl)
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('product.view', ['slug' => $productUrl]) }}?discount={{ $discount->id }}"
                                        class="bg-[#1275EE] rounded-[45px] px-8 py-3 text-white text-sm inline-block">
                                            Claim Offer
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <!-- All Promotions Section --> 
            <div class="bg-white px-4 lg:px-8 xl:px-16 py-6 xl:pt-0 xl:pb-12 max-w-[1440px] mx-auto w-full">
                <div class="flex w-full justify-start pb-5">
                    <h2 class="text-left text-[16px] lg:text-[28px] font-inter">
                        <span class="font-bold text-black opacity-90">{{$metaFields['offers-bold-title'] ?? 'All Offers.'}}</span>
                        <span class="font-bold text-[#6E6E73]">{{$metaFields['offers-title'] ?? 'Click to reveal.'}}</span>
                    </h2>
                </div>

                @foreach ($discounts->chunk(4) as $index => $discountChunk)
                    <div class="grid grid-cols-2 gap-3 lg:gap-6">
                        @foreach ($discountChunk as $discount)
                            @php
                                $data = $discount->data;
                                $bannerImage = $data['banner_image'] ?? null;
                                $promoImage = $data['promo_image'] ?? null;
                                $mobilePromoImage = $data['mobile_promo_image'] ?? $promoImage;
                                $imageToShow = $bannerImage ?? $promoImage;

                                $marketingHeader = $data['marketing_header'] ?? null;
                                $discountFeatures = $data['discount_features'] ?? null;
                                $discountFeaturesArray = explode(',', $discountFeatures);

                                // Claimed bar calculation and color
                                $claimed = (int)(
                                    (($discount->uses > 0 ? $discount->uses : 1)
                                    /
                                    ($discount->max_uses > 0 ? $discount->max_uses : 1)
                                    ) * 100
                                );
                            @endphp
                            <div class="relative w-full h-[260px] lg:h-[500px] bg-[linear-gradient(180deg,_rgba(73,77,94,0.08)_0%,_#FFFFFF_100%)] rounded-2xl p-3 lg:p-6 lg:pb-6 pb-0 shadow-[0px_10px_25px_0px_#00000073] hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden flex flex-col justify-between">
                                <div class="mb-4 flex lg:hidden justify-end items-start">
                                    <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                        <div class="rounded-full flex items-center justify-center lg:hidden"
                                            style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.56) 0%, rgba(0, 0, 0, 0.8) 100%);">
                                            <svg width="30" height="30" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10Z" fill="url(#paint0_linear_721_1663)" fill-opacity="0.8"/><path d="M5.87503 10.7634C6.12632 10.7635 6.33012 10.9673 6.3302 11.2186V13.4352H8.63718C8.88847 13.4352 9.09227 13.6391 9.09235 13.8903C9.09235 14.1417 8.88851 14.3455 8.63718 14.3455H6.17847C5.75955 14.3455 5.41985 14.0058 5.41985 13.5869V11.2186C5.41993 10.9673 5.62374 10.7635 5.87503 10.7634Z" fill="url(#paint1_linear_721_1663)"/><path d="M11.4085 7.65631C11.9113 7.65632 12.3189 8.06389 12.3189 8.56666V11.199C12.3188 11.7017 11.9112 12.1094 11.4085 12.1094H8.62591C8.12319 12.1094 7.71564 11.7017 7.71557 11.199V8.56666C7.71557 8.06389 8.12315 7.65631 8.62591 7.65631H11.4085Z" fill="url(#paint2_linear_721_1663)"/><path d="M13.8571 5.41986C14.2761 5.41992 14.6158 5.75954 14.6158 6.17848V8.5468C14.6158 8.79815 14.4119 9.00192 14.1606 9.00197C13.9093 9.00191 13.7054 8.79815 13.7054 8.5468V6.33021H11.3984C11.1471 6.33015 10.9433 6.12638 10.9433 5.87503C10.9433 5.62369 11.1471 5.41992 11.3984 5.41986H13.8571Z" fill="url(#paint3_linear_721_1663)"/><defs><linearGradient id="paint0_linear_721_1663" x1="10" y1="0" x2="10" y2="20" gradientUnits="userSpaceOnUse"><stop stop-opacity="0.7"/><stop offset="1"/></linearGradient><linearGradient id="paint1_linear_721_1663" x1="9.81209" y1="5.41988" x2="9.81209" y2="13.9584" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.7"/></linearGradient><linearGradient id="paint2_linear_721_1663" x1="9.81209" y1="5.41988" x2="9.81209" y2="13.9584" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.7"/></linearGradient><linearGradient id="paint3_linear_721_1663" x1="9.81209" y1="5.41988" x2="9.81209" y2="13.9584" gradientUnits="userSpaceOnUse"><stop stop-color="white"/><stop offset="1" stop-color="white" stop-opacity="0.7"/></linearGradient></defs></svg>
                                        </div>
                                    </a>
                                </div>

                                <div class="mb-4 block absolute lg:relative top-3 left-2">
                                    <div class="mb-4">
                                        @php
        
                                            $firstProduct = isset($discount->products) && $discount->products instanceof \Illuminate\Support\Collection
                                                ? $discount->products->first()
                                                : null;
                                            
                                            $firstBrandMedia = $firstProduct?->brand_media instanceof \Illuminate\Support\Collection
                                                ? $firstProduct->brand_media->first()
                                                : null;
                                            
                                            $brandImageUrl = $firstBrandMedia && isset($firstBrandMedia->uuid)
                                                ? asset("storage/{$firstBrandMedia->id}/{$firstBrandMedia->file_name}")
                                                : '';

                                            $brandId = $firstProduct->brand->id ?? null;
                                            $brandSlug = $this->getBrandSlug($brandId);

                                            $brandImageUrl = $discount->discountables?->first()?->discountable->brand->getMedia('*')[0]->getUrl();
                                     
                                        @endphp

                                        @if (!empty($brandImageUrl) && !empty($brandSlug))
                                            <a href="{{ route('brand.view', ['slug' => $brandSlug]) }}" class="z-1 relative">
                                                <img class="h-[25px] lg:h-[45px] mb-2" src="{{ $brandImageUrl }}" alt="{{ $firstProduct?->brand?->name ?? 'Brand Logo' }}">
                                            </a>
                                        @else
                                            <div class="h-[24px] lg:w-[140px] mb-2"></div>
                                        @endif
                                        <h2 class="text-transparent hidden lg:block bg-clip-text bg-[linear-gradient(75.62deg,_#565656_62.01%,_rgba(132,132,132,0.5)_103.64%)] font-semibold text-[40px] lg:text-[64px]">{{ $discount->name }}</h2>
                                    </div>

                                    <p class="text-black font-bold text-[20px] max-w-[55%] lg:max-w-[35%] hidden lg:block font-inter opacity-70 leading-6 pt-5 ">{{ $marketingHeader }}</p>

                                    @if($discountFeatures)
                                        <ul class="pt-6 font-semibold font-inter opacity-70 list-disc list-inside ml-4 hidden lg:block">
                                            @foreach($discountFeaturesArray as $discountFeature)
                                                <li>{{ $discountFeature }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </div>

                                <div class="w-full z-[99999999] mb-auto -mt-3">
                                    <div class="w-full bg-[#D9D9D9] rounded-[2px] h-[8px] mt-2 lg:hidden">
                                        <div class="bg-[linear-gradient(90deg,_#95D7EF_0%,_#2E6EA2_100%)] h-[8px] rounded-[2px]" style="width: {{ $claimed }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('discount.show', ['id' => $discount->id]) }}" class="group lg:flex items-center gap-2 text-gray-800 font-medium hover:text-gray-900 transition-colors duration-200 hidden z-9 lg:text-[22px]">
                                    @if ($claimed > 0)
                                        <span class="text-themeblue">{{ $claimed }}% claimed</span>
                                    @else
                                        <span class="text-themeblue">Reveal Offer</span>
                                    @endif
                                    <span class="text-lg group-hover:translate-x-1 transition-transform duration-200 text-themeblue">
                                        <svg width="23" height="12" viewBox="0 0 23 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 6H21M21 6L16 1M21 6L16 11" stroke="#2A86F8" stroke-width="2"/>
                                        </svg>
                                    </span>
                                </a>

                                @if ($promoImage)
                                    <img src="{{ asset('storage/' . $promoImage) }}"
                                         alt="{{ $discount->name }}"
                                         class="absolute right-0 lg:-right-8 -bottom-[90px] lg:-bottom-[120px] h-[170px] lg:h-[350px] xl:h-[450px] w-full lg:object-bottom-right object-contain drop-shadow-lg scale-200 lg:scale-150 lg:block hidden"/>
                                    
                                    <img src="{{ asset('storage/' . $mobilePromoImage) }}"
                                         alt="mobile-{{ $discount->name }}"
                                         class="h-[174px] w-auto object-contain drop-shadow-lg lg:hidden block"/>
                                @endif

                                <a href="{{ route('discount.show', ['id' => $discount->id]) }}" class="absolute top-4 right-4 p-3 bg-[linear-gradient(180deg,_rgba(73,77,94,0.9)_0%,_rgba(0,0,0,0.8)_100%)] rounded-full lg:flex items-center justify-center hidden">
                                    <svg width="32" height="31" viewBox="0 0 32 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.36084 18.4702C3.18896 18.4704 3.86059 19.1421 3.86084 19.9702V27.2749H11.4634C12.2915 27.2751 12.9631 27.9468 12.9634 28.7749C12.9634 29.6032 12.2916 30.2747 11.4634 30.2749H3.36084C1.98029 30.2747 0.86084 29.1555 0.86084 27.7749V19.9702C0.861089 19.1421 1.53273 18.4704 2.36084 18.4702ZM20.5962 8.23096C22.253 8.23097 23.5962 9.57411 23.5962 11.231V19.9058C23.596 21.5624 22.2529 22.9057 20.5962 22.9058H11.4263C9.76956 22.9058 8.4265 21.5624 8.42627 19.9058V11.231C8.42627 9.5741 9.76941 8.23096 11.4263 8.23096H20.5962ZM28.6655 0.86084C30.0461 0.861027 31.1655 1.98024 31.1655 3.36084V11.1655C31.1655 11.9938 30.4938 12.6653 29.6655 12.6655C28.8373 12.6653 28.1655 11.9938 28.1655 11.1655V3.86084H20.563C19.7347 3.86065 19.063 3.18915 19.063 2.36084C19.063 1.53253 19.7347 0.861034 20.563 0.86084H28.6655Z" fill="url(#paint0_linear_754_1551)"/>
                                    <defs>
                                    <linearGradient id="paint0_linear_754_1551" x1="15.3352" y1="0.86084" x2="15.3352" y2="28.9993" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="white"/>
                                    <stop offset="1" stop-color="white" stop-opacity="0.7"/>
                                    </linearGradient>
                                    </defs>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Banner after 1st and 2nd set -->
                    @if ($index == 0)
                        <div class="w-full my-12">
                            <a href="{{ route('products.index') }}">
                                @if ( !empty($mediaCollection['all-offer-banner-1']) )
                                    <img class="w-full h-full rounded-[14px]" src="{{ asset('storage/' . $mediaCollection['all-offer-banner-1']) }}" alt="">
                                @else
                                    <img class="w-full h-full rounded-[14px]" src="{{ asset('images/AF-BANNER.jpg') }}" alt="">
                                @endif
                            </a>
                        </div>
                    @elseif ($index == 1)
                        <div class="w-full my-12">
                            <a href="{{ route('products.index') }}">
                                @if ( !empty($mediaCollection['all-offer-banner-2']) )
                                    <img class="w-full h-full rounded-[14px]" src="{{ asset('storage/' . $mediaCollection['all-offer-banner-2']) }}" alt="">
                                @else
                                    <img class="w-full h-full rounded-[14px]" src="{{ asset('images/TT-BANNER.jpg') }}" alt="">
                                @endif
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </main>
    </div>

</div>
