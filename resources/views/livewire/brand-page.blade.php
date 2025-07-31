<div>
    <!-- Brand hero section -->
    <div class="relative w-full h-[220px] md:h-[320px] bg-no-repeat bg-cover bg-center"
     style="background-image: url('{{ asset('/images/wholesale-hero.jpg') }}')">

        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Brand title and logo -->
        <div class="absolute inset-0 flex flex-col md:flex-row items-center justify-center md:justify-between gap-4 px-4 md:px-8 2xl:px-0 max-w-[1280px] mx-auto">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-white text-center md:text-left max-w-[90%] sm:max-w-[80%] leading-snug">
                {{ $this->brand->name }}
            </h1>

            @if ($this->brand->thumbnail)
                <img 
                    src="{{ $this->brand->thumbnail->getUrl() }}" 
                    alt="{{ $this->brand->name }}"
                    class="w-20 h-20 md:w-28 md:h-28 object-contain"
                />
            @endif
        </div>
    </div>

    <!-- Brand products section -->
    <div class="max-w-[1280px] mx-auto px-2 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
            @if ($this->brand && !empty($this->brand->products))
                @foreach ($this->brand->products as $product)
                    <x-product-cards.general-card :product="$product" />
                @endforeach
            @else
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No products found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
