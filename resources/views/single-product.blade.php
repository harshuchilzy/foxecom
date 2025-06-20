<x-layouts.app.layout>

    <div class="max-w-[1440px] mx-auto px-4 py-12">
        <div class="flex flex-col md:flex-row gap-6 lg:gap-12 items-start">
            <div x-data="{
                    images: [
                        {{-- '{{ asset('images/titan10k.png') }}',
                        '{{ asset('images/lostmarybm6.png') }}',
                        '{{ asset('images/elfbar1.png') }}', --}}
                        @foreach($product->variants as $variant)
                            @foreach($variant->images as $image)
                                '{{ $image->getUrl() }}',
                            @endforeach
                        @endforeach
                    ],
                    currentIndex: 0,
                    zoom: 1,
                    show: false,
                    open(index) {
                        this.currentIndex = index;
                        this.zoom = 1;
                        this.show = true;
                    },
                    close() {
                        this.show = false;
                        this.zoom = 1;
                    },
                    zoomIn() {
                        if (this.zoom < 3) this.zoom += 0.2;
                    },
                    zoomOut() {
                        if (this.zoom > 1) this.zoom -= 0.2;
                    },
                    next() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    },
                    prev() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
                    },
                    set(index) {
                        this.currentIndex = index;
                    }
                }"
                class="flex gap-4 lg:gap-8 items-center w-full md:w-1/2 flex-col-reverse lg:flex-row ">

                <div class="flex flex-row lg:flex-col justify-center lg:justify-between items-center gap-3 lg:w-[30%]">
                    <template x-for="(img, index) in images" :key="index">
                        <img class="w-[20%] lg:w-[70%] border-2" :class="{
                                    'border-black': currentIndex === index,
                                    'border-transparent': currentIndex !== index
                                }" @click="set(index)" :src="img" alt="">
                    </template>
                </div>
                <div class="lg:w-[70%] w-full relative">
                    <img class="m-auto md:w-full lg:w-[70%] h-[400px] lg:h-auto object-contain" :src="images[currentIndex]" alt="">
                    <!-- Prev/Next Buttons -->
                    <button @click="prev();" class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-r cursor-pointer">◀</button>
                    <button @click="next();" class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-l cursor-pointer">▶</button>
                    <!-- Lightbox Trigger -->
                    <div class="absolute top-0 right-0">
                        <button @click="open(currentIndex);" class=" transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-l cursor-pointer">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M16.1429 1.25C15.7286 1.25 15.3929 1.58579 15.3929 2C15.3929 2.41421 15.7286 2.75 16.1429 2.75H20.1893L14.4697 8.46967C14.1768 8.76256 14.1768 9.23744 14.4697 9.53033C14.7626 9.82322 15.2374 9.82322 15.5303 9.53033L21.25 3.81066V7.85714C21.25 8.27136 21.5858 8.60714 22 8.60714C22.4142 8.60714 22.75 8.27136 22.75 7.85714V2C22.75 1.58579 22.4142 1.25 22 1.25H16.1429Z" fill="#1C274C"></path> <path d="M7.85714 22.75C8.27136 22.75 8.60714 22.4142 8.60714 22C8.60714 21.5858 8.27136 21.25 7.85714 21.25H3.81066L9.53033 15.5303C9.82322 15.2374 9.82322 14.7626 9.53033 14.4697C9.23744 14.1768 8.76256 14.1768 8.46967 14.4697L2.75 20.1893V16.1429C2.75 15.7286 2.41421 15.3929 2 15.3929C1.58579 15.3929 1.25 15.7286 1.25 16.1429V22C1.25 22.4142 1.58579 22.75 2 22.75H7.85714Z" fill="#1C274C"></path> </g></svg>
                        </button>
                    </div>
                </div>
                <x-lightbox />
            </div>
            <div class="w-full md:w-1/2">
                <div class="flex justify-between items-center my-3 flex-wrap">
                    <h1 class="text-[20px] md:text-[26px] font-bold text-black font-inter">{{$product->translateAttribute('name')}}</h1>
                    <button>
                        <svg class="group cursor-pointer" width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path class="group-hover:fill-[#E53935]" d="M6.42634 16.1588L16.3672 26.0996L26.308 16.1588C28.8036 13.6633 28.8036 9.61719 26.308 7.12165C23.8125 4.62612 19.7664 4.62612 17.2709 7.12165L16.3672 8.02537L15.4635 7.12165C12.9679 4.62612 8.92188 4.62612 6.42634 7.12165C3.9308 9.61719 3.9308 13.6633 6.42634 16.1588Z" stroke="black" stroke-width="1.3125" stroke-linejoin="round"/></svg>
                    </button>
                </div>

                <div class="flex items-center gap-4 mb-8 border-b-2 border-black pb-4">
                    <div class="flex items-baseline gap-5 border-r border-black pr-3">
                        <p class="line-through text-[22px] md:text-[28px] font-normal text-black">
                            @if($product->variant->first()->prices->count() > 0)
                                {{ $product->variant->first()->prices->first()->price->formatted }}
                            @endif
                        </p>
                        <p class="text-[30px] md:text-[40px] text-[#1275EE] font-normal">
                            @if($product->variant->first()->prices->count() > 0)
                                {{ $product->variant->first()->prices->first()->compare_price->formatted }}
                            @endif
                        </p>

                        {{-- @foreach($product->variants as $variant)
                            <div class="variant">
                                @foreach($variant->images as $image)
                                    <img
                                        src="{{ $image->getUrl() }}"
                                        alt="{{ $variant->name }}"
                                        class="variant-image"
                                    >
                                @endforeach

                            </div>
                        @endforeach --}}
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <div>
                            <svg width="89" height="18" viewBox="0 0 89 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.74884 2.95918C8.49029 2.51361 7.84683 2.51361 7.58828 2.95918L5.76744 6.09716C5.63972 6.31727 5.41896 6.46747 5.16734 6.50548L1.75496 7.02088C1.18183 7.10744 0.980788 7.83107 1.42714 8.20087L3.96921 10.307C4.20452 10.5019 4.31517 10.8094 4.25801 11.1096L3.59304 14.6017C3.48792 15.1537 4.06743 15.5826 4.56466 15.3208L7.77785 13.629C8.02241 13.5002 8.31471 13.5002 8.55928 13.629L11.7725 15.3208C12.2697 15.5826 12.8492 15.1537 12.7441 14.6017L12.0791 11.1096C12.022 10.8094 12.1326 10.5019 12.3679 10.307L14.91 8.20087C15.3563 7.83108 15.1553 7.10744 14.5822 7.02088L11.1698 6.50548C10.9182 6.46747 10.6974 6.31727 10.5697 6.09716L8.74884 2.95918Z" fill="black"/><path d="M26.8504 2.95918C26.5919 2.51361 25.9484 2.51361 25.6898 2.95918L23.869 6.09716C23.7413 6.31727 23.5205 6.46747 23.2689 6.50548L19.8565 7.02088C19.2834 7.10744 19.0824 7.83107 19.5287 8.20087L22.0708 10.307C22.3061 10.5019 22.4167 10.8094 22.3596 11.1096L21.6946 14.6017C21.5895 15.1537 22.169 15.5826 22.6662 15.3208L25.8794 13.629C26.124 13.5002 26.4163 13.5002 26.6608 13.629L29.874 15.3208C30.3713 15.5826 30.9508 15.1537 30.8456 14.6017L30.1807 11.1096C30.1235 10.8094 30.2342 10.5019 30.4695 10.307L33.0115 8.20087C33.4579 7.83108 33.2569 7.10744 32.6837 7.02088L29.2713 6.50548C29.0197 6.46747 28.799 6.31727 28.6712 6.09716L26.8504 2.95918Z" fill="black"/><path d="M44.952 2.95918C44.6934 2.51361 44.05 2.51361 43.7914 2.95918L41.9706 6.09716C41.8428 6.31727 41.6221 6.46747 41.3705 6.50548L37.9581 7.02088C37.385 7.10744 37.1839 7.83107 37.6303 8.20087L40.1723 10.307C40.4076 10.5019 40.5183 10.8094 40.4611 11.1096L39.7962 14.6017C39.691 15.1537 40.2706 15.5826 40.7678 15.3208L43.981 13.629C44.2255 13.5002 44.5178 13.5002 44.7624 13.629L47.9756 15.3208C48.4728 15.5826 49.0523 15.1537 48.9472 14.6017L48.2822 11.1096C48.2251 10.8094 48.3357 10.5019 48.571 10.307L51.1131 8.20087C51.5595 7.83108 51.3584 7.10744 50.7853 7.02088L47.3729 6.50548C47.1213 6.46747 46.9005 6.31727 46.7728 6.09716L44.952 2.95918Z" fill="black"/><path d="M63.0535 2.95918C62.795 2.51361 62.1515 2.51361 61.893 2.95918L60.0721 6.09716C59.9444 6.31727 59.7237 6.46747 59.472 6.50548L56.0596 7.02088C55.4865 7.10744 55.2855 7.83107 55.7318 8.20087L58.2739 10.307C58.5092 10.5019 58.6199 10.8094 58.5627 11.1096L57.8977 14.6017C57.7926 15.1537 58.3721 15.5826 58.8693 15.3208L62.0825 13.629C62.3271 13.5002 62.6194 13.5002 62.864 13.629L66.0771 15.3208C66.5744 15.5826 67.1539 15.1537 67.0488 14.6017L66.3838 11.1096C66.3266 10.8094 66.4373 10.5019 66.6726 10.307L69.2147 8.20087C69.661 7.83108 69.46 7.10744 68.8868 7.02088L65.4745 6.50548C65.2228 6.46747 65.0021 6.31727 64.8744 6.09716L63.0535 2.95918Z" fill="black"/><path d="M81.1551 2.95918C80.8965 2.51361 80.2531 2.51361 79.9945 2.95918L78.1737 6.09716C78.046 6.31727 77.8252 6.46747 77.5736 6.50548L74.1612 7.02088C73.5881 7.10744 73.387 7.83107 73.8334 8.20087L76.3755 10.307C76.6108 10.5019 76.7214 10.8094 76.6643 11.1096L75.9993 14.6017C75.8942 15.1537 76.4737 15.5826 76.9709 15.3208L80.1841 13.629C80.4287 13.5002 80.721 13.5002 80.9655 13.629L84.1787 15.3208C84.6759 15.5826 85.2555 15.1537 85.1503 14.6017L84.4854 11.1096C84.4282 10.8094 84.5388 10.5019 84.7742 10.307L87.3162 8.20087C87.7626 7.83108 87.5615 7.10744 86.9884 7.02088L83.576 6.50548C83.3244 6.46747 83.1037 6.31727 82.9759 6.09716L81.1551 2.95918Z" fill="black"/></svg>
                        </div>
                        <div>
                            <p class="font-normal text-black text-[14px]">(32) reviews</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col items-start gap-3">
                    {!! $product->translateAttribute('short-description') !!}
                </div>

                <div class="mt-8">
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-4 mb-4 md:max-w-[90%]">
                        <select id="countries" class="bg-gray-50 border border-[#282828] text-gray-900 text-sm block px-[24px] rounded-[100px] w-full md:w-1/2 h-12 cursor-pointer font-inter">
                            @foreach ($product->productOptions as $option)
                                @foreach ($option->values as $value)
                                    <option value="{{ $value->id }}">{{ $value->translate('name') }}</option>
                                @endforeach
                            @endforeach
                        </select>

                        <button class="bg-[#282828] px-[24px] h-12 rounded-[100px] text-white text-center text-[18px] font-bold w-full md:w-1/2 cursor-pointer font-inter">Claim Offer</button>
                    </div>

                    <div class="md:max-w-[90%]">
                        <button class="bg-white px-[24px] py-[16px] rounded-[100px] text-[#282828] text-center text-[18px] font-bold w-full border border-[#282828] cursor-pointer font-inter">Claim Offer Now</button>
                    </div>

                    <div class="flex flex-col gap-3 mt-8">
                        <div class="flex items-center gap-3">
                            <span>
                                <svg width="27" height="24" viewBox="0 0 27 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.1168 14H14.2001C15.3918 14 16.3668 13.1 16.3668 12V2H6.61676C4.99176 2 3.5726 2.82999 2.83594 4.04999" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.28418 17C2.28418 18.66 3.73585 20 5.53418 20H6.61751C6.61751 18.9 7.59251 18 8.78418 18C9.97585 18 10.9508 18.9 10.9508 20H15.2842C15.2842 18.9 16.2592 18 17.4508 18C18.6425 18 19.6175 18.9 19.6175 20H20.7008C22.4992 20 23.9508 18.66 23.9508 17V14H20.7008C20.105 14 19.6175 13.55 19.6175 13V10C19.6175 9.45 20.105 9 20.7008 9H22.0983L20.2459 6.01001C19.8559 5.39001 19.1409 5 18.3609 5H16.3675V12C16.3675 13.1 15.3925 14 14.2008 14H13.1175" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8.78385 22C9.98047 22 10.9505 21.1046 10.9505 20C10.9505 18.8954 9.98047 18 8.78385 18C7.58724 18 6.61719 18.8954 6.61719 20C6.61719 21.1046 7.58724 22 8.78385 22Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M17.4508 22C18.6475 22 19.6175 21.1046 19.6175 20C19.6175 18.8954 18.6475 18 17.4508 18C16.2542 18 15.2842 18.8954 15.2842 20C15.2842 21.1046 16.2542 22 17.4508 22Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.9505 12V14H20.7005C20.1047 14 19.6172 13.55 19.6172 13V10C19.6172 9.45 20.1047 9 20.7005 9H22.098L23.9505 12Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.28418 8H8.78418" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.28418 11H6.61751" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.28418 14H4.45085" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>

                            <span class="text-[16px] font-normal text-black font-inter">Free worldwide shipping </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span>
                                <svg width="27" height="26" viewBox="0 0 27 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.375 10.0317L13.1167 13.3576L18.815 10.0534" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M13.1162 19.2508V13.3467" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.7736 6.81434L8.30696 8.74267C7.52696 9.176 6.87695 10.2702 6.87695 11.1693V14.8418C6.87695 15.741 7.51613 16.8352 8.30696 17.2685L11.7736 19.1968C12.5103 19.6085 13.7236 19.6085 14.4711 19.1968L17.9378 17.2685C18.7178 16.8352 19.3678 15.741 19.3678 14.8418V11.1585C19.3678 10.2593 18.7286 9.16517 17.9378 8.73183L14.4711 6.8035C13.7236 6.39183 12.5103 6.39184 11.7736 6.81434Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M23.9505 16.25C23.9505 20.4425 20.5597 23.8333 16.3672 23.8333L17.5047 21.9375" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M2.28418 9.74984C2.28418 5.55734 5.67501 2.1665 9.86751 2.1665L8.73003 4.06234" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>

                            <span class="text-[16px] font-normal text-black font-inter">Delivers in: 1-2 Working Days <a href="" class="underline"> Shipping & Return</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full bg-[#F8F8F8] py-12">
        <div class="max-w-[1440px] mx-auto px-4 font-inter" x-data="{ expanded: false, maxHeight: '220px', fullHeight: 'auto' }" x-init="$nextTick(() => fullHeight = $refs.content.scrollHeight + 'px')">
            <h2 class="text-[26px] lg:text-[32px] font-bold text-black mb-6">Unmatched Features for an Exceptional Vaping Journey</h2>
            <div class="space-y-2 overflow-hidden transition-all duration-300 ease-in-out relative mb-4" x-ref="content" x-bind:style="`max-height: ${expanded ? fullHeight : maxHeight};`">

                <span class="long-description-wrapper list-disc list-inside font-semibold text-[14px] md:text-[16px] lg:text-[20px] text-black flex flex-col gap-3">
                    {!!$product->translateAttribute('long-description')!!}
                </span>

                {!!$product->translateAttribute('status')!!}
                <style>
                    .long-description-wrapper ul, .long-description-wrapper ul li ol{
                        list-style-type: disc;
                        list-style-position: inside
                    }
                    .long-description-wrapper ul li ol {
                        margin-left: 2rem;
                    }
                </style>
                <div x-show="!expanded" class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#F8F8F8] to-transparent"></div>
            </div>

            <button @click="expanded = !expanded" class="text-[#1275EE] text-[14px] md:text-[16px] lg:text-[20px] font-bold cursor-pointer">
                <span x-text="expanded ? 'See Less' : 'See More'"></span>
            </button>
            </div>
        </div>

    </div>

    <div class="max-w-[1440px] mx-auto px-4 py-12">
        <div class="pb-5">
            <h2 class="font-semibold text-black text-[26px] lg:text-[32px] font-hanken-grotesk lg:ml-13 ml-0">Retailers Also Claimed : </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
            @php
                $crossSellAssociations = $product->associations->filter(function ($association) {
                    return $association->type === 'cross-sell';
                });
            @endphp

            @foreach ($crossSellAssociations as $association)
                @php
                    $relatedProduct = $association->target;
                @endphp

                <x-product-cards.retailer-card :relatedProduct="$relatedProduct"/>
            @endforeach

        </div>
    </div>



</x-layouts.app.layout>
