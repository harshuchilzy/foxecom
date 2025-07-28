{{-- <section>
    <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8">
        <div class="grid items-start grid-cols-1 gap-8 md:grid-cols-2">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-1">
                @if ($this->image)
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="object-cover rounded-xl"
                             src="{{ $this->image->getUrl('large') }}"
                             alt="{{ $this->product->translateAttribute('name') }}" />
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach ($this->images as $image)
                        <div class="aspect-w-1 aspect-h-1"
                             wire:key="image_{{ $image->id }}">
                            <img loading="lazy"
                                 class="object-cover rounded-xl"
                                 src="{{ $image->getUrl('small') }}"
                                 alt="{{ $this->product->translateAttribute('name') }}" />
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold">
                        {{ $this->product->translateAttribute('name') }}
                    </h1>

                    <x-product-price class="ml-4 font-medium"
                                     :variant="$this->variant" />
                </div>

                <p class="mt-1 text-sm text-gray-500">
                    {{ $this->variant->sku }}
                </p>

                <article class="mt-4 text-gray-700">
                    {!! $this->product->translateAttribute('description') !!}
                </article>

                <form class="mt-4">
                    <div class="space-y-4">
                        @foreach ($this->productOptions as $option)
                            <fieldset>
                                <legend class="text-xs font-medium text-gray-700">
                                    {{ $option['option']->translate('name') }}
                                </legend>

                                <div class="flex flex-wrap gap-2 mt-2 text-xs tracking-wide uppercase"
                                     x-data="{
                                         selectedOption: @entangle('selectedOptionValues').live,
                                         selectedValues: [],
                                     }"
                                     x-init="selectedValues = Object.values(selectedOption);
                                     $watch('selectedOption', value =>
                                         selectedValues = Object.values(selectedOption)
                                     )">
                                    @foreach ($option['values'] as $value)
                                        <button class="px-6 py-4 font-medium border rounded-lg focus:outline-none focus:ring"
                                                type="button"
                                                wire:click="
                                                $set('selectedOptionValues.{{ $option['option']->id }}', {{ $value->id }})
                                            "
                                                :class="{
                                                    'bg-indigo-600 border-indigo-600 text-white hover:bg-indigo-700': selectedValues
                                                        .includes({{ $value->id }}),
                                                    'hover:bg-gray-100': !selectedValues.includes({{ $value->id }})
                                                }">
                                            {{ $value->translate('name') }}
                                        </button>
                                    @endforeach
                                </div>
                            </fieldset>
                        @endforeach
                    </div>

                    <div class="max-w-xs mt-8">
                        <livewire:components.add-to-cart :purchasable="$this->variant"
                                                         :wire:key="$this->variant->id">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section> --}}

