<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Zen+Kaku+Gothic+Antique&display=swap" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-white antialiased">
        <div style="background-image: url({{url('images/reg-bg.webp')}})" class="bg-cover bg-no-repeat bg-left-top flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-3xl flex-col gap-2 max-h-max md:max-h-screen overflow-y-hidden">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex items-center justify-center rounded-md">
                        <x-app-logo-icon />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6 bg-white p-5 rounded-lg shadow-md overflow-y-scroll">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
