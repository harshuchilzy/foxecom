<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Foxecom</title>
    <meta
        name="description"
        content="Foxecom Meta"
    >

    <link
        rel="icon"
        href="{{ asset('favicon.svg') }}"
    >
    @livewireStyles
    {{-- @stripeScripts --}}
    @include('partials.head')
</head>

<body class="antialiased text-gray-900">
    <header class="relative border-b border-gray-100">
        <div class="flex items-center h-16 px-4 mx-auto max-w-screen-2xl sm:px-6 lg:px-8">
            <a
                class="flex items-center flex-shrink-0"
                href="{{ url('/') }}"
            >
                <span class="sr-only">Home</span>

                <x-brand.logo class="w-auto h-6 text-indigo-600" />
            </a>
        </div>
    </header>


    <main>
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>
