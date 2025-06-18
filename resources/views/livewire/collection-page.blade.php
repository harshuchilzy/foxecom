{{-- <section>
    <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold">
            {{ $this->collection->translateAttribute('name') }}
        </h1>

        <div class="grid grid-cols-1 gap-8 mt-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($this->collection->products as $product)
                <x-product-cards.general-card :product="$product" />
            @empty
            @endforelse
        </div>
    </div>
</section> --}}

<div>
    <div class="relative w-full h-[320px] bg-no-repeat bg-cover bg-center" style="background-image: url('{{ $this->collection->thumbnail->getUrl() ?? asset('/images/wholesale-hero.jpg') }}')">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Content -->
        <div class="absolute inset-0 flex items-center justify-start pr-8 md:pr-16 max-w-[1280px] mx-auto">
            <h1 class="text-3xl font-bold text-white max-w-[80%]">
                {{ $this->collection->translateAttribute('name') }}
            </h1>
        </div>
    </div>


    <div class="max-w-[1280px] mx-auto px-2 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 md:gap-5">
            @if ($this->collection && !empty($this->collection->products))
                @foreach ($this->collection->products as $product)
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

