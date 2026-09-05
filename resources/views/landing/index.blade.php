<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Aufilla Invitation') }} — Undangan Pernikahan Digital</title>

    <!-- SEO & Meta Tags -->
    <meta name="description"
        content="Buat undangan pernikahan digital premium, elegan, dan mudah digunakan. Bagikan momen kebahagiaan Anda tanpa batas dengan Aufilla Invitation.">
    <meta name="keywords"
        content="undangan pernikahan digital, undangan online, undangan website, buat undangan digital, aufilla invitation, undangan premium">
    <meta name="author" content="Aufilla Invitation">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="{{ config('app.name', 'Aufilla Invitation') }} — Undangan Pernikahan Digital">
    <meta property="og:description"
        content="Buat undangan pernikahan digital premium, elegan, dan mudah digunakan. Bagikan momen kebahagiaan Anda tanpa batas dengan Aufilla Invitation.">
    <meta property="og:image" content="{{ asset('assets/img/brand-white-og.png') }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="{{ config('app.name', 'Aufilla Invitation') }} — Undangan Pernikahan Digital">
    <meta name="twitter:description"
        content="Buat undangan pernikahan digital premium, elegan, dan mudah digunakan. Bagikan momen kebahagiaan Anda tanpa batas dengan Aufilla Invitation.">
    <meta name="twitter:image" content="{{ asset('assets/img/brand-white-og.png') }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Scoped: Landing page only ── */
        .lp-reveal {
            opacity: 0;
            transform: translateY(40px) scale(0.98);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .lp-reveal.is-visible {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .lp-delay-0 {
            transition-delay: 0s;
        }

        .lp-delay-1 {
            transition-delay: .1s;
        }

        .lp-delay-2 {
            transition-delay: .2s;
        }

        .lp-delay-3 {
            transition-delay: .3s;
        }

        .lp-delay-4 {
            transition-delay: .4s;
        }

        .lp-delay-5 {
            transition-delay: .5s;
        }

        .lp-delay-6 {
            transition-delay: .6s;
        }

        /* Smooth pulsing background */
        @keyframes pulse-soft {

            0%,
            100% {
                opacity: 0.5;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        .anim-pulse-soft {
            animation: pulse-soft 8s infinite alternate ease-in-out;
        }

        /* Floating ornaments */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .anim-float {
            animation: float 6s ease-in-out infinite;
        }

        /* FAQ Soft Reveal */
        details[open] .faq-content {
            animation: faqSlideDown 0.3s ease-out forwards;
        }

        @keyframes faqSlideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide Scrollbar */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

{{--
    Palet warna mengikuti tailwind.config.js brand tokens:
    brand-dark     #0a2214   (sidebar, hero aksen)
    brand-medium   #143521   (footer, kartu premium)
    brand-light    #235235   (hover)
    brand-accent   #c5a880   (gold / emas champagne)
    brand-bg       #fdfbf7   (off-white)
--}}

<body class="font-sans antialiased text-brand-dark bg-brand-bg overflow-x-hidden">

    {{-- ═══════════════════════════════════════════════
         PRELOADER / SPLASH SCREEN (Elegance Dark & Gold)
    ═══════════════════════════════════════════════ --}}
    <div id="landing-preloader"
        class="fixed inset-0 z-[99999] bg-[#0a2214] flex flex-col items-center justify-center transition-all duration-700 ease-in-out">
        <div class="relative flex flex-col items-center text-center px-4">
            {{-- Ring Spinner --}}
            <div class="relative w-20 h-20 mb-6 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-2 border-[#c5a880]/20 animate-ping"></div>
                <div
                    class="w-16 h-16 rounded-full border-2 border-t-[#c5a880] border-r-[#c5a880]/40 border-b-transparent border-l-transparent animate-spin">
                </div>
                <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Logo"
                    class="w-8 h-8 object-contain absolute inset-0 m-auto">
            </div>

            {{-- Brand Name & Tagline --}}
            <h2 class="font-serif text-2xl md:text-3xl text-white tracking-wide mb-1">
                Aufilla <span class="text-[#c5a880] italic font-normal">Invitation</span>
            </h2>
            <p class="text-[10px] md:text-[11px] text-[#c5a880]/80 tracking-[0.25em] uppercase font-light">
                Mewujudkan Momen Spesial Anda
            </p>

            {{-- Progress Bar --}}
            <div class="w-36 h-[2px] bg-white/10 rounded-full mt-6 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-transparent via-[#c5a880] to-transparent w-full animate-[preloader-bar_1.2s_ease-in-out_infinite]">
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes preloader-bar {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }
    </style>

    <script>
        (function() {
            function hidePreloader() {
                const loader = document.getElementById('landing-preloader');
                if (loader && !loader.classList.contains('opacity-0')) {
                    loader.classList.add('opacity-0', 'pointer-events-none');
                    setTimeout(() => {
                        loader.style.display = 'none';
                    }, 700);
                }
            }
            if (document.readyState === 'complete') {
                hidePreloader();
            } else {
                window.addEventListener('load', hidePreloader);
                setTimeout(hidePreloader, 1000);
            }
        })();
    </script>

    {{-- ═══════════════════════════════════════════════
         NAVBAR
    ═══════════════════════════════════════════════ --}}
    <nav x-data="{ mobileMenuOpen: false }" @click.outside="mobileMenuOpen = false"
        class="fixed top-0 inset-x-0 z-50 bg-white/90 backdrop-blur-xl border-b border-brand-accent/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-[75px] flex items-center justify-between relative z-50">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 hover:-translate-y-0.5 transition-transform duration-300">
                <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla Logo"
                    class="h-10 md:h-12 w-auto object-contain">
                <div class="flex flex-col justify-center">
                    <span class="text-[20px] md:text-[24px] font-serif text-brand-dark tracking-tight leading-none">
                        Aufilla<span class="italic text-brand-accent">Invitation</span>
                    </span>
                    <span
                        class="text-[8px] md:text-[9px] font-sans font-bold tracking-[0.3em] uppercase text-brand-dark/60 mt-1 pl-0.5">
                        Undangan Digital
                    </span>
                </div>
            </a>

            {{-- Nav Links --}}
            <div
                class="hidden md:flex items-center gap-10 text-[13px] font-bold tracking-wide text-brand-dark/90 uppercase">
                <a href="#" class="hover:text-brand-accent transition-colors duration-200">Home</a>
                <a href="#fitur" class="hover:text-brand-accent transition-colors duration-200">Fitur</a>
                <a href="#tema" class="hover:text-brand-accent transition-colors duration-200">Katalog Tema</a>
                <a href="#harga" class="hover:text-brand-accent transition-colors duration-200">Harga</a>
            </div>

            {{-- CTA --}}
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="hidden md:inline-flex px-6 py-2.5 rounded-full bg-brand-dark text-white text-[13px] font-semibold hover:bg-brand-accent transition-colors duration-300 shadow-lg shadow-brand-dark/20 hover:-translate-y-0.5 transform">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="hidden md:flex w-[42px] h-[42px] rounded-full items-center justify-center bg-brand-bg/50 backdrop-blur-md border border-brand-accent/30 text-brand-dark hover:bg-brand-accent hover:border-brand-accent hover:text-white transition-all duration-500 shadow-sm hover:shadow-xl hover:shadow-brand-accent/40 group relative overflow-hidden"
                        title="Masuk (Login)">
                        {{-- Shine Effect --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/30 to-white/0 opacity-0 group-hover:opacity-100 transition-opacity duration-700 transform -translate-x-full group-hover:translate-x-full ease-out">
                        </div>
                        <svg class="w-5 h-5 relative z-10 transition-transform duration-300 group-hover:scale-110"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </a>
                    <a href="{{ route('landing.register-form') }}"
                        class="hidden md:inline-flex px-6 py-2.5 rounded-full bg-brand-dark text-white text-[13px] font-semibold hover:bg-brand-accent transition-all duration-300 shadow-lg shadow-brand-dark/20 hover:shadow-brand-accent/30 hover:-translate-y-0.5 transform">
                        Buat Undangan
                    </a>
                @endauth

                {{-- Elegant Mobile Menu Toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden relative w-10 h-10 flex items-center justify-center text-brand-dark focus:outline-none focus:text-brand-accent bg-brand-dark/5 hover:bg-brand-dark/10 rounded-full transition-colors duration-300"
                    aria-label="Toggle Menu">
                    {{-- Hamburger Icon --}}
                    <svg class="w-5 h-5 absolute transition-all duration-500 ease-in-out"
                        :class="mobileMenuOpen ? 'opacity-0 rotate-90 scale-50' : 'opacity-100 rotate-0 scale-100'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    {{-- Close (X) Icon --}}
                    <svg class="w-5 h-5 absolute transition-all duration-500 ease-in-out"
                        :class="mobileMenuOpen ? 'opacity-100 rotate-0 scale-100' : 'opacity-0 -rotate-90 scale-50'"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu Dropdown with Smooth Alpine Transition --}}
        <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-6" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden bg-white/95 backdrop-blur-2xl border-t border-brand-accent/10 absolute top-[75px] left-0 w-full shadow-[0_15px_30px_rgb(0,0,0,0.08)] origin-top z-40">
            <div
                class="flex flex-col p-6 gap-3 text-[13px] font-bold tracking-wide text-brand-dark/90 uppercase text-center">
                <a @click="mobileMenuOpen = false" href="#"
                    class="mobile-link hover:text-brand-accent hover:bg-brand-dark/5 rounded-xl py-3 transition-colors">Home</a>
                <a @click="mobileMenuOpen = false" href="#fitur"
                    class="mobile-link hover:text-brand-accent hover:bg-brand-dark/5 rounded-xl py-3 transition-colors">Fitur</a>
                <a @click="mobileMenuOpen = false" href="#tema"
                    class="mobile-link hover:text-brand-accent hover:bg-brand-dark/5 rounded-xl py-3 transition-colors">Katalog
                    Tema</a>
                <a @click="mobileMenuOpen = false" href="#harga"
                    class="mobile-link hover:text-brand-accent hover:bg-brand-dark/5 rounded-xl py-3 transition-colors">Harga</a>

                <div class="pt-4 flex flex-col gap-3 border-t border-brand-dark/5 mt-2">
                    @auth
                        <a @click="mobileMenuOpen = false" href="{{ route('dashboard') }}"
                            class="mobile-link px-6 py-3.5 rounded-xl bg-brand-dark text-white text-[13px] font-semibold shadow-lg shadow-brand-dark/20 hover:scale-[1.02] transition-transform">Dashboard</a>
                    @else
                        <a @click="mobileMenuOpen = false" href="{{ route('landing.register-form') }}"
                            class="px-6 py-3.5 rounded-xl bg-brand-dark text-white text-[13px] font-semibold shadow-lg shadow-brand-dark/20 border-none hover:scale-[1.02] transition-transform block text-center">Buat
                            Undangan</a>
                        <a @click="mobileMenuOpen = false" href="{{ route('login') }}"
                            class="mobile-link flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-brand-bg border border-brand-dark/10 text-brand-dark font-semibold hover:border-brand-accent hover:text-brand-accent transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════════════ --}}
    <section
        class="relative pt-[140px] pb-20 md:pt-[180px] md:pb-28 overflow-hidden min-h-screen flex items-center bg-brand-bg">
        {{-- Gambar Latar Belakang (Free Commercial) dengan Overlay Dual Tone --}}
        <div class="absolute inset-0 z-0 pointer-events-none">
            {{-- Base Image --}}
            <img src="{{ asset('assets/img/wedding-aesthetic-bg.jpg') }}" alt="Wedding Aesthetic Background"
                class="w-full h-full object-cover grayscale opacity-40 mix-blend-multiply" fetchpriority="high"
                decoding="async">

            {{-- Dual Tone Gradient Overlay (Warm Gold to Soft Sage Green) --}}
            <div
                class="absolute inset-0 bg-gradient-to-tr from-[#EAD9B8]/80 via-brand-bg/90 to-[#DCE6DF]/90 backdrop-blur-[2px]">
            </div>

            {{-- Accent Glow --}}
            <div
                class="absolute inset-0 bg-gradient-to-b from-transparent via-brand-accent/5 to-transparent mix-blend-overlay">
            </div>
        </div>

        {{-- Dekorasi Shape (tetap dipertahankan untuk efek modern) --}}
        <div
            class="absolute -right-20 top-0 w-[800px] h-[800px] rounded-full bg-brand-accent/[.09] blur-[100px] pointer-events-none anim-pulse-soft z-0">
        </div>
        <div class="absolute -left-40 bottom-0 w-[600px] h-[600px] rounded-full bg-brand-dark/[.05] blur-[120px] pointer-events-none anim-pulse-soft z-0"
            style="animation-delay: -4s;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-10 grid md:grid-cols-2 gap-16 lg:gap-24 items-center relative z-10">

            {{-- ─── Kiri: Copywriting ─── --}}
            <div class="max-w-xl">
                <div
                    class="lp-reveal lp-delay-0 inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white shadow-sm border border-brand-accent/10 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span>
                    <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-dark">Undangan
                        Digital</span>
                </div>

                <h1
                    class="lp-reveal lp-delay-1 font-serif text-[3rem] md:text-[3.8rem] lg:text-[4.2rem] leading-[1.05] tracking-tight text-brand-dark mb-6">
                    Undangan <br>
                    <span class="italic text-brand-accent">Pernikahan</span> Digital
                </h1>

                <p
                    class="lp-reveal lp-delay-2 text-[16px] leading-relaxed text-brand-dark/90 mb-10 font-medium max-w-lg">
                    Undangan orang terdekatmu dengan mudah, praktis dan tanpa ada batasan menggunakan Undangan Digital
                    kekinian dari <strong class="text-brand-dark">Aufilla Invitation</strong>.
                </p>

                <div class="lp-reveal lp-delay-3 flex flex-wrap items-center gap-5">
                    <a href="{{ route('landing.register-form') }}"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-brand-dark text-white text-[13px] font-bold uppercase tracking-wider shadow-xl shadow-brand-dark/20 hover:bg-brand-accent hover:shadow-brand-accent/30 hover:-translate-y-1 transition-all duration-300">
                        Buat Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#tema"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-transparent border-2 border-brand-dark/20 text-brand-dark text-[13px] font-bold uppercase tracking-wider hover:border-brand-dark hover:bg-brand-dark/5 transition-all duration-300">
                        Lihat Tema
                    </a>
                </div>
            </div>

            {{-- ─── Kanan: Visual (Phone Mockup) ─── --}}
            <div class="hidden md:flex justify-center relative lp-reveal lp-delay-3">

                {{-- Phone Hardware Bezel --}}
                <div
                    class="relative w-[280px] rounded-[3.5rem] bg-[#f8f9fa] p-2 shadow-[0_20px_50px_rgba(10,34,20,0.2)] border border-[#e2e8f0] z-10 transform rotate-[-2deg] hover:rotate-0 transition-all duration-700 group hover:shadow-[0_20px_60px_rgba(197,168,128,0.3)]">

                    {{-- Outer Frame details (Side buttons simulation) --}}
                    <div class="absolute -left-[5px] top-24 w-[3px] h-12 bg-[#cbd5e1] rounded-l-md"></div>
                    <div class="absolute -left-[5px] top-40 w-[3px] h-12 bg-[#cbd5e1] rounded-l-md"></div>
                    <div class="absolute -right-[5px] top-32 w-[3px] h-16 bg-[#cbd5e1] rounded-r-md"></div>

                    {{-- Phone Screen --}}
                    <div
                        class="w-full aspect-[9/19.5] bg-brand-dark rounded-[3rem] overflow-hidden relative flex flex-col items-center justify-center text-center shadow-[inset_0_0_20px_rgba(0,0,0,0.8)] border-[6px] border-black">

                        {{-- Realistic Dynamic Island --}}
                        <div class="absolute top-2 inset-x-0 flex justify-center z-40">
                            <div class="w-24 h-7 bg-black rounded-full flex items-center justify-end px-3">
                                <div
                                    class="w-2 h-2 rounded-full bg-slate-800/80 shadow-[inset_0_0_2px_rgba(255,255,255,0.2)]">
                                </div>
                            </div>
                        </div>

                        {{-- Screen Background Image --}}
                        <img src="{{ asset('assets/img/wedding-aesthetic-bg.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-50 mix-blend-luminosity group-hover:scale-105 transition-transform duration-1000 ease-out"
                            alt="Mockup Undangan">

                        {{-- Dark Gradient Overlay for Contrast --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-b from-brand-dark/40 via-brand-dark/70 to-brand-dark/95">
                        </div>

                        {{-- Content Inside Phone Screen --}}
                        <div class="relative z-30 flex flex-col items-center w-full px-6 mt-6">

                            {{-- Bunga / Ornament Icon --}}
                            <div class="mb-6 relative">
                                <div class="absolute inset-0 bg-brand-accent/30 blur-xl rounded-full"></div>
                                <svg class="w-14 h-14 text-brand-accent relative drop-shadow-xl" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M12 22C12 22 4 16 4 10C4 6 7 4 10 4C11.5 4 12 5 12 5C12 5 12.5 4 14 4C17 4 20 6 20 10C20 16 12 22 12 22Z"
                                        fill-opacity="0.15" />
                                    <path
                                        d="M12 20.5C12 20.5 5 15.5 5 10C5 6.5 7.5 4.5 10 4.5C11.5 4.5 12 5.5 12 5.5C12 5.5 12.5 4.5 14 4.5C16.5 4.5 19 6.5 19 10C19 15.5 12 20.5 12 20.5Z"
                                        stroke="currentColor" stroke-width="1.5" fill="none" />
                                </svg>
                            </div>

                            <p class="text-[9px] tracking-[.35em] uppercase text-brand-accent/90 mb-3 font-semibold">
                                The Wedding Of</p>

                            {{-- Natural Names --}}
                            <h2
                                class="font-serif italic text-[38px] leading-none text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
                                Aditya</h2>
                            <span class="font-serif text-brand-accent text-3xl my-2 opacity-90">&amp;</span>
                            <h2
                                class="font-serif italic text-[38px] leading-none text-white drop-shadow-[0_2px_4px_rgba(0,0,0,0.5)]">
                                Nabila</h2>

                            {{-- Tanggal Dummy --}}
                            <div class="mt-8 mb-8 flex items-center justify-center gap-3 w-full">
                                <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent to-brand-accent/50"></div>
                                <span class="text-xs font-bold tracking-widest text-white/80">14.09.2026</span>
                                <div class="h-[1px] flex-1 bg-gradient-to-l from-transparent to-brand-accent/50"></div>
                            </div>

                            <button
                                class="w-full py-3.5 bg-brand-accent text-brand-dark text-[11px] font-bold tracking-widest uppercase rounded-full shadow-[0_10px_20px_rgba(197,168,128,0.3)] hover:bg-white transition-colors duration-300 flex items-center justify-center gap-2 group-hover:-translate-y-1">
                                Buka Undangan
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="absolute top-10 -right-10 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl shadow-brand-dark/10 p-4 flex items-center gap-3 z-20 animate-bounce"
                    style="animation-duration: 3s;">
                    <div
                        class="w-10 h-10 rounded-full bg-brand-accent/10 flex items-center justify-center text-brand-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-brand-dark">Unlimited</p>
                        <p class="text-[10px] text-brand-dark/70">Custom Nama Tamu</p>
                    </div>
                </div>
                <div class="absolute bottom-20 -left-12 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl shadow-brand-dark/10 p-4 flex items-center gap-3 z-20 animate-bounce"
                    style="animation-duration: 4s; animation-delay: 1s;">
                    <div
                        class="w-10 h-10 rounded-full bg-brand-dark/5 flex items-center justify-center text-brand-dark">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-brand-dark">Cepat & Praktis</p>
                        <p class="text-[10px] text-brand-dark/70">Proses Instant</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FITUR TERBAIK (CLONED CONTENT)
    ═══════════════════════════════════════════════ --}}
    <section id="fitur" class="py-24 px-6 lg:px-10 bg-white relative overflow-hidden">
        {{-- Ornamen --}}
        <div
            class="absolute top-0 -left-20 w-96 h-96 bg-brand-accent/[.04] rounded-full blur-[100px] pointer-events-none anim-pulse-soft z-0">
        </div>
        <svg class="absolute top-32 right-10 md:right-32 w-6 h-6 md:w-8 md:h-8 text-brand-accent/20 anim-float pointer-events-none z-0 hidden sm:block"
            style="animation-delay: -2s" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z" />
        </svg>

        <div class="max-w-5xl mx-auto relative z-10">

            <div class="text-center max-w-2xl mx-auto mb-16 lp-reveal lp-delay-0">
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-3 block">Fitur
                    Terbaik</span>
                <h2 class="font-serif text-4xl text-brand-dark mb-4">Lengkap & Eksklusif</h2>
                <p class="text-brand-dark/80 text-[15px] leading-relaxed">Dilengkapi berbagai fitur yang dapat
                    mempercantik dan melengkapi informasi di undangan website kamu.</p>
            </div>

            @php
                $features = [
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />',
                        'title' => 'Unlimited Share',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                        'title' => 'Custom Nama Tamu',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                        'title' => 'Buku Tamu & RSVP',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />',
                        'title' => 'Gallery Foto & Video',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                        'title' => 'Countdown Acara',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />',
                        'title' => 'Amplop Digital',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />',
                        'title' => 'Ucapan dan Doa',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
                        'title' => 'Cerita Cinta',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />',
                        'title' => 'Navigasi Lokasi',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />',
                        'title' => 'Backsound Musik',
                    ],
                    [
                        'icon' => '
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />',
                        'title' => 'Free Revisi',
                    ],
                ];
            @endphp

            <div class="flex flex-wrap justify-center gap-3 md:gap-4 max-w-5xl mx-auto">
                @foreach ($features as $index => $feature)
                    <div
                        class="lp-reveal lp-delay-{{ $index % 6 }} group bg-brand-dark hover:bg-brand-accent transition-all duration-300 rounded-xl p-5 md:p-6 flex flex-col items-center justify-center text-center min-h-[120px] shadow-sm hover:shadow-md cursor-default hover:-translate-y-1 flex-auto basis-[160px] md:basis-[220px] max-w-[280px]">
                        <svg class="w-8 h-8 md:w-9 md:h-9 mb-3 text-white group-hover:text-white transition-colors duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="1.5">{!! $feature['icon'] !!}</svg>
                        <h3 class="font-medium text-[12px] md:text-[13px] text-white leading-snug">
                            {{ $feature['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         THEMES (Katalog Tema)
    ═══════════════════════════════════════════════ --}}
    <section id="tema" x-data="{ activeCategory: 'all' }" class="py-24 px-6 lg:px-10 bg-brand-bg relative overflow-hidden">
        {{-- Ornamen --}}
        <div class="absolute bottom-0 -right-20 w-96 h-96 bg-brand-dark/[.03] rounded-full blur-[100px] pointer-events-none anim-pulse-soft z-0"
            style="animation-delay: -3s"></div>
        <svg class="absolute bottom-40 left-10 md:left-20 w-5 h-5 text-brand-accent/30 anim-float pointer-events-none z-0 hidden sm:block"
            style="animation-delay: -4s" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z" />
        </svg>

        <div class="max-w-7xl mx-auto relative z-10">

            <div class="text-center max-w-2xl mx-auto mb-10 lp-reveal lp-delay-0">
                <span
                    class="font-serif font-bold text-[36px] md:text-[42px] text-brand-dark block leading-none mb-2">Katalog</span>
                <h2
                    class="font-sans font-bold tracking-[0.2em] uppercase text-[11px] md:text-[12px] text-brand-accent mb-4">
                    Undangan Digital</h2>
                <p class="text-brand-dark/70 text-[13px] md:text-[14px] leading-relaxed max-w-md mx-auto">
                    Pilih tema desain eksklusif yang paling cocok untuk mencerminkan keindahan hari spesial Anda.
                </p>
            </div>

            {{-- Category Filter Tabs --}}
            <div class="flex items-center justify-center flex-wrap gap-2 sm:gap-3 mb-12 lp-reveal lp-delay-1">
                <button type="button" @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-brand-dark text-white shadow-md' : 'bg-white text-brand-dark/80 hover:bg-brand-dark/5 border border-brand-dark/10'"
                    class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200">
                    Semua Gaya
                </button>
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $cat)
                        <button type="button" @click="activeCategory = '{{ $cat->slug }}'"
                            :class="activeCategory === '{{ $cat->slug }}' ? 'bg-brand-dark text-white shadow-md' : 'bg-white text-brand-dark/80 hover:bg-brand-dark/5 border border-brand-dark/10'"
                            class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all duration-200">
                            {{ $cat->nama }}
                        </button>
                    @endforeach
                @endif
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-6">
                @foreach ($themes as $index => $theme)
                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $theme->category ?? 'minimalis' }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="bg-white rounded-xl sm:rounded-2xl shadow-sm border border-brand-dark/5 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col lp-reveal lp-delay-{{ $index % 4 }}">
                        <div
                            class="relative bg-brand-bg/30 aspect-[3/4] flex items-center justify-center overflow-hidden">
                            {{-- Theme Thumbnail --}}
                            <img src="{{ $theme->thumbnail ? asset('storage/' . $theme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png') }}"
                                onerror="this.src=`{{ asset('assets/img/thumbnail-tema/demo1.png') }}`"
                                alt="{{ $theme->name }}"
                                class="w-full h-full object-cover scale-[1.15] group-hover:scale-[1.20] transition-transform duration-500 origin-center relative z-0"
                                loading="lazy" decoding="async">

                            {{-- Tag Label --}}
                            <div
                                class="absolute top-0 left-0 bg-brand-dark text-white text-[11px] font-bold px-4 py-2 rounded-br-2xl shadow-sm z-10 hidden sm:block">
                                {{ $theme->name }}
                            </div>

                            {{-- Badges: Tier & Extra Price --}}
                            <div class="absolute top-2 left-2 flex flex-col gap-1 z-10 sm:hidden">
                                @if (($theme->tingkatan ?? 'standar') === 'premium')
                                    <span
                                        class="bg-purple-600 text-white text-[7px] font-bold px-2 py-0.5 rounded-full shadow-xs">PREMIUM</span>
                                @elseif(($theme->tingkatan ?? 'standar') === 'eksklusif')
                                    <span
                                        class="bg-amber-600 text-white text-[7px] font-bold px-2 py-0.5 rounded-full shadow-xs">VIP</span>
                                @endif
                            </div>

                            {{-- Ribbon (Terpopuler / NEW) --}}
                            @if (isset($theme->invitations_count) &&
                                    $theme->invitations_count > 0 &&
                                    $theme->invitations_count == $themes->max('invitations_count'))
                                <div
                                    class="absolute top-2 -right-10 sm:top-5 bg-brand-accent text-white text-[7px] sm:text-[9px] font-bold py-0.5 sm:py-1 w-32 sm:w-36 text-center transform rotate-45 shadow-md z-10 uppercase tracking-widest">
                                    TERPOPULER
                                </div>
                            @elseif($theme->created_at && $theme->created_at->isCurrentMonth())
                                <div
                                    class="absolute top-2 -right-8 sm:top-5 bg-[#E63946] text-white text-[7px] sm:text-[9px] font-bold py-0.5 sm:py-1 w-28 sm:w-32 text-center transform rotate-45 shadow-md z-10 uppercase tracking-widest">
                                    NEW
                                </div>
                            @endif
                        </div>
                        <div
                            class="p-2 sm:p-5 text-center flex flex-col items-center border-t border-brand-dark/5 mt-auto bg-white relative z-10">
                            <h3
                                class="font-bold text-brand-dark text-[10px] sm:text-[15px] mb-1 sm:mb-2 truncate w-full">
                                {{ $theme->name }}</h3>

                            {{-- Price Indicator --}}
                            <div class="mb-2 sm:mb-3">
                                @if (($theme->harga_tambahan ?? 0) > 0)
                                    <span
                                        class="text-[9px] sm:text-xs font-semibold text-purple-700 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded-md">
                                        +Rp {{ number_format($theme->harga_tambahan, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span
                                        class="text-[9px] sm:text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md">
                                        Termasuk di Paket
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-1 sm:gap-2 w-full">
                                <a href="{{ route('theme.preview', $theme->code) }}" target="_blank"
                                    class="w-full py-1.5 sm:py-2.5 rounded-lg sm:rounded-xl border border-brand-dark/20 text-brand-dark text-[8px] sm:text-[12px] font-bold uppercase tracking-widest hover:border-brand-dark hover:bg-brand-dark hover:text-white transition-all duration-300 flex items-center justify-center">
                                    Preview
                                </a>
                                <a href="{{ route('landing.register-form', ['theme' => $theme->code]) }}"
                                    class="w-full py-1.5 sm:py-2.5 rounded-lg sm:rounded-xl bg-brand-dark text-white text-[8px] sm:text-[12px] font-bold uppercase tracking-widest hover:bg-brand-accent hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center justify-center">
                                    Pilih Tema
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- CTA Custom Tema --}}
            <div
                class="mt-16 bg-white border border-brand-dark/5 rounded-[2rem] p-8 md:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex flex-col md:flex-row items-center justify-between gap-8 lp-reveal lp-delay-2 relative overflow-hidden group">
                <div
                    class="absolute -right-20 -top-20 w-64 h-64 bg-brand-accent/10 rounded-full blur-[60px] pointer-events-none group-hover:bg-brand-accent/20 transition-colors duration-700">
                </div>
                <div
                    class="absolute -left-20 -bottom-20 w-48 h-48 bg-brand-dark/5 rounded-full blur-[50px] pointer-events-none">
                </div>

                <div class="text-center md:text-left z-10">
                    <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-3 block">Butuh
                        Bantuan?</span>
                    <h3 class="font-serif text-2xl md:text-3xl text-brand-dark mb-3">Mau Terima Beres?</h3>
                    <p class="text-[13px] md:text-[14px] text-brand-dark/70 max-w-xl leading-relaxed">
                        Tidak punya waktu luang untuk mengatur undangan sendiri? Tim Aufilla siap membantu membuatkan
                        undangan Anda sampai jadi. Konsultasikan tema pilihan Anda sekarang!
                    </p>
                </div>
                <a href="https://wa.me/6285171097138?text=Halo%20Admin%2C%20saya%20tertarik%20membuat%20undangan%20dengan%20tema..."
                    target="_blank"
                    class="shrink-0 flex items-center gap-3 bg-brand-dark hover:bg-brand-accent text-white px-8 py-4 rounded-full font-bold text-[13px] md:text-[14px] transition-all duration-500 shadow-xl shadow-brand-dark/20 hover:shadow-brand-accent/30 hover:-translate-y-1 z-10">
                    <svg class="w-5 h-5 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.337a9.957 9.957 0 004.779 1.216h.004c5.505 0 9.988-4.478 9.989-9.984 0-5.505-4.483-9.983-9.993-9.983zm0 18.232h-.003a8.271 8.271 0 01-4.218-1.144l-.302-.178-3.136.8.84-3.036-.197-.31a8.272 8.272 0 01-1.272-4.428c.001-4.57 3.731-8.293 8.31-8.294 4.568 0 8.294 3.722 8.295 8.293.001 4.57-3.727 8.294-8.317 8.294z" />
                        <path
                            d="M16.574 13.565c-.252-.126-1.492-.736-1.722-.82-.23-.085-.398-.126-.566.126-.168.252-.65 .82-.797.989-.147.168-.293.189-.546.063-2.18-.949-3.329-2.67-3.72-3.342-.147-.252-.016-.388.11-.513.113-.112.252-.294.378-.44.126-.148.168-.252.252-.421.084-.168.042-.315-.021-.44-.063-.126-.566-1.365-.776-1.87-.205-.494-.413-.427-.566-.435l-.482-.008c-.168 0-.441.063-.672.315-.23.252-.881.86-1.07 1.968-.04.237-.023.791.439 1.637.525 1.056 1.884 3.292 4.417 4.354 1.341.562 2.115.82 2.85 1.05.615.19 1.173.163 1.614.1.495-.072 1.492-.609 1.703-1.197.21-.588.21-1.092.147-1.197-.063-.105-.23-.168-.482-.294z" />
                    </svg>
                    Konsultasi via WA
                </a>
            </div>

        </div>
    </section>
    {{-- ═══════════════════════════════════════════════
         PRICING (Katalog Harga)
    ═══════════════════════════════════════════════ --}}
    <section id="harga" class="py-24 px-6 lg:px-10 bg-white relative overflow-hidden">
        {{-- Ornamen --}}
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-accent/[.02] rounded-full blur-[120px] pointer-events-none anim-pulse-soft z-0">
        </div>
        <svg class="absolute top-20 left-10 md:left-40 w-6 h-6 text-brand-accent/20 anim-float pointer-events-none z-0 hidden sm:block"
            viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z" />
        </svg>
        <svg class="absolute bottom-32 right-10 md:right-20 w-8 h-8 text-brand-dark/10 anim-float pointer-events-none z-0 hidden sm:block"
            style="animation-delay: -1s" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z" />
        </svg>

        <div class="max-w-7xl mx-auto relative z-10">

            <div class="text-center max-w-2xl mx-auto mb-12 lp-reveal lp-delay-0">
                <span
                    class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-3 block">Katalog</span>
                <h2 class="font-serif text-4xl text-brand-dark mb-4">Pilih Paket Undangan</h2>
                <p class="text-brand-dark/80 text-[15px] leading-relaxed">Silakan pilih paket terbaik sesuai dengan
                    kebutuhan momen spesial Anda.</p>
            </div>

            <!-- Trial Advert Banner -->
            <div
                class="mb-12 bg-gradient-to-r from-brand-dark via-brand-medium to-brand-dark text-white rounded-3xl p-6 sm:p-8 shadow-xl border border-brand-accent/30 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left z-10">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-accent/20 text-brand-accent text-xs font-bold uppercase tracking-widest">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                        <span>Masa Uji Coba Gratis</span>
                    </span>
                    <h3 class="text-xl sm:text-2xl font-bold font-serif text-white">Ingin Mencoba Dulu Tanpa Bayar?
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-300 max-w-xl">
                        Dapatkan akses gratis <strong>Paket Trial ({{ $trialPaket->active_days ?? 3 }} Hari)</strong>
                        untuk mengisi data dan melihat pratinjau langsung undangan Anda tanpa kartu kredit!
                    </p>
                </div>
                <a href="{{ route('landing.register-form') }}"
                    class="shrink-0 bg-brand-accent hover:bg-brand-accent-dark text-white font-bold px-6 py-3.5 rounded-2xl text-xs sm:text-sm shadow-md transition-all hover:scale-105 z-10 flex items-center gap-2">
                    <span>Coba Trial Gratis Now</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                @foreach ($packages as $pkg)
                    @php $isPremium = strtolower($pkg->name) === 'premium'; @endphp

                    <div
                        class="lp-reveal {{ $isPremium ? 'lp-delay-2' : ($loop->first ? 'lp-delay-1' : 'lp-delay-3') }} relative flex flex-col rounded-[2rem] overflow-hidden transition-all duration-500
                    {{ $isPremium
                        ? 'bg-brand-dark text-white shadow-2xl shadow-brand-dark/20 md:-translate-y-4 ring-2 ring-brand-accent/50 hover:shadow-brand-accent/20'
                        : 'bg-white border border-brand-dark/[.06] shadow-md hover:shadow-xl hover:-translate-y-2' }}">

                        @if ($isPremium)
                            <div
                                class="absolute top-0 inset-x-0 text-center py-2 bg-brand-accent text-white text-[10px] font-bold tracking-[.2em] uppercase">
                                Best Seller
                            </div>
                        @endif

                        <div class="p-10 flex flex-col flex-1 {{ $isPremium ? 'pt-12' : '' }}">
                            <h3
                                class="text-2xl font-serif {{ $isPremium ? 'text-brand-accent' : 'text-brand-dark' }} mb-2">
                                {{ $pkg->name }}</h3>
                            <div
                                class="mb-4 pb-6 border-b {{ $isPremium ? 'border-white/10' : 'border-brand-dark/10' }}">
                                <span
                                    class="text-[34px] font-bold {{ $isPremium ? 'text-white' : 'text-brand-dark' }}">Rp
                                    {{ number_format($pkg->price, 0, ',', '.') }}</span>
                            </div>
                            <p
                                class="text-[13px] leading-relaxed mb-8 min-h-[40px] {{ $isPremium ? 'text-white' : 'text-brand-dark/80' }}">
                                {{ $pkg->description }}</p>

                            <ul class="space-y-4 mb-10 flex-1">
                                <li
                                    class="flex items-center gap-3 text-[13px] {{ $isPremium ? 'text-white/90' : 'text-brand-dark/80' }}">
                                    <div
                                        class="w-5 h-5 rounded-full bg-brand-accent/20 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 {{ $isPremium ? 'text-brand-accent' : 'text-brand-accent' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    Masa Aktif <strong
                                        class="ml-1">{{ $pkg->active_days == 36500 ? 'Permanen' : $pkg->active_days . ' Hari' }}</strong>
                                </li>
                                <li
                                    class="flex items-center gap-3 text-[13px] {{ $isPremium ? 'text-white/90' : 'text-brand-dark/80' }}">
                                    <div
                                        class="w-5 h-5 rounded-full bg-brand-accent/20 flex items-center justify-center shrink-0">
                                        <svg class="w-3 h-3 text-brand-accent" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    Kuota Galeri <strong
                                        class="ml-1">{{ $pkg->max_gallery_photos == 999 ? 'Unlimited' : $pkg->max_gallery_photos . ' Foto' }}</strong>
                                </li>
                                <li
                                    class="flex items-center gap-3 text-[13px] {{ $pkg->has_love_story ? ($isPremium ? 'text-white/90' : 'text-brand-dark/80') : ($isPremium ? 'text-white/30' : 'text-brand-dark/30') }}">
                                    <div
                                        class="w-5 h-5 rounded-full {{ $pkg->has_love_story ? 'bg-brand-accent/20' : 'bg-transparent border border-current' }} flex items-center justify-center shrink-0">
                                        @if ($pkg->has_love_story)
                                            <svg class="w-3 h-3 text-brand-accent" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </div>
                                    Fitur Cerita Cinta
                                </li>
                                <li
                                    class="flex items-center gap-3 text-[13px] {{ $pkg->can_custom_music ? ($isPremium ? 'text-white/90' : 'text-brand-dark/80') : ($isPremium ? 'text-white/30' : 'text-brand-dark/30') }}">
                                    <div
                                        class="w-5 h-5 rounded-full {{ $pkg->can_custom_music ? 'bg-brand-accent/20' : 'bg-transparent border border-current' }} flex items-center justify-center shrink-0">
                                        @if ($pkg->can_custom_music)
                                            <svg class="w-3 h-3 text-brand-accent" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @endif
                                    </div>
                                    Bebas Ganti Musik
                                </li>
                            </ul>

                            <a href="{{ route('landing.register-form') }}"
                                class="w-full py-4 rounded-xl text-[13px] font-bold uppercase tracking-wider transition-all duration-300 text-center block
                            {{ $isPremium
                                ? 'bg-brand-accent text-white hover:bg-brand-accent-dark shadow-lg shadow-brand-accent/30 hover:-translate-y-1'
                                : 'bg-brand-bg border border-brand-dark/10 text-brand-dark hover:bg-brand-dark hover:text-white hover:border-brand-dark hover:-translate-y-1' }}">
                                Pilih Paket
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         PROMOSI CETAK UNDANGAN FISIK
    ═══════════════════════════════════════════════ --}}
    <section id="cetak-fisik"
        class="py-20 px-6 lg:px-10 bg-gradient-to-b from-brand-bg to-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div
                class="bg-white border border-brand-accent/20 rounded-[2.5rem] p-8 sm:p-12 shadow-xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-10">
                <!-- Left Content -->
                <div class="space-y-5 max-w-2xl text-center lg:text-left z-10">
                    <span
                        class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-brand-accent/15 text-brand-accent-dark text-xs font-bold uppercase tracking-widest">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                            </path>
                        </svg>
                        <span>Layanan Cetak Fisik Minimalis</span>
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold font-serif text-brand-dark leading-tight">
                        Cetak Undangan Fisik Murah & Minimalis (Bisa Pakai Foto)
                    </h2>
                    <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                        Selain undangan digital interaktif, Aufilla juga melayani pencetakan <strong>Undangan Fisik
                            Murah, Minimalis & Hemat</strong> menggunakan pilihan kertas <strong>Jasmine, Brief Card
                            (BC), Linen, dan Art Paper</strong> berkualitas. Beragam variasi model tersedia mulai dari
                        tipe ekonomis hingga cetak full foto yang diselaraskan dengan tema digital Anda!
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2 text-left">
                        <div
                            class="bg-brand-bg p-3.5 rounded-xl border border-brand-accent/15 flex items-center gap-2 text-xs font-semibold text-brand-dark">
                            <svg class="w-4 h-4 text-brand-accent shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <span>Kertas Jasmine, BC & Linen</span>
                        </div>
                        <div
                            class="bg-brand-bg p-3.5 rounded-xl border border-brand-accent/15 flex items-center gap-2 text-xs font-semibold text-brand-dark">
                            <svg class="w-4 h-4 text-brand-accent shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                </path>
                            </svg>
                            <span>Desain Minimalis & Full Foto</span>
                        </div>
                        <div
                            class="bg-brand-bg p-3.5 rounded-xl border border-brand-accent/15 flex items-center gap-2 text-xs font-semibold text-brand-dark">
                            <svg class="w-4 h-4 text-brand-accent shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            <span>Paket Murah & Hemat</span>
                        </div>
                    </div>

                    <div class="pt-4">
                        <a href="https://wa.me/6285171097138?text=Halo%20Admin%20Aufilla%2C%20saya%20tertarik%20untuk%20konsultasi%20cetak%20undangan%20fisik%20pendamping%20digital..."
                            target="_blank"
                            class="inline-flex items-center gap-3 bg-[#25D366] hover:bg-[#1EBE5D] text-white font-bold px-8 py-4 rounded-2xl text-sm shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            <span>Konsultasi Cetak Fisik via WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FAQ SECTION
    ═══════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 md:py-20 px-6 lg:px-10 bg-brand-bg relative overflow-hidden">
        {{-- Ornamen --}}
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-brand-dark/[.04] rounded-full blur-[80px] pointer-events-none anim-pulse-soft z-0">
        </div>
        <svg class="absolute top-1/3 left-10 md:left-32 w-5 h-5 text-brand-accent/20 anim-float pointer-events-none z-0 hidden sm:block"
            style="animation-delay: -3s" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z" />
        </svg>

        <div class="max-w-3xl mx-auto lp-reveal lp-delay-0 relative z-10">
            <div class="text-center mb-10">
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-2 block">FAQ</span>
                <h2 class="font-serif text-3xl md:text-4xl text-brand-dark mb-3">Pertanyaan Seputar Aufilla</h2>
                <p class="text-brand-dark/80 text-[13px] md:text-[14px] leading-relaxed">Hal-hal yang sering ditanyakan
                    oleh calon pengantin mengenai platform undangan kami.</p>
            </div>

            <div class="space-y-3">
                @php
                    $faqs = [
                        [
                            'q' => 'Bagaimana alur pembuatan undangan digital di Aufilla Invitation?',
                            'a' =>
                                'Pembuatan undangan di Aufilla dirancang secara mandiri dan sepenuhnya otomatis (instant). Anda dapat memulainya dengan mengeksplorasi katalog tema eksklusif yang kami sediakan, lalu mengklik tombol "Pilih Tema". Anda akan diarahkan untuk mendaftarkan akun sekaligus mendapatkan <strong>Masa Uji Coba (Trial)</strong> gratis selama 1 hari. Setelah akun berhasil dibuat, Anda akan langsung diarahkan ke Dasbor Klien yang intuitif. Di sana, Anda bisa melengkapi profil mempelai, mengatur detail waktu dan lokasi acara (Akad & Resepsi), hingga mengunggah foto pre-wedding Anda ke galeri. Segera setelah data inti terisi, URL atau <em>link</em> undangan Anda sudah aktif dan siap disebarkan ke kerabat Anda tanpa perlu menunggu proses manual dari tim kami!',
                        ],
                        [
                            'q' => 'Berapa lama masa aktif undangan yang sudah dibuat?',
                            'a' =>
                                'Masa aktif undangan akan sangat bergantung pada jenis paket yang Anda pilih setelah masa uji coba 1 hari Anda berakhir. Untuk paket <strong>Basic</strong>, undangan Anda akan tetap aktif dan bisa diakses publik selama <strong>90 Hari (3 Bulan)</strong>. Jika Anda memilih paket <strong>Premium</strong>, masa aktifnya diperpanjang menjadi <strong>180 Hari (6 Bulan)</strong>. Namun, jika Anda menginginkan kenangan pernikahan Anda abadi dan bisa diakses kapan saja untuk dikenang di masa depan, kami sangat menyarankan paket <strong>VIP</strong>. Paket VIP memberikan jaminan masa aktif <strong>Permanen (Lifetime)</strong> tanpa perlu memikirkan biaya perpanjangan server atau langganan bulanan selamanya. Jika masa aktif paket (Basic/Premium) habis, tautan publik akan ditutup otomatis namun data Anda tidak dihapus.',
                        ],
                        [
                            'q' => 'Apakah ada batasan jumlah foto galeri dan nama tamu yang bisa dimasukkan?',
                            'a' =>
                                'Kami memberikan kebebasan penuh pada fitur input <strong>Custom Nama Tamu</strong>. Tidak peduli paket berbayar apa yang Anda gunakan, Anda berhak menyebarkan tautan spesifik untuk tamu <strong>tanpa batasan jumlah (Unlimited)</strong>. Namun, untuk <strong>Foto Galeri</strong>, kami menerapkan kuota: paket <strong>Basic</strong> membatasi maksimal <strong>5 Foto</strong>, paket <strong>Premium</strong> hingga <strong>10 Foto</strong>, dan khusus paket <strong>VIP</strong>, Anda bebas mengunggah foto <strong>Unlimited</strong>. Harap diperhatikan, selama Anda masih berstatus <strong>Trial</strong>, sistem membatasi ketat maksimal 3 foto galeri dan 5 nama tamu untuk mencegah penyalahgunaan sebelum akun diaktivasi ke versi berbayar.',
                        ],
                        [
                            'q' => 'Apakah saya bisa mengganti tema undangan atau mengubah musiknya?',
                            'a' =>
                                'Tentu saja! Aufilla Invitation mendukung perubahan desain secara dinamis. Anda bisa masuk ke menu "Ganti Tema" di Dasbor Klien dan secara instan desain undangan publik Anda akan berganti dengan mulus tanpa merusak data mempelai maupun foto Anda. Untuk kustomisasi lanjutan seperti mengaktifkan halaman <strong>Cerita Cinta (Love Story)</strong> dan mengunggah <strong>Musik (Lagu Custom) MP3</strong> sendiri, fitur tersebut secara eksklusif hanya terbuka <em>(unlocked)</em> bagi pengguna paket <strong>Premium</strong> atau <strong>VIP</strong>. Pada paket Basic atau Trial, Anda akan menggunakan instrumen musik elegan yang sudah tertanam secara *default* dari tema kami.',
                        ],
                        [
                            'q' => 'Jika saya mengalami kesulitan teknis, apakah ada bantuan?',
                            'a' =>
                                'Kepuasan dan kelancaran momen pernikahan Anda adalah prioritas mutlak kami. Kami telah merancang sistem yang semudah mungkin (layaknya mengisi profil di media sosial), namun kami juga memahami bahwa Anda mungkin membutuhkan arahan teknis. Oleh karena itu, tim <em>Customer Support</em> profesional kami selalu bersiaga dan dapat dengan mudah dihubungi melalui tombol <strong>Bantuan WhatsApp</strong> di dalam Dasbor Anda. Khusus bagi para pengguna paket <strong>VIP</strong>, Anda akan otomatis mendapatkan fasilitas <strong>Dukungan Prioritas (Priority Support)</strong>, di mana setiap keluhan atau permintaan teknis Anda akan diloncatkan ke antrean terdepan untuk ditangani sesegera mungkin.',
                        ],
                    ];
                @endphp

                @foreach ($faqs as $faq)
                    <div x-data="{ open: false }"
                        class="group bg-white rounded-xl border border-brand-dark/5 shadow-sm overflow-hidden transition-all duration-300">
                        <button @click="open = !open" type="button"
                            class="w-full flex justify-between items-center font-bold text-[13px] cursor-pointer text-brand-dark px-5 py-4 hover:text-brand-accent transition-colors select-none text-left focus:outline-none">
                            <span>{{ $faq['q'] }}</span>
                            <span
                                class="transition-transform duration-500 text-brand-dark/40 group-hover:text-brand-accent ml-4 shrink-0"
                                :class="open ? 'rotate-180' : ''">
                                <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="18">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </span>
                        </button>

                        {{-- Smooth Grid Transition Trick --}}
                        <div class="grid transition-all duration-500 ease-in-out"
                            :class="open ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                            <div class="overflow-hidden">
                                <div class="px-5 pb-5 text-[12px] md:text-[13px] leading-relaxed text-brand-dark/80 border-t border-brand-dark/5 pt-3 mt-1 transform transition-transform duration-500"
                                    :class="open ? 'translate-y-0' : '-translate-y-2'">
                                    {!! $faq['a'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════ --}}
    <footer class="bg-white border-t border-brand-dark/5 pt-20 pb-10 px-6 lg:px-10">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-12 gap-y-10 gap-x-4 md:gap-8 mb-16 lp-reveal lp-delay-1">

                {{-- Left: Logo & Text (Col-span 5) --}}
                <div
                    class="col-span-2 md:col-span-5 text-center flex flex-col items-center md:items-start justify-center md:justify-start">
                    <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla"
                        class="w-16 h-16 object-contain mb-3">
                    <p class="text-[13px] leading-relaxed text-brand-dark/80 max-w-sm md:text-left">
                        <strong class="font-bold text-brand-dark">Aufilla Invitation</strong> adalah platform undangan
                        digital berdesain premium yang sangat praktis digunakan. Cukup isi data diri & unggah foto,
                        undangan Anda langsung siap disebarkan tanpa ribet mengatur komponen desain!
                    </p>
                </div>

                {{-- Middle: Contact (Col-span 4) --}}
                <div class="col-span-1 md:col-span-4 flex flex-col items-start">
                    <h4 class="text-[14px] md:text-[15px] font-bold text-brand-dark mb-4 md:mb-6 pl-1 md:pl-0">Kontak
                        Kami</h4>
                    <ul class="space-y-4 text-[11px] md:text-[13px] text-brand-dark/80 w-full">
                        <li class="flex items-center gap-2 md:gap-4">
                            <div
                                class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <span class="break-all md:break-normal">638517097138</span>
                        </li>
                        <li class="flex items-center gap-2 md:gap-4">
                            <div
                                class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-3 h-3 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </div>
                            <span class="break-words">Aufilla Studio</span>
                        </li>
                        <li class="flex items-center gap-2 md:gap-4">
                            <div
                                class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-3 h-3 md:w-4 md:h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </div>
                            <span class="break-words">aufilla.studio</span>
                        </li>
                        <li class="flex items-center gap-2 md:gap-4">
                            <div
                                class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="break-all md:break-normal">aufilla.web@gmail.com</span>
                        </li>
                    </ul>
                </div>

                {{-- Right: Explore (Col-span 3) --}}
                <div class="col-span-1 md:col-span-3 flex flex-col items-start md:pl-4">
                    <h4 class="text-[14px] md:text-[15px] font-bold text-brand-dark mb-4 md:mb-6">Explore</h4>
                    <ul class="space-y-4 text-[11px] md:text-[13px] text-brand-dark/80 text-left w-full">
                        <li><a href="#" class="hover:text-brand-accent transition-colors block w-full">Home</a>
                        </li>
                        <li><a href="#fitur" class="hover:text-brand-accent transition-colors block w-full">Fitur</a>
                        </li>
                        <li><a href="#tema" class="hover:text-brand-accent transition-colors block w-full">Tema</a>
                        </li>
                        <li><a href="#harga" class="hover:text-brand-accent transition-colors block w-full">Harga</a>
                        </li>
                        <li><a href="#faq" class="hover:text-brand-accent transition-colors block w-full">F A Q</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div
                class="border-t border-brand-dark/5 pt-8 text-center text-[11px] md:text-[12px] text-brand-dark/60 lp-reveal lp-delay-2">
                Copyright &copy; {{ date('Y') }} <strong class="text-brand-dark font-medium">Aufilla
                    Invitation</strong>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════════ --}}
    <script>
        // Advanced Scroll Reveal (Vanilla JS)
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    }
                });
            }, {
                root: null,
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            });

            document.querySelectorAll('.lp-reveal').forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>
