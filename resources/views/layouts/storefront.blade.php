<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <title>Demo Storefront</title>
    <meta
        name="description"
        content="Example of an ecommerce storefront built with Lunar."
    >
    <link
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >

    <link
        rel="icon"
        href="{{ asset('favicon.svg') }}"
    >
    
    @include('partials.head')
</head>

<body class="antialiased text-gray-900">
    {{-- @livewire('components.navigation') --}}
    <x-header />

    <main class="!p-0">
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>
