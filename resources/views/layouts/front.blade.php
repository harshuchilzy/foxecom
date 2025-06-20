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
        rel="shortcut icon"
        href="{{ asset('images/blacklogo.png') }}"
    >
    
    @include('partials.head')
</head>

<body class="antialiased text-gray-900">
    @livewire('components.navigation')

    <main>
        {{ $slot }}
    </main>

    <x-footer />

    @livewireScripts
</body>

</html>
