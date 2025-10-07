<x-layouts.app.layout>
    <!-- Partners Page Content (place inside your site's main content area between header and footer) -->
    <div class="max-w-[1440px] mx-auto px-4 py-12">
        <!-- Page title & intro -->
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight">Our Partners</h1>
            <p class="mt-3 text-gray-600">We proudly collaborate with leading brands and distributors in the vapor
                industry.</p>
        </div>

        <!-- Logo cloud / partner grid -->
        <div class="mt-12 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-8">
            <!-- Card 1 -->
            {{-- <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="VapeCo logo" class="mb-4" />
                <h3 class="text-base font-semibold">VapeCo</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Premium e‑liquids & flavors.</p>
            </div>
            <!-- Card 2 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="CloudMasters logo" class="mb-4" />
                <h3 class="text-base font-semibold">CloudMasters</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Performance devices & design.</p>
            </div>
            <!-- Card 3 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="NicFree Labs logo" class="mb-4" />
                <h3 class="text-base font-semibold">NicFree Labs</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Nicotine‑free solutions.</p>
            </div>
            <!-- Card 4 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="EcoVapor logo" class="mb-4" />
                <h3 class="text-base font-semibold">EcoVapor</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Sustainable packaging focus.</p>
            </div>
            <!-- Card 5 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="FlavorWorks logo" class="mb-4" />
                <h3 class="text-base font-semibold">FlavorWorks</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Unique & exotic flavors.</p>
            </div>
            <!-- Card 6 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="TechVape logo" class="mb-4" />
                <h3 class="text-base font-semibold">TechVape</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Smart, advanced devices.</p>
            </div>
            <!-- Card 7 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="PodCraft logo" class="mb-4" />
                <h3 class="text-base font-semibold">PodCraft</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Pods & coil ecosystems.</p>
            </div>
            <!-- Card 8 -->
            <div
                class="flex flex-col items-center bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <img src="{{ asset('images/logo.png') }}" alt="Volt Labs logo" class="mb-4" />
                <h3 class="text-base font-semibold">Volt Labs</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Batteries & accessories.</p>
            </div> --}}
        </div>

        <!-- CTA -->
        <div class="mt-16 text-center">
            <h2 class="text-2xl font-bold">Interested in partnering with us?</h2>
            <p class="mt-3 text-gray-600">We welcome collaborations with brands, distributors, and suppliers worldwide.
            </p>
            <a href="{{ route('contact') }}"
                class="inline-block mt-6 px-6 py-3 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-700 transition">Become
                a Partner</a>
        </div>
    </div>

</x-layouts.app.layout>
