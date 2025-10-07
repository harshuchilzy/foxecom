<div>
    <!-- Collection hero section -->
    <div class="relative w-full h-[220px] md:h-[320px] bg-no-repeat bg-cover bg-center"
     style="background-image: url('{{ $this->collection->thumbnail?->getUrl() ? $this->collection->thumbnail?->getUrl() : asset('/images/wholesale-hero.jpg') }}')">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Collection title -->
        <div class="absolute inset-0 flex items-center 2xl:justify-start justify-center px-4 md:px-8 2xl:px-0 max-w-[1280px] mx-auto">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white max-w-[90%] sm:max-w-[80%] leading-snug">
                {{ $this->collection->translateAttribute('name') }}
            </h1>
        </div>
    </div>


    <!-- Collection products section -->
    <div class="max-w-[1280px] mx-auto px-2 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
            @if ($this->collection && !empty($this->collection->products))
                @foreach ($this->collection->products as $product)
                    <x-product-cards.general-card :product="$product" />
                @endforeach
            @else
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">{{ __('No products found.') }}</p>
                </div>
            @endif
        </div>
    </div>
</div>

