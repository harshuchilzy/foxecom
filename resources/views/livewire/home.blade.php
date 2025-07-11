<div>
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex w-full flex-col">
            @if(empty($metaFields['hero-video-link']))
                <div class="hero-section-gif relative bg-cover bg-no-repeat bg-center h-[50vh] lg:h-[90vh] w-full">
                    @if(empty($metaFields['hero-video-link']))
                        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover">
                            <source src="{{ asset('images/herovid.mp4') }}" type="video/mp4">
                        </video>
                    @else
                        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover">
                            <source src="{{ asset('storage/' . $mediaCollection['hero-section-video']) }}" type="video/mp4">
                        </video>
                    @endif
                    <div class="w-full h-full flex items-end justify-end relative z-10">
                        <a class="bg-themeblue rounded-[45px] text-white px-6 py-2 absolute bottom-8 right-8 hidden lg:block" href="{{ $metaFields['redeem-offer-link'] ?? '#' }}">Redeem Free Offer</a>
                    </div>
                </div>
            @else
                <div class="hero-section-gif w-full relative">
                    <div class="foxecom-youtube-container w-full overflow-hidden aspect-[16/9] pointer-events-none">
                        <iframe class="" src="https://www.youtube.com/embed/{{ \Illuminate\Support\Str::afterLast($metaFields['hero-video-link'], 'v=') }}?autoplay=1&mute=1&loop=1&color=white&controls=0&modestbranding=1&playsinline=1&rel=0&enablejsapi=1&playlist={{ \Illuminate\Support\Str::afterLast($metaFields['hero-video-link'], 'v=') }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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
                    <div class="absolute bottom-[120px] right-[20px]  z-10">
                        <a class="bg-themeblue rounded-[45px] text-white px-6 py-2 bottom-8 right-8 hidden lg:block" href="{{ $metaFields['redeem-offer-link'] ?? '#' }}">Redeem Free Offer</a>
                    </div>

                    @php
                        $brandName = $metaFields['hero-sale-brand-name'] ?? 'Al Fakir';
                        $brandOffer = $metaFields['hero-sale-brand-offer'] ?? 'BUY 4 OUTERS AND GET 1 FREE';
                    @endphp

                    <div class="bg-[#901823] lg:bg-second-dark-blue flex justify-center lg:justify-between items-center py-2 lg:py-6 px-5 absolute bottom-0 w-full">
                        <p class="text-white xl:flex items-center gap-2 hidden">
                            <span class="font-semibold lg:text-sm xl:text-lg">{{ $brandName }}</span>
                            <span class="font-strong lg:text-sm xl:text-lg">{{ $brandOffer }}</span>
                        </p>
                        <p class="text-white flex items-center gap-2">
                            <span class="font-semibold text-[10px] lg:text-sm xl:text-lg">{{ $brandName }}</span>
                            <span class="font-strong text-[10px] lg:text-sm xl:text-lg">{{ $brandOffer }}</span>
                        </p>
                        <p class="text-white flex items-center gap-2">
                            <span class="font-semibold text-[10px] lg:text-sm xl:text-lg">{{ $brandName }}</span>
                            <span class="font-strong text-[10px] lg:text-sm xl:text-lg">{{ $brandOffer }}</span>
                        </p>
                    </div>

                </div>
            @endif

            @if(empty($metaFields['hero-video-link']))
                @php
                    $brandName = $metaFields['hero-sale-brand-name'] ?? 'Al Fakir';
                    $brandOffer = $metaFields['hero-sale-brand-offer'] ?? 'BUY 4 OUTERS AND GET 1 FREE';
                @endphp

                <div class="bg-[#901823] lg:bg-second-dark-blue flex justify-center lg:justify-between items-center py-2 lg:py-6 px-5">
                    <p class="text-white xl:flex items-center gap-2 hidden">
                        <span class="font-semibold lg:text-sm xl:text-lg">{{ $brandName }}</span>
                        <span class="font-strong lg:text-sm xl:text-lg">{{ $brandOffer }}</span>
                    </p>
                    <p class="text-white flex items-center gap-2">
                        <span class="font-semibold text-[10px] lg:text-sm xl:text-lg">{{ $brandName }}</span>
                        <span class="font-strong text-[10px] lg:text-sm xl:text-lg">{{ $brandOffer }}</span>
                    </p>
                    <p class="text-white flex items-center gap-2">
                        <span class="font-semibold text-[10px] lg:text-sm xl:text-lg">{{ $brandName }}</span>
                        <span class="font-strong text-[10px] lg:text-sm xl:text-lg">{{ $brandOffer }}</span>
                    </p>
                </div>
            @endif

            <div class="flex flex-col bg-[#D9D9D97D]">
                <div class="py-8 lg:py-12">
                    <h2 class="text-center text-[20px] lg:text-[28px]">
                        <span class="font-bold text-black">{{$metaFields['promotion-section-bold-title'] ?? 'Promotion Spotlight.'}}</span>
                        <span class="font-semibold text-[#6E6E73] italic">{{$metaFields['promotion-section-title'] ?? 'Our monthly offer selection for you.'}}</span>
                    </h2>

                    <section class="py-8">
                        <div class="swiper mySwiper w-full mx-auto">
                            <div class="swiper-wrapper">
                                @foreach ($discounts as $discount)
                                    @php
                                        $data = $discount->data;
                                        $bannerImage = $data['banner_image'] ?? null;
                                    @endphp

                                    @if ($bannerImage)
                                        <div class="swiper-slide rounded-xl">
                                            <a href="{{ route('discount.show', ['id' => $discount->id]) }}">
                                                <div class="h-[250px] lg:h-[350px] xl:h-[450px] rounded-[16px] overflow-hidden">
                                                    <img src="{{ asset('storage/' . $bannerImage) }}"
                                                        class="w-full h-full rounded-xl object-cover transition-transform duration-300 hover:scale-105"
                                                        alt="{{ $discount->name }}">
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
                        <p class="text-[16px] font-normal text-black">{{$metaFields['promotion-text-line'] ?? 'Limited-time promotion for verified retailers. Claim it fast'}}  </p>
                    </div>
                </div>
            </div>

            <div class="bg-white px-4 lg:px-8 xl:px-16 py-12 max-w-[1440px] mx-auto w-full">
                <div class="flex w-full justify-start pb-5">
                    <h2 class="text-left text-[16px] lg:text-[28px]">
                        <span class="font-bold text-black">{{$metaFields['latest-promotion-bold-title'] ?? 'The latest promotions.'}}</span>
                        <span class="font-semibold text-[#6E6E73] italic">{{$metaFields['latest-promotion-title'] ?? 'Take a look what’s new.'}}</span>
                    </h2>
                </div>

                {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($latestRedemptions as $latestRedemption)
                        @php
                            $title = $latestRedemption->title;
                            $image = $latestRedemption->product_image ? asset('storage/' . $latestRedemption->product_image) : asset('images/fallback.png');
                            $claimed = rand(60, 98); // Replace with $latestRedemption->claimed_percentage if you have this in DB

                            if ($claimed >= 90) {
                                $barColor = 'bg-[linear-gradient(360deg,_#F9F671_0%,_#4B7A0A_100%)]';
                                $cardBg = 'bg-[linear-gradient(360deg,_#090403_0%,_#676767_100%)]';
                                $textClass = 'text-white';
                            } elseif ($claimed >= 70) {
                                $barColor = 'bg-[linear-gradient(360deg,_#95D7EF_0%,_#2E6EA2_100%)]';
                                $cardBg = 'bg-[linear-gradient(360deg,_#F3F7F9_0%,_#D6EBF6_100%)]';
                                $textClass = 'text-[#1D1D1F]';
                            } else {
                                $barColor = 'bg-[linear-gradient(360deg,_#DEDBDC_0%,_#494D5E_100%)]';
                                $cardBg = 'bg-[linear-gradient(270deg,_rgba(136,136,136,0.7)_0%,_#EEEEEE_100%)]';
                                $textClass = 'text-[#1D1D1F]';
                            }
                        @endphp

                        <div class="rounded-[20px] p-4 lg:p-8 {{ $cardBg }} shadow-[0px_4px_4px_0px_#00000040] w-full">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-2xl mt-2 {{ $textClass }}">{{ $title }}</h3>
                                <p class="text-[18px] font-semibold mt-2 lg:hidden {{ $textClass }}">{{ $claimed }}%</p>
                            </div>
                            <p class="text-[15px] font-semibold bg-gradient-to-r from-[#2A86F8] via-[#E64889] to-[#F4530C] text-transparent bg-clip-text mt-2">Claim Your Free Outer Here</p>

                            <div class="w-full bg-[#D9D9D9] rounded-[20px] h-[8px] mt-2">
                                <div class="{{ $barColor }} w-[{{ $claimed }}%] h-[8px] rounded-[20px]"></div>
                            </div>

                            <p class="text-[12px] font-semibold mt-2 hidden lg:flex {{ $textClass }}">{{ $claimed }}% claimed</p>

                            <div class="w-full flex justify-center items-center mt-4 lg:mt-8 xl:mt-0">
                                <img class="w-[180px] lg:w-[200px] xl:w-[350px] xl:h-[240px] object-contain" src="{{ $image }}" alt="{{ $title }}">
                            </div>
                        </div>
                    @endforeach
                </div> --}}

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($latestDiscounts as $discount)
                        @php
                            $title = $discount->name;
                            $data = $discount->data;
                            $image = isset($data['promo_image']) && $data['promo_image']
                                ? asset('storage/' . $data['promo_image'])
                                : asset('images/fallback.png');

                            $claimed = rand(60, 98); // Simulate claimed percentage

                            if ($claimed >= 90) {
                                $barColor = 'bg-[linear-gradient(360deg,_#F9F671_0%,_#4B7A0A_100%)]';
                                $cardBg = 'bg-[linear-gradient(360deg,_#090403_0%,_#676767_100%)]';
                                $textClass = 'text-white';
                            } elseif ($claimed >= 70) {
                                $barColor = 'bg-[linear-gradient(360deg,_#95D7EF_0%,_#2E6EA2_100%)]';
                                $cardBg = 'bg-[linear-gradient(360deg,_#F3F7F9_0%,_#D6EBF6_100%)]';
                                $textClass = 'text-[#1D1D1F]';
                            } else {
                                $barColor = 'bg-[linear-gradient(360deg,_#DEDBDC_0%,_#494D5E_100%)]';
                                $cardBg = 'bg-[linear-gradient(270deg,_rgba(136,136,136,0.7)_0%,_#EEEEEE_100%)]';
                                $textClass = 'text-[#1D1D1F]';
                            }

                            // Get linked product slug for "Claim" button
                            $product = $discount->purchasables->first()?->product;
                            $productUrl = $product?->defaultUrl?->slug;
                        @endphp

                        <div class="rounded-[20px] p-4 lg:p-8 {{ $cardBg }} shadow-[0px_4px_4px_0px_#00000040] w-full">
                            <div class="flex items-center justify-between">
                                <h3 class="font-semibold text-2xl mt-2 {{ $textClass }}">{{ $title }}</h3>
                                <p class="text-[18px] font-semibold mt-2 lg:hidden {{ $textClass }}">{{ $claimed }}%</p>
                            </div>

                            <p class="text-[15px] font-semibold bg-gradient-to-r from-[#2A86F8] via-[#E64889] to-[#F4530C] text-transparent bg-clip-text mt-2">Claim Your Free Outer Here</p>

                            <div class="w-full bg-[#D9D9D9] rounded-[20px] h-[8px] mt-2">
                                <div class="{{ $barColor }} w-[{{ $claimed }}%] h-[8px] rounded-[20px]"></div>
                            </div>

                            <p class="text-[12px] font-semibold mt-2 hidden lg:flex {{ $textClass }}">{{ $claimed }}% claimed</p>

                            <div class="w-full flex justify-center items-center mt-4 lg:mt-8 xl:mt-0">
                                <img class="w-[180px] lg:w-[200px] xl:w-[350px] xl:h-[240px] object-contain" src="{{ $image }}" alt="{{ $title }}">
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

            <div class="bg-white px-4 lg:px-8 xl:px-16 py-6 xl:py-12 max-w-[1440px] mx-auto w-full">
                <div class="flex w-full justify-start pb-5">
                    <h2 class="text-left text-[16px] lg:text-[28px]">
                        <span class="font-bold text-black">{{$metaFields['offers-bold-title'] ?? 'All Offers.'}}</span>
                        <span class="font-semibold text-[#6E6E73] italic">{{$metaFields['offers-title'] ?? 'Click to reveal.'}}</span>
                    </h2>
                </div>

                @foreach ($discounts->chunk(4) as $index => $discountChunk)
                    <div class="grid grid-cols-2 gap-3 lg:gap-6">
                        @foreach ($discountChunk as $discount)
                            @php
                                $data = $discount->data;
                                $bannerImage = $data['banner_image'] ?? null;
                                $promoImage = $data['promo_image'] ?? null;
                                $imageToShow = $bannerImage ?? $promoImage;
                            @endphp

                            <div class="relative w-full h-[260px] lg:h-[500px] bg-[linear-gradient(270deg,_rgba(136,136,136,0.7)_0%,_#EEEEEE_100%)] rounded-2xl p-3 lg:p-6 shadow-[0px_4px_4px_#00000040] hover:shadow-xl transition-all duration-300 hover:scale-105 overflow-hidden flex flex-col justify-between">
                                <div class="mb-4 flex lg:hidden justify-between items-start">
                                    <div class="p-2 rounded-full flex items-center justify-center lg:hidden" style="background: linear-gradient(180deg, rgba(0, 0, 0, 0.56) 0%, rgba(0, 0, 0, 0.8) 100%);">
                                        <svg width="18" height="18" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.22998 5.46289C3.0584 5.46289 3.72997 6.13447 3.72998 6.96289V8.12109H4.97803C5.80645 8.12109 6.47803 8.79267 6.47803 9.62109C6.47777 10.4493 5.80629 11.1211 4.97803 11.1211H3.22998C1.84967 11.1208 0.730241 10.0014 0.72998 8.62109V6.96289C0.729987 6.13464 1.4018 5.46317 2.22998 5.46289ZM6.42627 3.41797C7.64967 3.41797 8.64111 4.41039 8.64111 5.63379C8.64087 6.85699 7.64952 7.84863 6.42627 7.84863H6.27686C5.0536 7.84863 4.06225 6.85699 4.06201 5.63379C4.06201 4.41039 5.05346 3.41797 6.27686 3.41797H6.42627ZM9.47412 0.145508C10.8546 0.145663 11.9739 1.2651 11.9741 2.64551V4.30371C11.9741 5.13204 11.3024 5.80356 10.4741 5.80371C9.6457 5.80371 8.97413 5.13213 8.97412 4.30371V3.14551H7.72607C6.89765 3.14551 6.22607 2.47393 6.22607 1.64551C6.22631 0.817285 6.8978 0.145508 7.72607 0.145508H9.47412Z" fill="url(#paint0_linear_479_1744)" />
                                            <defs>
                                                <linearGradient id="paint0_linear_479_1744" x1="6.10051" y1="0.145508" x2="6.10051" y2="10.6451" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="white"/>
                                                    <stop offset="1" stop-color="white" stop-opacity="0.7"/>
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>

                                <div class="mb-4 hidden lg:block">
                                    <div class="mb-4">
                                        <img class="w-[140px] mb-2" src="{{ asset('images/tikcktocklogo.png') }}" alt="Tick Tock Logo">
                                        <h2 class="text-transparent hidden lg:block bg-clip-text bg-[linear-gradient(75.62deg,_#565656_62.01%,_rgba(132,132,132,0.5)_103.64%)] font-semibold text-[40px] lg:text-[64px]">{{ $discount->name }}</h2>
                                    </div>

                                    @if ($discount->description)
                                        <p class="text-black font-semibold text-[20px] max-w-[55%] lg:max-w-[35%] hidden lg:block">
                                            {!! $discount->description !!}
                                        </p>
                                    @endif
                                </div>

                                <a href="{{ route('discount.show', ['id' => $discount->id]) }}" class="group lg:flex items-center gap-2 text-gray-800 font-medium hover:text-gray-900 transition-colors duration-200 hidden z-9">
                                    <span class="text-themeblue">Reveal Offer</span>
                                    <span class="text-lg group-hover:translate-x-1 transition-transform duration-200 text-themeblue">→</span>
                                </a>

                                @if ($promoImage)
                                    <img src="{{ asset('storage/' . $promoImage) }}"
                                        alt="{{ $discount->name }}"
                                        class="absolute right-0 lg:-right-8 -bottom-[90px] lg:-bottom-[120px] h-[200px] lg:h-[350px] xl:h-[450px] w-full lg:object-bottom-right object-contain drop-shadow-lg scale-200 lg:scale-150" />
                                @endif

                                <div class="absolute top-4 right-4 p-3 bg-gray-600 rounded-full lg:flex items-center justify-center hidden">
                                    <svg width="32" height="31" viewBox="0 0 32 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.36084 18.4702C3.18896 18.4704 3.86059 19.1421 3.86084 19.9702V27.2749H11.4634C12.2915 27.2751 12.9631 27.9468 12.9634 28.7749C12.9634 29.6032 12.2916 30.2747 11.4634 30.2749H3.36084C1.98029 30.2747 0.86084 29.1555 0.86084 27.7749V19.9702C0.861089 19.1421 1.53273 18.4704 2.36084 18.4702ZM20.5962 8.23096C22.253 8.23097 23.5962 9.57411 23.5962 11.231V19.9058C23.596 21.5624 22.2529 22.9057 20.5962 22.9058H11.4263C9.76956 22.9058 8.4265 21.5624 8.42627 19.9058V11.231C8.42627 9.5741 9.76941 8.23096 11.4263 8.23096H20.5962ZM28.6655 0.86084C30.0461 0.861027 31.1655 1.98024 31.1655 3.36084V11.1655C31.1655 11.9938 30.4938 12.6653 29.6655 12.6655C28.8373 12.6653 28.1655 11.9938 28.1655 11.1655V3.86084H20.563C19.7347 3.86065 19.063 3.18915 19.063 2.36084C19.063 1.53253 19.7347 0.861034 20.563 0.86084H28.6655Z" fill="url(#paint0_linear_754_1551)"/>
                                    <defs>
                                    <linearGradient id="paint0_linear_754_1551" x1="15.3352" y1="0.86084" x2="15.3352" y2="28.9993" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="white"/>
                                    <stop offset="1" stop-color="white" stop-opacity="0.7"/>
                                    </linearGradient>
                                    </defs>
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Banner after 1st and 2nd set --}}
                    @if ($index == 0)
                        <div class="w-full my-12">
                            <a href="{{ route('products.index') }}">
                                <img class="w-full h-full rounded-[14px]" src="{{ asset('images/TT-BANNER.jpg') }}" alt="">
                            </a>
                        </div>
                    @elseif ($index == 1)
                        <div class="w-full my-12">
                            <a href="{{ route('products.index') }}">
                                <img class="w-full h-full rounded-[14px]" src="{{ asset('images/AF-BANNER.jpg') }}" alt="">
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </main>
    </div>

    {{-- <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-12 sm:px-6 lg:px-8">
        @if ($this->saleCollection)
            <x-collection-sale />
        @endif

        @if ($this->randomCollection)
            <section>
                <h2 class="text-3xl font-bold">
                    {{ $this->randomCollection->translateAttribute('name') }}
                </h2>

                <div class="grid grid-cols-2 mt-8 lg:grid-cols-4 gap-x-4 gap-y-8">
                    @foreach ($this->randomCollection->products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </section>
        @endif
    </div> --}}
</div>
