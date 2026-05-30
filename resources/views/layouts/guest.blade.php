<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-brand-bg relative overflow-hidden">
            <!-- Decorative background blob (optional elegance) -->
            <div class="absolute top-0 left-0 w-full h-96 bg-brand-light opacity-20 rounded-b-[100%] z-0 pointer-events-none transform -translate-y-24"></div>

            <div class="relative z-10 mb-4 transition-transform hover:scale-105 duration-300">
                <a href="/" class="focus:outline-none">
                    <x-application-logo />
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-2xl border-t-4 border-brand-dark relative z-10">
                @yield('content')
            </div>
        </div>
    </body>
</html>
