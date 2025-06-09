<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Single Product</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />



    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
           
        </style>
    @endif
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-white">
    <x-header />
    <div class="mx-auto">
        {{ $slot }}
    </div>
    <x-footer />
</body>
</html>