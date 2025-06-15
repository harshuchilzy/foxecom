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
        href="{{ asset('css/app.css') }}"
        rel="stylesheet"
    >

    <link
        rel="icon"
        href="{{ asset('images/blacklogo.png') }}"
    >
    
    @include('partials.head')
</head>

<body class="antialiased text-gray-900">
    {{-- @livewire('components.navigation') --}}
    @livewire('components.navigation')

    <main class="!p-0">
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>
