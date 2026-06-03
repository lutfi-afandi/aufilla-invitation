<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="{{ asset('assets/css/bunny-inter-playfair.css') }}" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-brand-dark antialiased bg-brand-bg">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-6 relative overflow-hidden">
            
            <!-- Aesthetic Background Overlay -->
            <div class="absolute inset-0 z-0 pointer-events-none">
                <!-- Base Image from Hero (Grayscale) -->
                <img src="{{ asset('assets/img/wedding-aesthetic-bg.jpg') }}" alt="Background" class="w-full h-full object-cover grayscale opacity-[0.08] mix-blend-multiply">
                
                <!-- Dual Tone Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-br from-brand-bg/95 via-brand-bg/90 to-[#EAD9B8]/40 backdrop-blur-[1px]"></div>
                
                <!-- Floating Ornaments -->
                <div class="absolute -right-40 top-0 w-[600px] h-[600px] rounded-full bg-brand-accent/[.06] blur-[100px] pointer-events-none z-0"></div>
                <div class="absolute -left-20 bottom-0 w-[500px] h-[500px] rounded-full bg-brand-dark/[.03] blur-[100px] pointer-events-none z-0"></div>
            </div>

            <!-- Content Container -->
            <div class="relative z-10 w-full sm:max-w-[420px]">
                <!-- Logo Header -->
                <div class="mb-8 text-center flex flex-col items-center justify-center group">
                    <a href="/" class="flex flex-col items-center gap-3 focus:outline-none transform transition-transform duration-500 group-hover:scale-105">
                        <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla" class="h-14 w-auto object-contain drop-shadow-md">
                        <div class="flex flex-col items-center">
                            <span class="text-[26px] font-serif text-brand-dark tracking-tight leading-none">
                                Aufilla<span class="italic text-brand-accent">Invitation</span>
                            </span>
                            <span class="text-[9px] font-sans font-bold tracking-[0.3em] uppercase text-brand-dark/50 mt-2">
                                Undangan Digital
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Form Card -->
                <div class="bg-white/80 backdrop-blur-xl px-8 py-10 shadow-2xl shadow-brand-dark/10 sm:rounded-[2rem] border border-brand-dark/5 relative">
                    <!-- Subtle top glow -->
                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-brand-accent/50 to-transparent opacity-50"></div>
                    
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