<section>
    <div class="relative bg-white md:hidden mx-3">
        <div x-data="{
                images: [
                    @if(!empty($this->images) && count($this->images) > 0)
                    @foreach($this->images as $image)

                            '{{ $image->getUrl() }}',

                        @endforeach
                    @else

                        '{{ asset('images/placeholder.jpg') }}'

                    @endif
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
             class="flex gap-4 lg:gap-5 items-center w-full md:w-1/2 flex-col-reverse lg:flex-row pb-8">

            <div class="flex-row lg:flex-col justify-center lg:justify-between items-center gap-3 lg:w-[25%] hidden">
                <template x-for="(img, index) in images" :key="index">
                    <img class="w-[20%] lg:w-[70%] border-2" :class="{
                                'border-black': currentIndex === index,
                                'border-transparent': currentIndex !== index
                            }" @click="set(index)" :src="img" alt="">

                </template>
                {{-- <span x-text="images"></span> --}}
            </div>
            <div class="lg:w-[75%] w-full relative p-5 lg:p-0 bg-[#F4F4F4] lg:bg-white rounded-[25px]">
                <img class="m-auto md:w-full lg:w-[90%] h-[400px] lg:h-auto object-contain" :src="images[currentIndex]"
                     alt="">
                <!-- Prev/Next Buttons -->
                {{-- <button @click="prev();" class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-r cursor-pointer">◀</button>
                <button @click="next();" class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-l cursor-pointer">▶</button> --}}
                <!-- Lightbox Trigger -->
                <div class="absolute top-0 right-0">
                    <button @click="open(currentIndex);"
                            class=" transform bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-l cursor-pointer">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M16.1429 1.25C15.7286 1.25 15.3929 1.58579 15.3929 2C15.3929 2.41421 15.7286 2.75 16.1429 2.75H20.1893L14.4697 8.46967C14.1768 8.76256 14.1768 9.23744 14.4697 9.53033C14.7626 9.82322 15.2374 9.82322 15.5303 9.53033L21.25 3.81066V7.85714C21.25 8.27136 21.5858 8.60714 22 8.60714C22.4142 8.60714 22.75 8.27136 22.75 7.85714V2C22.75 1.58579 22.4142 1.25 22 1.25H16.1429Z"
                                    fill="#1C274C"></path>
                                <path
                                    d="M7.85714 22.75C8.27136 22.75 8.60714 22.4142 8.60714 22C8.60714 21.5858 8.27136 21.25 7.85714 21.25H3.81066L9.53033 15.5303C9.82322 15.2374 9.82322 14.7626 9.53033 14.4697C9.23744 14.1768 8.76256 14.1768 8.46967 14.4697L2.75 20.1893V16.1429C2.75 15.7286 2.41421 15.3929 2 15.3929C1.58579 15.3929 1.25 15.7286 1.25 16.1429V22C1.25 22.4142 1.58579 22.75 2 22.75H7.85714Z"
                                    fill="#1C274C"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <x-lightbox/>
        </div>
    </div>

    <div class="max-w-[1440px] mx-auto px-4 py-5 lg:py-12">

        <div class="flex flex-col md:flex-row gap-6 lg:gap-12 items-start">

            <div x-data="{
                    images: [
                        @if(!empty($this->images) && count($this->images) > 0)
                           @foreach($this->images as $image)

                                '{{ $image->getUrl() }}',

                            @endforeach
                        @else

                            '{{ asset('images/placeholder.jpg') }}'

                        @endif
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
                 class="hidden md:flex gap-4 lg:gap-5 items-center w-full md:w-1/2 flex-col-reverse lg:flex-row ">

                <div class="flex flex-row lg:flex-col justify-center lg:justify-between items-center gap-3 lg:w-[25%]">
                    <template x-for="(img, index) in images" :key="index">
                        <img class="w-[20%] lg:w-[70%] border-2 cursor-pointer" :class="{
                                    'border-black': currentIndex === index,
                                    'border-transparent': currentIndex !== index
                                }" @click="set(index)" :src="img" alt="">

                    </template>
                    {{-- <span x-text="images"></span> --}}
                </div>
                <div class="lg:w-[75%] w-full relative p-5 lg:p-0 bg-[#F4F4F4] lg:bg-white rounded-[25px]">
                    <img class="m-auto md:w-full lg:w-[90%] h-[400px] lg:h-auto object-contain"
                         :src="images[currentIndex]" alt="">
                    <!-- Prev/Next Buttons -->
                    {{-- <button @click="prev();" class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-r cursor-pointer">◀</button>
                    <button @click="next();" class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-l cursor-pointer">▶</button> --}}
                    <!-- Lightbox Trigger -->
                    <div class="absolute top-0 right-0">
                        <button @click="open(currentIndex);"
                                class=" transform -translate-y-1/2 bg-white/30 hover:bg-gray-200 text-black font-bold py-2 px-4 rounded-l cursor-pointer">
                            <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M16.1429 1.25C15.7286 1.25 15.3929 1.58579 15.3929 2C15.3929 2.41421 15.7286 2.75 16.1429 2.75H20.1893L14.4697 8.46967C14.1768 8.76256 14.1768 9.23744 14.4697 9.53033C14.7626 9.82322 15.2374 9.82322 15.5303 9.53033L21.25 3.81066V7.85714C21.25 8.27136 21.5858 8.60714 22 8.60714C22.4142 8.60714 22.75 8.27136 22.75 7.85714V2C22.75 1.58579 22.4142 1.25 22 1.25H16.1429Z"
                                        fill="#1C274C"></path>
                                    <path
                                        d="M7.85714 22.75C8.27136 22.75 8.60714 22.4142 8.60714 22C8.60714 21.5858 8.27136 21.25 7.85714 21.25H3.81066L9.53033 15.5303C9.82322 15.2374 9.82322 14.7626 9.53033 14.4697C9.23744 14.1768 8.76256 14.1768 8.46967 14.4697L2.75 20.1893V16.1429C2.75 15.7286 2.41421 15.3929 2 15.3929C1.58579 15.3929 1.25 15.7286 1.25 16.1429V22C1.25 22.4142 1.58579 22.75 2 22.75H7.85714Z"
                                        fill="#1C274C"></path>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                <x-lightbox/>
            </div>

            <div class="w-full md:w-1/2">
                <div class="flex lg:justify-start md:justify-between items-center mt-3 mb-1 flex-wrap pl-3 lg:pl-0">
                    <h1 class="text-[20px] md:text-[26px] font-bold text-black font-inter text-center lg:text-left">{{$this->product->translateAttribute('name')}}</h1>
                    <button class="hidden">
                        <svg class="group cursor-pointer" width="33" height="32" viewBox="0 0 33 32" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path class="group-hover:fill-[#E53935]"
                                  d="M6.42634 16.1588L16.3672 26.0996L26.308 16.1588C28.8036 13.6633 28.8036 9.61719 26.308 7.12165C23.8125 4.62612 19.7664 4.62612 17.2709 7.12165L16.3672 8.02537L15.4635 7.12165C12.9679 4.62612 8.92188 4.62612 6.42634 7.12165C3.9308 9.61719 3.9308 13.6633 6.42634 16.1588Z"
                                  stroke="black" stroke-width="1.3125" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div class="md:hidden flex items-center justify-between px-3 lg:px-4">
                    <x-product-price class="font-medium flex justify-between items-center" :variant="$this->variant"/>
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                    $full_stars = floor($this->formattedAverage);
                                    $has_half = ($this->formattedAverage - $full_stars) > 0;
                                    $star_fill = 0;

                                    if ($i <= $full_stars) {
                                        $star_fill = 100;
                                    } elseif ($i === $full_stars + 1 && $has_half) {
                                        $star_fill = ($this->formattedAverage - $full_stars) * 100;
                                    }
                                @endphp

                                <div class="relative w-4 h-4">
                                    <svg class="absolute w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.564-.955L10 0l2.948 5.955 6.564.955-4.756 4.635 1.122 6.545z"/>
                                    </svg>

                                    @if ($star_fill > 0)
                                        <div class="absolute overflow-hidden top-0 left-0 h-full" style="width: {{ $star_fill }}%">
                                            <svg class="w-4 h-4 text-black fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.564-.955L10 0l2.948 5.955 6.564.955-4.756 4.635 1.122 6.545z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>

                        <div>
                            <p class="font-normal text-black text-[14px] font-inter">({{ $this->reviewCount }} reviews)</p>
                        </div>
                    </div>
                </div>

                <div class="md:hidden flex w-full">
                    <div id="short-description-accordion-flush" data-accordion="collapse"
                         data-active-classes="bg-white text-gray-900 w-full"
                         data-inactive-classes="text-gray-500 w-full" class="w-full px-5 py-3 my-3 rounded-[8px] [box-shadow:0px_4px_14px_0px_#0000001A]">
                        <h2 id="short-description-accordion-flush-heading-1 w-full">
                            <button type="button" class="flex lg:mb-3 items-center justify-between !w-full py-1 lg:py-5 font-medium rtl:text-right text-gray-500 lg:border-b border-gray-200 gap-3" data-accordion-target="#short-description-accordion" aria-expanded="true" aria-controls="short-description-accordion">
                            <span>Descripion</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                            </svg>
                            </button>
                        </h2>
                        <div id="short-description-accordion" class="hidden"
                             aria-labelledby="short-description-accordion-flush-heading-1">
                            <div class="flex flex-col items-start gap-3">
                                {!! $this->product->translateAttribute('short-description') !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:flex items-center gap-4 mb-8 border-b-2 border-black pb-4 hidden">
                    <div class="items-baseline gap-5 border-r border-black pr-3 relative">
                        @if (auth()->check())
                            <x-product-price class="font-medium flex items-baseline flex-wrap gap-4" :variant="$this->variant" />
                        @else
                            <p class="text-[16px] font-semibold text-[#1275EE]">Register to see the price</p>
                        @endif

                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="flex items-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @php
                                    $full_stars = floor($this->formattedAverage);
                                    $has_half = ($this->formattedAverage - $full_stars) > 0;
                                    $star_fill = 0;

                                    if ($i <= $full_stars) {
                                        $star_fill = 100;
                                    } elseif ($i === $full_stars + 1 && $has_half) {
                                        $star_fill = ($this->formattedAverage - $full_stars) * 100;
                                    }
                                @endphp

                                <div class="relative w-4 h-4">
                                    <svg class="absolute w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.564-.955L10 0l2.948 5.955 6.564.955-4.756 4.635 1.122 6.545z"/>
                                    </svg>

                                    @if ($star_fill > 0)
                                        <div class="absolute overflow-hidden top-0 left-0 h-full" style="width: {{ $star_fill }}%">
                                            <svg class="w-4 h-4 text-black fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.122-6.545L.488 6.91l6.564-.955L10 0l2.948 5.955 6.564.955-4.756 4.635 1.122 6.545z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>

                        <div>
                            <p class="font-normal text-black text-[14px] font-inter">({{ $this->reviewCount }} reviews)</p>
                        </div>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-start gap-3">
                    {!! $this->product->translateAttribute('short-description') !!}
                </div>
                {{-- <pre>
                {{print_r($this->product, true)}}
                </pre> --}}
                <form class="mt-4">
                    <div class="space-y-4">
                        @if (count($this->productOptions))
                            @foreach ($this->productOptions as $option)
                                <fieldset class="mb-1">
                                    {{-- <legend class="text-xs font-medium text-gray-700">
                                        {{ $option['option']->translate('name') }}
                                    </legend> --}}
                                    <div class="mt-4">
                                        <label for="quantity"
                                               class="sr-only">
                                            Quantity
                                        </label>

                                        <label for="quantity" class="sr-only">Choose quantity:</label>

                                    </div>

                                    <div class="md:max-w-[90%]">
                                        <div class="flex flex-col items-center md:items-start gap-1 mb-2 mt-2"
                                             x-data="{
                                                selectedOption: @entangle('selectedOptionValues').live,
                                                selectedValues: [],
                                            }"
                                             x-init="selectedValues = Object.values(selectedOption);
                                            $watch('selectedOption', value =>
                                                selectedValues = Object.values(selectedOption)
                                            )">

                                            <legend class="text-xs font-medium text-gray-700">
                                                {{ $option['option']->translate('name') }}
                                                <span>:
                                                    {{optional(
                                                        collect($option['values'])->firstWhere('id', $selectedOptionValues[$option['option']->id] ?? null)
                                                    )?->translate('name')}}
                                                </span>
                                            </legend>

                                            <select
                                                id="option-select-{{ $option['option']->id }}"
                                                class="bg-gray-50 border border-[#282828] text-gray-900 text-sm block px-[24px] rounded-[100px] w-full h-12 cursor-pointer font-inter"
                                                wire:change="$set('selectedOptionValues.{{ $option['option']->id }}', $event.target.value)"
                                            >
                                                <option value="">-- Select {{ $option['option']->translate('name') }}
                                                    --
                                                </option>

                                                @foreach ($option['values'] as $value)
                                                    <option value="{{ $value->id }}"
                                                            @if(isset($selectedOptionValues[$option['option']->id]) && $selectedOptionValues[$option['option']->id] == $value->id)
                                                                selected
                                                        @endif
                                                    >
                                                        {{ $value->translate('name') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            @endforeach
                            <div class="w-full md:max-w-[90%] mb-4">
                                @if (auth()->check())
                                    <livewire:components.add-to-cart :purchasable="$this->variant" :wire:key="$this->variant->id" :quantity="$this->quantity">
                                @endif

                            </div>
                        @else
                            <fieldset>
                                <legend class="text-xs font-medium text-gray-700">
                                    {{-- {{ $option['option']->translate('name') }} --}}
                                </legend>

                                <div
                                    class="flex flex-col md:flex-row md:items-start gap-4 mb-4 md:max-w-[90%] mt-4 items-center"
                                    x-data="{
                                        selectedOption: @entangle('selectedOptionValues').live,
                                        selectedValues: [],
                                    }"
                                    x-init="selectedValues = Object.values(selectedOption);
                                    $watch('selectedOption', value =>
                                        selectedValues = Object.values(selectedOption)
                                    )">

                                    <div class="w-full">
                                        @if (auth()->check())
                                            <livewire:components.add-to-cart :purchasable="$this->variant" :wire:key="$this->variant->id" :quantity="$quantity">
                                        @endif
                                    </div>
                                </div>
                            </fieldset>
                        @endif
                    </div>

                </form>


                <div class="">
                    {{-- <div class="flex flex-col md:flex-row items-center md:items-start gap-4 mb-4 md:max-w-[90%]">
                        <select id="countries" class="bg-gray-50 border border-[#282828] text-gray-900 text-sm block px-[24px] rounded-[100px] w-full md:w-1/2 h-12 cursor-pointer font-inter">
                            @foreach ($this->product->productOptions as $option)
                                @foreach ($option->values as $value)
                                    <option value="{{ $value->id }}">{{ $value->translate('name') }}</option>
                                @endforeach
                            @endforeach
                        </select>

                        <button class="bg-[#282828] px-[24px] h-12 rounded-[100px] text-white text-center text-[18px] font-bold w-full md:w-1/2 cursor-pointer font-inter">Claim Offer</button>
                    </div> --}}

                    @if ($discountId)
                        <div class="md:max-w-[90%] mt-5">
                            {{-- <form wire:submit.prevent="claimOffer">
                                <button
                                    class="bg-[#F7B538] lg:bg-white px-[24px] py-[12px] lg:py-[16px] rounded-[100px] text-[#282828] text-center text-[18px] font-bold w-full lg:border border-[#282828] cursor-pointer font-inter" @click="showModal = true">
                                    Claim Offer Now
                                </button>
                             </form> --}}
                        </div>

                        <div x-data="{ showModal: @entangle('showBulkAddToCartPopup') }">
                            <!-- Trigger Button -->
                            <div class="md:max-w-[90%] mt-5">
                                <button
                                    class="bg-[#F7B538] lg:bg-white px-[24px] py-[16px] rounded-[100px] text-[#282828] text-center text-[18px] font-bold w-full lg:border border-[#282828] cursor-pointer font-inter" @click="showModal = true">
                                    Claim Offer Now
                                </button>
                            </div>

                            <!-- Modal -->
                            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm overflow-auto">
                                <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl mx-4 p-6 relative max-h-[90vh] overflow-auto" @click.away="showModal = false">
                                    <!-- Close Button -->
                                    <button @click="showModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-200 text-2xl font-bold cursor-pointer">&times;</button>

                                    <!-- Product Name -->
                                    <h2 class="text-2xl font-semibold mb-6 text-center opacity-90 font-inter">
                                        {{ $this->product->translateAttribute('name') }}
                                    </h2>
                                    @php
                                        $selectedItems = $this->getSumOfSelectedToggles();
                                    @endphp
                                    <p class="font-medium text-center">
                                        You can purchase up to <span class="font-semibold text-themeblue">{{ sprintf('%02d', $this->maxQuantityIncrement) }}</span> items.
                                        @if ($this->rewardItems)
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-md ">Including {{ sprintf('%02d', $this->rewardItems) }} FREE item(s)</span>
                                        @endif
                                    </p>
                                    <div class="border-b-2 border-gray-300 mb-4 text-center pb-2">
                                        <strong class="{{ $selectedItems > $this->maxQuantityIncrement ? 'text-red-600' : 'text-themeblue' }}">Selected: {{ $selectedItems === 0 ? '0' : sprintf('%02d', $selectedItems) }} item(s)</strong>
                                    </div>


                                    <!-- Product Boxes -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        @foreach($this->loadVariations() as $index => $variant)

                                            <div x-data="{ isSelected: $wire.entangle('toggles.' + {{ $variant['id'] }}) }"
                                                :class="isSelected ? 'border-blue-600' : 'border-gray-300'"
                                                class="border-2 rounded-lg p-4 flex flex-col md:flex-row items-center text-center gap-3 transition-colors duration-200">
                                                <img
                                                    src="{{ $variant['image_url'] }}"
                                                    alt=""
                                                    class="w-32 min-w-32 h-32 min-h-32 object-cover rounded"
                                                >

                                                <div class="flex flex-col justify-between w-full h-full">
                                                    <div class="md:text-left text-center">
                                                        <div class="text-lg font-medium font-inter">{{ $variant['name'] }}</div>
                                                        <div class="flex flex-col md:items-start items-center md:pb-2 pb-4">
                                                            <span class="text-[#1275EE] text-lg font-semibold">
                                                                {{ $variant['price'] }} + VAT
                                                            </span>
                                                            <div class="border border-[#D9D9D9] rounded-[50px] flex flex-row items-center gap-2 px-1 w-[80%] lg:w-[50%]">
                                                                <button type="button"
                                                                        class="px-2 border-0 border-[#757575] cursor-pointer text-3xl"
                                                                        wire:click="decrementQuantity({{ $variant['id'] }})">-
                                                                </button>
                                                                <input type="number"
                                                                    min="1"
                                                                    wire:model.live="quantities.{{ $variant['id'] }}"
                                                                    class="w-full text-center flex justify-center border-0 p-0 m-0 nobutton"/>
                                                                <button type="button"
                                                                        class="px-2 border-0 border-[#757575] cursor-pointer text-3xl"
                                                                        wire:click="incrementQuantity({{ $variant['id'] }})">+
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex md:justify-end justify-center">
                                                        <x-wui-toggle
                                                            id="toggle_{{ $variant['id'] }}"
                                                            wire:model.live="toggles.{{ $variant['id'] }}"
                                                            info xl />
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if ($errors->has('bulk-popup-error'))
                                        <div class="p-2 mt-4 text-xs font-medium text-center text-red-700 rounded bg-red-50"
                                            role="alert">
                                            @foreach ($errors->get('bulk-popup-error') as $error)
                                                {{ $error }}
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Add to Cart Button -->
                                    <div class="mt-6 text-center">
                                        <button type="button"
                                                class="bg-[#282828] px-[24px] h-12 rounded-[100px] text-white text-center text-[18px] font-bold !w-full md:w-1/2 cursor-pointer font-inter"
                                                wire:click="addSelectedToCart"
                                                wire:loading.attr="disabled">
                                            <span wire:loading.remove>Add to Cart</span>
                                            <span wire:loading>Adding...</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- discount name --}}
                    @if ($discountId)
                        @php
                            $matchedDiscount = \Lunar\Models\Discount::find($discountId);
                            $discountParts = explode(' ', $matchedDiscount?->name, 3); // Basic splitting
                        @endphp
                        @if ($matchedDiscount)
                            <div style="background-image: url('{{ asset('images/offerbgimg.png') }}');"
                                 class="p-4 mt-5 bg-contain bg-no-repeat bg-center absolute right-0 top-[150px] w-[135px] h-[350px] flex flex-col items-start justify-center md:hidden">
                                @php
                                    $name = $matchedDiscount->name;
                                    $parts = preg_split('/\b(Get|get)\b/i', $name, 2, PREG_SPLIT_DELIM_CAPTURE);
                                @endphp

                                @if(count($parts) === 3)
                                    <p class="text-[16px] font-normal text-white font-inter">
                                        {{ trim($parts[0]) }}
                                    </p>
                                    <p class="text-[16px] font-bold text-white font-inter">
                                        {{ 'Get' . trim($parts[2]) }}
                                    </p>
                                @else
                                    <p class="text-[16px] font-normal text-white font-inter">
                                        {{ $name }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    @endif

                    <div class="flex flex-col gap-3 mt-8">
                        <div class="flex items-center gap-3">
                            <span>
                                <svg width="27" height="24" viewBox="0 0 27 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg"><path
                                        d="M13.1168 14H14.2001C15.3918 14 16.3668 13.1 16.3668 12V2H6.61676C4.99176 2 3.5726 2.82999 2.83594 4.04999"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path
                                        d="M2.28418 17C2.28418 18.66 3.73585 20 5.53418 20H6.61751C6.61751 18.9 7.59251 18 8.78418 18C9.97585 18 10.9508 18.9 10.9508 20H15.2842C15.2842 18.9 16.2592 18 17.4508 18C18.6425 18 19.6175 18.9 19.6175 20H20.7008C22.4992 20 23.9508 18.66 23.9508 17V14H20.7008C20.105 14 19.6175 13.55 19.6175 13V10C19.6175 9.45 20.105 9 20.7008 9H22.0983L20.2459 6.01001C19.8559 5.39001 19.1409 5 18.3609 5H16.3675V12C16.3675 13.1 15.3925 14 14.2008 14H13.1175"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path
                                        d="M8.78385 22C9.98047 22 10.9505 21.1046 10.9505 20C10.9505 18.8954 9.98047 18 8.78385 18C7.58724 18 6.61719 18.8954 6.61719 20C6.61719 21.1046 7.58724 22 8.78385 22Z"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path
                                        d="M17.4508 22C18.6475 22 19.6175 21.1046 19.6175 20C19.6175 18.8954 18.6475 18 17.4508 18C16.2542 18 15.2842 18.8954 15.2842 20C15.2842 21.1046 16.2542 22 17.4508 22Z"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path
                                        d="M23.9505 12V14H20.7005C20.1047 14 19.6172 13.55 19.6172 13V10C19.6172 9.45 20.1047 9 20.7005 9H22.098L23.9505 12Z"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path d="M2.28418 8H8.78418" stroke="black"
                                                                       stroke-width="1.5" stroke-linecap="round"
                                                                       stroke-linejoin="round"/><path
                                        d="M2.28418 11H6.61751" stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path d="M2.28418 14H4.45085" stroke="black"
                                                                       stroke-width="1.5" stroke-linecap="round"
                                                                       stroke-linejoin="round"/></svg>
                            </span>

                            <span class="text-[16px] font-normal text-black font-inter">Free worldwide shipping </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span>
                                <svg width="27" height="26" viewBox="0 0 27 26" fill="none"
                                     xmlns="http://www.w3.org/2000/svg"><path
                                        d="M7.375 10.0317L13.1167 13.3576L18.815 10.0534" stroke="black"
                                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path
                                        d="M13.1162 19.2508V13.3467" stroke="black" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"/><path
                                        d="M11.7736 6.81434L8.30696 8.74267C7.52696 9.176 6.87695 10.2702 6.87695 11.1693V14.8418C6.87695 15.741 7.51613 16.8352 8.30696 17.2685L11.7736 19.1968C12.5103 19.6085 13.7236 19.6085 14.4711 19.1968L17.9378 17.2685C18.7178 16.8352 19.3678 15.741 19.3678 14.8418V11.1585C19.3678 10.2593 18.7286 9.16517 17.9378 8.73183L14.4711 6.8035C13.7236 6.39183 12.5103 6.39184 11.7736 6.81434Z"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path
                                        d="M23.9505 16.25C23.9505 20.4425 20.5597 23.8333 16.3672 23.8333L17.5047 21.9375"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/><path
                                        d="M2.28418 9.74984C2.28418 5.55734 5.67501 2.1665 9.86751 2.1665L8.73003 4.06234"
                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/></svg>
                            </span>

                            <span class="text-[16px] font-normal text-black font-inter">Delivers in: 1-2 Working Days <a
                                    href="{{ route('delivery-policy') }}"
                                    class="underline"> Shipping & Return</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="w-full bg-[#F8F8F8] py-12">
        <div
            class="max-w-[1440px] mx-auto px-4 font-inter"
            x-data="{
                expanded: false,
                maxHeight: 220,
                fullHeight: 0,
                showToggle: false,
                init() {
                    this.$nextTick(() => {
                        this.fullHeight = this.$refs.content.scrollHeight;
                        this.showToggle = this.fullHeight > this.maxHeight;
                    });
                }
            }"
        >
            <h2 class="text-[26px] lg:text-[32px] font-bold text-black mb-6">
                Unmatched Features for an Exceptional Vaping Journey
            </h2>

            <div
                class="space-y-2 overflow-hidden transition-all duration-300 ease-in-out relative mb-4"
                x-ref="content"
                x-bind:style="`max-height: ${expanded ? fullHeight + 'px' : maxHeight + 'px'}`"
            >
                    <span
                        class="long-description-wrapper list-disc list-inside font-semibold text-[14px] md:text-[16px] lg:text-[20px] text-black flex flex-col gap-3">
                        {!! $this->product->translateAttribute('description') !!}
                    </span>

                <!-- Only show the fade effect when not expanded -->
                <div x-show="!expanded && showToggle"
                     class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-[#F8F8F8] to-transparent pointer-events-none mb-0"></div>

                <style>
                    .long-description-wrapper ul, .long-description-wrapper ul li ol {
                        list-style-type: disc;
                        list-style-position: inside;
                    }

                    .long-description-wrapper ul li ol {
                        margin-left: 2rem;
                    }
                </style>
            </div>

            <!-- Conditionally show toggle button only if content exceeds max height -->
            <button
                x-show="showToggle"
                @click="expanded = !expanded"
                class="text-[#1275EE] text-[14px] md:text-[16px] lg:text-[20px] font-bold cursor-pointer"
            >
                <span x-text="expanded ? 'See Less' : 'See More'"></span>
            </button>
        </div>

    </div>


    @if ($this->suggestedProducts->isNotEmpty())
        <div class="max-w-[1440px] mx-auto px-4 py-5 lg:py-12">
            <div class="pb-5">
                <h2 class="font-semibold text-black text-[26px] lg:text-[32px] font-hanken-grotesk lg:ml-13 ml-0">
                    Retailers Also Claimed : </h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">

                @if(count($this->crossSellAssociations) > 0)
                    @foreach ($this->crossSellAssociations as $association)
                        <x-product-cards.retailer-card :relatedProduct="$association->target"/>
                    @endforeach
                @else
                    @foreach ($this->suggestedProducts as $relatedProduct)
                        <x-product-cards.retailer-card :relatedProduct="$relatedProduct"/>
                    @endforeach
                @endif

            </div>
        </div>
    @endif

    <div class="max-w-[1440px] mx-auto px-4 py-5 lg:py-12">
        <button @click="$wire.openReviewPopup()" class="bg-themeblue text-white px-4 py-2 rounded hover:bg-blue-700 cursor-pointer font-inter font-bold">
            Write a Review
        </button>
    </div>

    @if($showReviewPopup)
        <div class="fixed inset-0  bg-opacity-10 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-6 relative">
                <h2 class="text-2xl font-bold text-black mb-4">Write a Review</h2>
                <button @click="$wire.closeReviewPopup()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <form wire:submit.prevent="submitReview" class="space-y-4">
                    <div>
                        <label for="reviewer_name" class="block font-medium text-sm text-gray-700">Name</label>
                        <input type="text" id="reviewer_name" wire:model="reviewForm.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('reviewForm.name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="reviewer_email" class="block font-medium text-sm text-gray-700">Email</label>
                        <input type="email" id="reviewer_email" wire:model="reviewForm.email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('reviewForm.email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    {{-- <div>
                        <label for="rating" class="block font-medium text-sm text-gray-700">Rating (1-5)</label>
                        <input type="number" min="1" max="5" id="rating" wire:model="reviewForm.rating" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('reviewForm.rating') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div> --}}
                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">Rating</label>
                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++)
                                <button
                                    type="button"
                                    wire:click="$set('reviewForm.rating', {{ $i }})"
                                    class="focus:outline-none cursor-pointer"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-8 w-8 {{ $i <= $reviewForm['rating'] ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current' }}"
                                        viewBox="0 0 20 20"
                                    >
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </button>
                            @endfor
                        </div>
                        <input
                            type="hidden"
                            id="rating"
                            wire:model="reviewForm.rating"
                        >
                        @error('reviewForm.rating')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="review" class="block font-medium text-sm text-gray-700">Review</label>
                        <textarea id="review" rows="4" wire:model="reviewForm.review" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                        @error('reviewForm.review') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="review_images" class="block font-medium text-sm text-gray-700">Upload Images</label>
                        <input type="file" id="review_images" wire:model="reviewForm.images" multiple accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('reviewForm.images.*') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                        <div class="flex gap-2 mt-2">
                            @if (!empty($reviewForm['images']))
                                @foreach ($reviewForm['images'] as $image)
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-20 h-20 object-cover rounded">
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="bg-black text-white px-6 py-2 rounded-md hover:bg-gray-800 mt-4 cursor-pointer" wire:loading.attr="disabled">
                        <span wire:loading.remove>Submit Review</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </form>
            </div>
        </div>
    @endif

    {{-- @php
    echo '<pre>';
        print_r($this->loadVariations());
        echo '</pre>';
    @endphp --}}

</section>
