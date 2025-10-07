<x-layouts.app.guest>
    <div
        class="relative mx-auto flex flex-col items-center justify-center text-center min-h-[100vh] bg-gradient-to-br from-[#0c0d2d] via-[#0c153d] to-[#0c0d2d] text-white px-4">

        <div class="relative bg-white/5 backdrop-blur-sm rounded-2xl shadow-2xl px-10 py-12 border border-white/10">

            <!-- Big 404 -->
            <h1 class="text-[120px] font-extrabold text-[#1375ee] drop-shadow-lg">
                404
            </h1>

            <!-- Title -->
            <h2 class="mt-4 text-3xl font-semibold">
                @if (Str::startsWith($exception->getMessage(), 'The route'))
                    Oops! Page not found
                @elseif (!empty($exception->getMessage()))
                    {{ $exception->getMessage() }}
                @else
                    Oops! Page not found
                @endif
            </h2>

            
            <!-- Subtitle -->
            <p class="mt-2 max-w-lg text-gray-300 mx-auto">
                The page you’re looking for doesn’t exist or has been moved.
                Let’s get you back on track!
            </p>

            <!-- CTA Buttons -->
            <div class="mt-8 flex flex-wrap gap-4 justify-center">
                <a href="{{ route('home') }}"
                    class="px-6 py-3 bg-[#1375ee] hover:bg-[#0f5ec0] rounded-lg text-white font-medium transition-all shadow-md">
                    Go Home
                </a>
                <a href="{{ route('contact') }}"
                    class="px-6 py-3 border border-[#1375ee] rounded-lg text-[#1375ee] hover:bg-[#1375ee] hover:text-white font-medium transition-all">
                    Contact Support
                </a>
            </div>

            <!-- Glow Effects -->
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute top-1/4 -left-28 w-72 h-72 bg-[#1375ee]/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-1/3 -right-28 w-96 h-96 bg-[#1375ee]/30 rounded-full blur-3xl"></div>
            </div>
        </div>

    </div>
</x-layouts.app.guest>
