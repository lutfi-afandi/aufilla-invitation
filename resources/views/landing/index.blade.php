<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Aufilla Invitation') }} — Undangan Pernikahan Digital</title>
    <meta name="description" content="Platform undangan pernikahan digital premium, elegan, dan mudah digunakan.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ── Scoped: Landing page only ── */
        .lp-reveal { opacity: 0; transform: translateY(40px) scale(0.98); transition: all 1s cubic-bezier(0.16, 1, 0.3, 1); }
        .lp-reveal.is-visible { opacity: 1; transform: translateY(0) scale(1); }
        .lp-delay-0 { transition-delay: 0s; }
        .lp-delay-1 { transition-delay: .1s; }
        .lp-delay-2 { transition-delay: .2s; }
        .lp-delay-3 { transition-delay: .3s; }
        .lp-delay-4 { transition-delay: .4s; }
        .lp-delay-5 { transition-delay: .5s; }
        .lp-delay-6 { transition-delay: .6s; }

        /* Smooth pulsing background */
        @keyframes pulse-soft {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        .anim-pulse-soft { animation: pulse-soft 8s infinite alternate ease-in-out; }

        /* Floating ornaments */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }
        .anim-float { animation: float 6s ease-in-out infinite; }

        /* FAQ Soft Reveal */
        details[open] .faq-content { animation: faqSlideDown 0.3s ease-out forwards; }
        @keyframes faqSlideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hide Scrollbar */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
         NAVBAR
    ═══════════════════════════════════════════════ --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/85 backdrop-blur-xl border-b border-brand-accent/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 h-[75px] flex items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 hover:-translate-y-0.5 transition-transform duration-300">
                <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla Logo" class="h-10 md:h-12 w-auto object-contain">
                <div class="flex flex-col justify-center">
                    <span class="text-[20px] md:text-[24px] font-serif text-brand-dark tracking-tight leading-none">
                        Aufilla<span class="italic text-brand-accent">Invitation</span>
                    </span>
                    <span class="text-[8px] md:text-[9px] font-sans font-bold tracking-[0.3em] uppercase text-brand-dark/60 mt-1 pl-0.5">
                        Undangan Digital
                    </span>
                </div>
            </a>

            {{-- Nav Links --}}
            <div class="hidden md:flex items-center gap-10 text-[13px] font-bold tracking-wide text-brand-dark/90 uppercase">
                <a href="#" class="hover:text-brand-accent transition-colors duration-200">Home</a>
                <a href="#fitur" class="hover:text-brand-accent transition-colors duration-200">Fitur</a>
                <a href="#tema" class="hover:text-brand-accent transition-colors duration-200">Katalog Tema</a>
                <a href="#harga" class="hover:text-brand-accent transition-colors duration-200">Harga</a>
            </div>

            {{-- CTA --}}
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-2.5 rounded-full bg-brand-dark text-white text-[13px] font-semibold hover:bg-brand-accent transition-colors duration-300 shadow-lg shadow-brand-dark/20 hover:-translate-y-0.5 transform">
                        Dashboard
                    </a>
                @else
                    <button onclick="openRegisterModal()"
                            class="px-6 py-2.5 rounded-full bg-brand-dark text-white text-[13px] font-semibold hover:bg-brand-accent transition-all duration-300 shadow-lg shadow-brand-dark/20 hover:shadow-brand-accent/30 hover:-translate-y-0.5 transform">
                        Buat Undangan
                    </button>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ═══════════════════════════════════════════════
         HERO SECTION
    ═══════════════════════════════════════════════ --}}
    <section class="relative pt-[140px] pb-20 md:pt-[180px] md:pb-28 overflow-hidden min-h-screen flex items-center bg-brand-bg">
        {{-- Gambar Latar Belakang (Free Commercial) dengan Overlay Dual Tone --}}
        <div class="absolute inset-0 z-0 pointer-events-none">
            {{-- Base Image --}}
            <img src="https://images.unsplash.com/photo-1519225421980-715cb0215aed?q=80&w=2070&auto=format&fit=crop" alt="Wedding Aesthetic Background" class="w-full h-full object-cover grayscale opacity-40 mix-blend-multiply">
            
            {{-- Dual Tone Gradient Overlay (Warm Gold to Soft Sage Green) --}}
            <div class="absolute inset-0 bg-gradient-to-tr from-[#EAD9B8]/80 via-brand-bg/90 to-[#DCE6DF]/90 backdrop-blur-[2px]"></div>
            
            {{-- Accent Glow --}}
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-brand-accent/5 to-transparent mix-blend-overlay"></div>
        </div>

        {{-- Dekorasi Shape (tetap dipertahankan untuk efek modern) --}}
        <div class="absolute -right-20 top-0 w-[800px] h-[800px] rounded-full bg-brand-accent/[.09] blur-[100px] pointer-events-none anim-pulse-soft z-0"></div>
        <div class="absolute -left-40 bottom-0 w-[600px] h-[600px] rounded-full bg-brand-dark/[.05] blur-[120px] pointer-events-none anim-pulse-soft z-0" style="animation-delay: -4s;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-10 grid md:grid-cols-2 gap-16 lg:gap-24 items-center relative z-10">

            {{-- ─── Kiri: Copywriting ─── --}}
            <div class="max-w-xl">
                <div class="lp-reveal lp-delay-0 inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white shadow-sm border border-brand-accent/10 mb-6 backdrop-blur-sm">
                    <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span>
                    <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-dark">Undangan Digital</span>
                </div>

                <h1 class="lp-reveal lp-delay-1 font-serif text-[3rem] md:text-[3.8rem] lg:text-[4.2rem] leading-[1.05] tracking-tight text-brand-dark mb-6">
                    Undangan <br>
                    <span class="italic text-brand-accent">Pernikahan</span> Digital
                </h1>

                <p class="lp-reveal lp-delay-2 text-[16px] leading-relaxed text-brand-dark/90 mb-10 font-medium max-w-lg">
                    Undangan orang terdekatmu dengan mudah, praktis dan tanpa ada batasan menggunakan Undangan Digital kekinian dari <strong class="text-brand-dark">Aufilla Invitation</strong>.
                </p>

                <div class="lp-reveal lp-delay-3 flex flex-wrap items-center gap-5">
                    <button onclick="openRegisterModal()"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-brand-dark text-white text-[13px] font-bold uppercase tracking-wider shadow-xl shadow-brand-dark/20 hover:bg-brand-accent hover:shadow-brand-accent/30 hover:-translate-y-1 transition-all duration-300">
                        Buat Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                    <a href="#tema"
                       class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-full bg-transparent border-2 border-brand-dark/20 text-brand-dark text-[13px] font-bold uppercase tracking-wider hover:border-brand-dark hover:bg-brand-dark/5 transition-all duration-300">
                        Lihat Tema
                    </a>
                </div>
            </div>

            {{-- ─── Kanan: Visual ─── --}}
            <div class="hidden md:flex justify-center relative lp-reveal lp-delay-3">
                <div class="relative w-[280px] rounded-[3rem] bg-brand-bg p-3 shadow-2xl shadow-brand-dark/15 border border-brand-accent/20 z-10 transform rotate-[-2deg] hover:rotate-0 transition-transform duration-700">
                    <div class="w-full aspect-[9/19] bg-white rounded-[2.5rem] overflow-hidden relative flex flex-col items-center justify-center text-center px-6 border border-brand-dark/5 bg-[url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23c5a880\' fill-opacity=\'0.05\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Cg%3E%3C/svg%3E')]">
                        
                        <svg class="w-16 h-16 text-brand-accent mb-6 opacity-80" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 22C12 22 4 16 4 10C4 6 7 4 10 4C11.5 4 12 5 12 5C12 5 12.5 4 14 4C17 4 20 6 20 10C20 16 12 22 12 22Z" fill-opacity="0.1"/>
                            <path d="M12 20.5C12 20.5 5 15.5 5 10C5 6.5 7.5 4.5 10 4.5C11.5 4.5 12 5.5 12 5.5C12 5.5 12.5 4.5 14 4.5C16.5 4.5 19 6.5 19 10C19 15.5 12 20.5 12 20.5Z" stroke="currentColor" stroke-width="1" fill="none"/>
                        </svg>

                        <p class="text-[9px] tracking-[.3em] uppercase text-brand-dark/70 mt-4 mb-2 font-bold">The Wedding</p>
                        <h2 class="font-serif italic text-[32px] leading-none text-brand-dark">Romeo</h2>
                        <span class="font-serif text-brand-accent text-xl my-2">&amp;</span>
                        <h2 class="font-serif italic text-[32px] leading-none text-brand-dark">Juliet</h2>
                        
                        <div class="mt-8 mb-4 w-12 h-[1px] bg-brand-accent/50"></div>
                        <button class="px-6 py-2.5 bg-brand-dark text-white text-[10px] font-bold tracking-widest uppercase rounded-full shadow-lg hover:bg-brand-accent transition-colors">Buka Undangan</button>
                    </div>
                </div>

                {{-- Floating badges --}}
                <div class="absolute top-10 -right-10 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl shadow-brand-dark/10 p-4 flex items-center gap-3 z-20 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-10 h-10 rounded-full bg-brand-accent/10 flex items-center justify-center text-brand-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-brand-dark">Unlimited</p>
                        <p class="text-[10px] text-brand-dark/70">Custom Nama Tamu</p>
                    </div>
                </div>
                <div class="absolute bottom-20 -left-12 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl shadow-brand-dark/10 p-4 flex items-center gap-3 z-20 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                    <div class="w-10 h-10 rounded-full bg-brand-dark/5 flex items-center justify-center text-brand-dark">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
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
        <div class="absolute top-0 -left-20 w-96 h-96 bg-brand-accent/[.04] rounded-full blur-[100px] pointer-events-none anim-pulse-soft z-0"></div>
        <svg class="absolute top-32 right-10 md:right-32 w-6 h-6 md:w-8 md:h-8 text-brand-accent/20 anim-float pointer-events-none z-0 hidden sm:block" style="animation-delay: -2s" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z"/></svg>

        <div class="max-w-5xl mx-auto relative z-10">
            
            <div class="text-center max-w-2xl mx-auto mb-16 lp-reveal lp-delay-0">
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-3 block">Fitur Terbaik</span>
                <h2 class="font-serif text-4xl text-brand-dark mb-4">Lengkap & Eksklusif</h2>
                <p class="text-brand-dark/80 text-[15px] leading-relaxed">Dilengkapi berbagai fitur yang dapat mempercantik dan melengkapi informasi di undangan website kamu.</p>
            </div>

            @php
                $features = [
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>', 'title' => 'Unlimited Share'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>', 'title' => 'Custom Nama Tamu'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => 'Buku Tamu & RSVP'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>', 'title' => 'Gallery Foto & Video'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'title' => 'Countdown Acara'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'title' => 'Amplop Digital'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>', 'title' => 'Ucapan dan Doa'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>', 'title' => 'Cerita Cinta'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>', 'title' => 'Navigasi Lokasi'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>', 'title' => 'Backsound Musik'],
                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>', 'title' => 'Free Revisi'],
                ];
            @endphp

            <div class="flex flex-wrap justify-center gap-3 md:gap-4 max-w-5xl mx-auto">
                @foreach($features as $index => $feature)
                    <div class="lp-reveal lp-delay-{{ $index % 6 }} group bg-brand-dark hover:bg-brand-accent transition-all duration-300 rounded-xl p-5 md:p-6 flex flex-col items-center justify-center text-center min-h-[120px] shadow-sm hover:shadow-md cursor-default hover:-translate-y-1 flex-auto basis-[160px] md:basis-[220px] max-w-[280px]">
                        <svg class="w-8 h-8 md:w-9 md:h-9 mb-3 text-white group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">{!! $feature['icon'] !!}</svg>
                        <h3 class="font-medium text-[12px] md:text-[13px] text-white leading-snug">{{ $feature['title'] }}</h3>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         THEMES (Katalog Tema)
    ═══════════════════════════════════════════════ --}}
    <section id="tema" class="py-24 px-6 lg:px-10 bg-brand-bg relative overflow-hidden">
        {{-- Ornamen --}}
        <div class="absolute bottom-0 -right-20 w-96 h-96 bg-brand-dark/[.03] rounded-full blur-[100px] pointer-events-none anim-pulse-soft z-0" style="animation-delay: -3s"></div>
        <svg class="absolute bottom-40 left-10 md:left-20 w-5 h-5 text-brand-accent/30 anim-float pointer-events-none z-0 hidden sm:block" style="animation-delay: -4s" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z"/></svg>

        <div class="max-w-7xl mx-auto relative z-10">
            
            <div class="text-center max-w-2xl mx-auto mb-14 lp-reveal lp-delay-0">
                <span class="font-serif font-bold text-[36px] md:text-[42px] text-brand-dark block leading-none mb-2">Katalog</span>
                <h2 class="font-sans font-bold tracking-[0.2em] uppercase text-[11px] md:text-[12px] text-brand-accent mb-4">Undangan Digital</h2>
                <p class="text-brand-dark/70 text-[13px] md:text-[14px] leading-relaxed max-w-md mx-auto">
                    Pilih tema desain eksklusif yang paling cocok untuk mencerminkan keindahan hari spesial Anda.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lp-reveal lp-delay-1">
                @foreach($themes as $theme)
                <div class="bg-white rounded-2xl shadow-sm border border-brand-dark/5 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col">
                    <div class="relative bg-brand-bg/30 pt-8 px-5 aspect-[3/4] flex items-end justify-center overflow-hidden">
                        {{-- Theme Thumbnail --}}
                        <img src="{{ $theme->thumbnail ? asset('storage/' . $theme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png') }}" onerror="this.src=`{{ asset('assets/img/thumbnail-tema/demo1.png') }}`" alt="{{ $theme->name }}" class="w-full h-auto object-contain group-hover:scale-[1.03] transition-transform duration-500 origin-bottom relative z-0">
                        
                        {{-- Tag Label --}}
                        <div class="absolute top-0 left-0 bg-brand-dark text-white text-[11px] font-bold px-4 py-2 rounded-br-2xl shadow-sm z-10">
                            {{ $theme->name }}
                        </div>
                        
                        {{-- Ribbon (Terpopuler / NEW) --}}
                        @if(isset($theme->invitations_count) && $theme->invitations_count > 0 && $theme->invitations_count == $themes->max('invitations_count'))
                            <div class="absolute top-5 -right-10 bg-brand-accent text-white text-[8px] md:text-[9px] font-bold py-1 w-36 text-center transform rotate-45 shadow-md z-10 uppercase tracking-widest">
                                TERPOPULER
                            </div>
                        @elseif($theme->created_at && $theme->created_at->isCurrentMonth())
                            <div class="absolute top-5 -right-8 bg-[#E63946] text-white text-[9px] font-bold py-1 w-32 text-center transform rotate-45 shadow-md z-10 uppercase tracking-widest">
                                NEW
                            </div>
                        @endif
                    </div>
                    <div class="p-5 text-center flex flex-col items-center border-t border-brand-dark/5 mt-auto bg-white relative z-10">
                        <h3 class="font-bold text-brand-dark text-[15px] mb-4">{{ $theme->name }}</h3>
                        <div class="grid grid-cols-2 gap-2 w-full">
                            <a href="{{ route('theme.preview', $theme->code) }}" target="_blank" class="w-full py-2.5 rounded-xl border border-brand-dark/20 text-brand-dark text-[11px] md:text-[12px] font-bold uppercase tracking-widest hover:border-brand-dark hover:bg-brand-dark hover:text-white hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center">
                                Preview
                            </a>
                            <button onclick="openRegisterModal({{ $theme->id }}, `{{ addslashes($theme->name) }}`, `{{ $theme->thumbnail ? asset('storage/' . $theme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png') }}`)" type="button" class="w-full py-2.5 rounded-xl bg-brand-dark text-white text-[11px] md:text-[12px] font-bold uppercase tracking-widest hover:bg-brand-accent hover:-translate-y-0.5 hover:shadow-lg hover:shadow-brand-accent/30 transition-all duration-300 flex items-center justify-center">
                                Coba
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- ═══════════════════════════════════════════════
         PRICING (Katalog Harga)
    ═══════════════════════════════════════════════ --}}
    <section id="harga" class="py-24 px-6 lg:px-10 bg-white relative overflow-hidden">
        {{-- Ornamen --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-brand-accent/[.02] rounded-full blur-[120px] pointer-events-none anim-pulse-soft z-0"></div>
        <svg class="absolute top-20 left-10 md:left-40 w-6 h-6 text-brand-accent/20 anim-float pointer-events-none z-0 hidden sm:block" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z"/></svg>
        <svg class="absolute bottom-32 right-10 md:right-20 w-8 h-8 text-brand-dark/10 anim-float pointer-events-none z-0 hidden sm:block" style="animation-delay: -1s" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z"/></svg>

        <div class="max-w-7xl mx-auto relative z-10">
            
            <div class="text-center max-w-2xl mx-auto mb-16 lp-reveal lp-delay-0">
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-3 block">Katalog</span>
                <h2 class="font-serif text-4xl text-brand-dark mb-4">Pilih Paket Undangan</h2>
                <p class="text-brand-dark/80 text-[15px] leading-relaxed">Silakan pilih paket terbaik sesuai dengan kebutuhan momen spesial Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto items-stretch">
                @foreach($packages as $pkg)
                @php $isPremium = strtolower($pkg->name) === 'premium'; @endphp

                <div class="lp-reveal {{ $isPremium ? 'lp-delay-2' : ($loop->first ? 'lp-delay-1' : 'lp-delay-3') }} relative flex flex-col rounded-[2rem] overflow-hidden transition-all duration-500
                    {{ $isPremium
                        ? 'bg-brand-dark text-white shadow-2xl shadow-brand-dark/20 md:-translate-y-4 ring-2 ring-brand-accent/50 hover:shadow-brand-accent/20'
                        : 'bg-white border border-brand-dark/[.06] shadow-md hover:shadow-xl hover:-translate-y-2' }}">

                    @if($isPremium)
                        <div class="absolute top-0 inset-x-0 text-center py-2 bg-brand-accent text-white text-[10px] font-bold tracking-[.2em] uppercase">
                            Best Seller
                        </div>
                    @endif

                    <div class="p-10 flex flex-col flex-1 {{ $isPremium ? 'pt-12' : '' }}">
                        <h3 class="text-2xl font-serif {{ $isPremium ? 'text-brand-accent' : 'text-brand-dark' }} mb-2">{{ $pkg->name }}</h3>
                        <div class="mb-4 pb-6 border-b {{ $isPremium ? 'border-white/10' : 'border-brand-dark/10' }}">
                            <span class="text-[34px] font-bold {{ $isPremium ? 'text-white' : 'text-brand-dark' }}">Rp {{ number_format($pkg->price, 0, ',', '.') }}</span>
                        </div>
                        <p class="text-[13px] leading-relaxed mb-8 min-h-[40px] {{ $isPremium ? 'text-white' : 'text-brand-dark/80' }}">{{ $pkg->description }}</p>

                        <ul class="space-y-4 mb-10 flex-1">
                            <li class="flex items-center gap-3 text-[13px] {{ $isPremium ? 'text-white/90' : 'text-brand-dark/80' }}">
                                <div class="w-5 h-5 rounded-full bg-brand-accent/20 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 {{ $isPremium ? 'text-brand-accent' : 'text-brand-accent' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Masa Aktif <strong class="ml-1">{{ $pkg->active_days == 36500 ? 'Permanen' : $pkg->active_days . ' Hari' }}</strong>
                            </li>
                            <li class="flex items-center gap-3 text-[13px] {{ $isPremium ? 'text-white/90' : 'text-brand-dark/80' }}">
                                <div class="w-5 h-5 rounded-full bg-brand-accent/20 flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                Kuota Galeri <strong class="ml-1">{{ $pkg->max_gallery_photos == 999 ? 'Unlimited' : $pkg->max_gallery_photos . ' Foto' }}</strong>
                            </li>
                            <li class="flex items-center gap-3 text-[13px] {{ $pkg->has_love_story ? ($isPremium ? 'text-white/90' : 'text-brand-dark/80') : ($isPremium ? 'text-white/30' : 'text-brand-dark/30') }}">
                                <div class="w-5 h-5 rounded-full {{ $pkg->has_love_story ? 'bg-brand-accent/20' : 'bg-transparent border border-current' }} flex items-center justify-center shrink-0">
                                    @if($pkg->has_love_story)
                                        <svg class="w-3 h-3 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                </div>
                                Fitur Cerita Cinta
                            </li>
                            <li class="flex items-center gap-3 text-[13px] {{ $pkg->can_custom_music ? ($isPremium ? 'text-white/90' : 'text-brand-dark/80') : ($isPremium ? 'text-white/30' : 'text-brand-dark/30') }}">
                                <div class="w-5 h-5 rounded-full {{ $pkg->can_custom_music ? 'bg-brand-accent/20' : 'bg-transparent border border-current' }} flex items-center justify-center shrink-0">
                                    @if($pkg->can_custom_music)
                                        <svg class="w-3 h-3 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    @endif
                                </div>
                                Bebas Ganti Musik
                            </li>
                        </ul>

                        <button onclick="openRegisterModal()"
                            class="w-full py-4 rounded-xl text-[13px] font-bold uppercase tracking-wider transition-all duration-300
                            {{ $isPremium
                                ? 'bg-brand-accent text-white hover:bg-brand-accent-dark shadow-lg shadow-brand-accent/30 hover:-translate-y-1'
                                : 'bg-brand-bg border border-brand-dark/10 text-brand-dark hover:bg-brand-dark hover:text-white hover:border-brand-dark hover:-translate-y-1' }}">
                            Pilih Paket
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══════════════════════════════════════════════
         FAQ SECTION
    ═══════════════════════════════════════════════ --}}
    <section id="faq" class="py-16 md:py-20 px-6 lg:px-10 bg-brand-bg relative overflow-hidden">
        {{-- Ornamen --}}
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-brand-dark/[.04] rounded-full blur-[80px] pointer-events-none anim-pulse-soft z-0"></div>
        <svg class="absolute top-1/3 left-10 md:left-32 w-5 h-5 text-brand-accent/20 anim-float pointer-events-none z-0 hidden sm:block" style="animation-delay: -3s" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C12 6.627 17.373 12 24 12C17.373 12 12 17.373 12 24C12 17.373 6.627 12 0 12C6.627 12 12 6.627 12 0Z"/></svg>

        <div class="max-w-3xl mx-auto lp-reveal lp-delay-0 relative z-10">
            <div class="text-center mb-10">
                <span class="text-[10px] font-bold tracking-[0.2em] uppercase text-brand-accent mb-2 block">FAQ</span>
                <h2 class="font-serif text-3xl md:text-4xl text-brand-dark mb-3">Pertanyaan Seputar Aufilla</h2>
                <p class="text-brand-dark/80 text-[13px] md:text-[14px] leading-relaxed">Hal-hal yang sering ditanyakan oleh calon pengantin mengenai platform undangan kami.</p>
            </div>

            <div class="space-y-3">
                @php
                    $faqs = [
                        ['q' => 'Bagaimana cara membuat undangan digital?', 'a' => 'Cukup pilih tema yang Anda suka, daftar akun, lalu isi data mempelai dan detail acara. Undangan Anda akan langsung jadi dan siap disebarkan saat itu juga!'],
                        ['q' => 'Berapa lama masa aktif undangan?', 'a' => 'Semua paket undangan kami memiliki masa aktif selamanya (Unlimited). Sekali bayar, undangan Anda akan tetap bisa diakses tanpa ada biaya perpanjangan atau biaya bulanan.'],
                        ['q' => 'Apakah saya bisa mengganti tema nanti?', 'a' => 'Tentu! Anda bebas mengganti tema undangan kapan saja dan sesering apa pun langsung dari dashboard Anda tanpa dikenakan biaya tambahan.'],
                        ['q' => 'Apakah ada batasan jumlah tamu yang bisa diundang?', 'a' => 'Tidak ada sama sekali. Fitur Custom Nama Tamu kami berikan secara Unlimited, sehingga Anda bebas mencetak nama tamu dan menyebarkannya ke sebanyak apa pun kerabat Anda.'],
                        ['q' => 'Bagaimana jika saya butuh bantuan saat mengisi data?', 'a' => 'Tenang saja, tim support kami selalu siap memandu Anda melalui WhatsApp jika Anda mengalami kendala teknis atau kesulitan dalam menggunakan aplikasi.'],
                    ];
                @endphp

                @foreach($faqs as $faq)
                <div x-data="{ open: false }" class="group bg-white rounded-xl border border-brand-dark/5 shadow-sm overflow-hidden transition-all duration-300">
                    <button @click="open = !open" type="button" class="w-full flex justify-between items-center font-bold text-[13px] cursor-pointer text-brand-dark px-5 py-4 hover:text-brand-accent transition-colors select-none text-left focus:outline-none">
                        <span>{{ $faq['q'] }}</span>
                        <span class="transition-transform duration-500 text-brand-dark/40 group-hover:text-brand-accent ml-4 shrink-0" :class="open ? 'rotate-180' : ''">
                            <svg fill="none" height="18" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="18"><polyline points="6 9 12 15 18 9"/></svg>
                        </span>
                    </button>
                    
                    {{-- Smooth Grid Transition Trick --}}
                    <div class="grid transition-all duration-500 ease-in-out" :class="open ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0'">
                        <div class="overflow-hidden">
                            <div class="px-5 pb-5 text-[12px] md:text-[13px] leading-relaxed text-brand-dark/80 border-t border-brand-dark/5 pt-3 mt-1 transform transition-transform duration-500" :class="open ? 'translate-y-0' : '-translate-y-2'">
                                {{ $faq['a'] }}
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
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-8 mb-16 lp-reveal lp-delay-1">
                
                {{-- Left: Logo & Text (Col-span 5) --}}
                <div class="md:col-span-5 text-center flex flex-col items-center justify-center">
                    <img src="{{ asset('assets/img/logo-icon.png') }}" alt="Aufilla" class="w-16 h-16 object-contain mb-3">
                    <p class="text-[13px] leading-relaxed text-brand-dark/80 max-w-sm">
                        <strong class="font-bold text-brand-dark">Aufilla Invitation</strong> adalah penyedia jasa pembuatan undangan pernikahan digital. Kami menyediakan undangan website dengan desain yang premium dan fitur yang lengkap.
                    </p>
                </div>

                {{-- Middle: Contact (Col-span 4) --}}
                <div class="md:col-span-4 flex flex-col items-center md:items-start pl-0 md:pl-8">
                    <h4 class="text-[14px] md:text-[15px] font-bold text-brand-dark mb-6">Lebih Dekat dengan Kami</h4>
                    <ul class="space-y-4 text-[13px] text-brand-dark/80">
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <span>(+62) 857 6584 2510</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </div>
                            <span>Lutfi Afandi Rizal</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <span>lutfi_afandii</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-full bg-brand-bg flex items-center justify-center shrink-0 text-brand-accent">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span>aufilla@gmail.com</span>
                        </li>
                    </ul>
                </div>

                {{-- Right: Explore (Col-span 3) --}}
                <div class="md:col-span-3 flex flex-col items-center md:items-start pl-0 md:pl-4">
                    <h4 class="text-[14px] md:text-[15px] font-bold text-brand-dark mb-6">Explore</h4>
                    <ul class="space-y-4 text-[13px] text-brand-dark/80 text-center md:text-left w-full">
                        <li><a href="#" class="hover:text-brand-accent transition-colors block w-full">Home</a></li>
                        <li><a href="#fitur" class="hover:text-brand-accent transition-colors block w-full">Fitur</a></li>
                        <li><a href="#tema" class="hover:text-brand-accent transition-colors block w-full">Tema</a></li>
                        <li><a href="#harga" class="hover:text-brand-accent transition-colors block w-full">Harga</a></li>
                        <li><a href="#faq" class="hover:text-brand-accent transition-colors block w-full">F A Q</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-brand-dark/5 pt-8 text-center text-[11px] md:text-[12px] text-brand-dark/60 lp-reveal lp-delay-2">
                Copyright &copy; {{ date('Y') }} <strong class="text-brand-dark font-medium">Aufilla Invitation</strong>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════
         MODAL REGISTER
    ═══════════════════════════════════════════════ --}}
    <div id="register-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-500 bg-brand-dark/40 backdrop-blur-md">
        <div id="register-content" class="bg-white w-full max-w-md rounded-[2rem] p-10 relative transform scale-95 translate-y-8 opacity-0 transition-all duration-500 shadow-2xl border border-brand-dark/5">
            <button onclick="closeRegisterModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-brand-bg flex items-center justify-center text-brand-dark/40 hover:text-brand-dark hover:bg-brand-accent/10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="text-center mb-8 mt-2">
                <h3 class="font-serif text-[28px] text-brand-dark mb-2">Buat Undangan</h3>
                <p class="text-[13px] text-brand-dark/70">Mulai masa trial 24 jam gratis!</p>
            </div>
            <form action="{{ route('landing.register') }}" method="POST" class="space-y-5">
                @csrf
                @if($errors->any())
                    <div class="bg-red-50 border border-red-100 text-red-600 px-5 py-4 rounded-xl text-[12px] font-medium">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-[11px] font-bold tracking-widest uppercase text-brand-dark/80 mb-2">Tema Undangan</label>
                    <input type="hidden" name="theme_id" id="register-theme-id" required>
                    <div onclick="openThemePickerModal()" class="w-full bg-brand-bg border border-brand-dark/5 rounded-xl px-4 py-3 text-left flex items-center justify-between cursor-pointer hover:border-brand-accent transition-all group shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-4">
                            <div id="register-theme-thumbnail" class="w-12 h-12 rounded-lg bg-white border border-brand-dark/10 overflow-hidden flex items-center justify-center shadow-sm">
                                <svg class="w-6 h-6 text-brand-dark/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div id="register-theme-name" class="text-[14px] font-bold text-brand-dark/40 transition-colors">Belum memilih tema</div>
                                <div class="text-[11px] text-brand-dark/60 mt-0.5">Klik untuk memilih dari katalog</div>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:bg-brand-accent transition-colors">
                            <svg class="w-4 h-4 text-brand-dark/40 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold tracking-widest uppercase text-brand-dark/80 mb-2">Username</label>
                    <input type="text" name="username" required placeholder="romeojuliet"
                        class="w-full bg-brand-bg border border-brand-dark/5 rounded-xl px-5 py-3.5 text-[13px] text-brand-dark focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/30 transition-all placeholder:text-brand-dark/20">
                </div>
                <div>
                    <label class="block text-[11px] font-bold tracking-widest uppercase text-brand-dark/80 mb-2">Email</label>
                    <input type="email" name="email" required placeholder="email@contoh.com"
                        class="w-full bg-brand-bg border border-brand-dark/5 rounded-xl px-5 py-3.5 text-[13px] text-brand-dark focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/30 transition-all placeholder:text-brand-dark/20">
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold tracking-widest uppercase text-brand-dark/80 mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-brand-bg border border-brand-dark/5 rounded-xl px-5 py-3.5 text-[13px] text-brand-dark focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/30 transition-all">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold tracking-widest uppercase text-brand-dark/80 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-brand-bg border border-brand-dark/5 rounded-xl px-5 py-3.5 text-[13px] text-brand-dark focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent/30 transition-all">
                    </div>
                </div>
                <button type="submit" class="w-full bg-brand-dark text-white font-bold py-4 rounded-xl mt-4 hover:bg-brand-accent transition-all duration-300 text-[13px] uppercase tracking-widest shadow-lg shadow-brand-dark/20 hover:shadow-brand-accent/30 hover:-translate-y-1">
                    Daftar Sekarang
                </button>
                <p class="text-center text-[11px] text-brand-dark/70 mt-4">
                    Sudah punya akun? <a href="{{ route('login') }}" class="text-brand-accent font-bold hover:underline">Masuk</a>
                </p>
            </form>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         MODAL THEME PICKER
    ═══════════════════════════════════════════════ --}}
    <div id="theme-picker-modal" class="fixed inset-0 z-[110] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300 bg-brand-dark/60 backdrop-blur-sm">
        <div id="theme-picker-content" class="bg-white w-full max-w-4xl rounded-[2rem] overflow-hidden flex flex-col max-h-[85vh] transform scale-95 opacity-0 transition-all duration-300 shadow-2xl">
            <div class="bg-brand-bg p-5 md:p-6 flex justify-between items-center shrink-0 border-b border-brand-dark/5">
                <h3 class="font-serif font-bold text-brand-dark text-xl md:text-2xl">Pilih Tema Undangan</h3>
                <button type="button" onclick="closeThemePickerModal()" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-brand-dark/40 hover:text-brand-dark hover:bg-brand-accent/10 transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto bg-brand-bg/30">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                    @foreach($themes as $theme)
                        <div class="relative group cursor-pointer border-2 border-transparent rounded-2xl overflow-hidden hover:border-brand-accent hover:shadow-xl transition-all duration-300 bg-white flex flex-col"
                             onclick="selectRegisterTheme({{ $theme->id }}, `{{ addslashes($theme->name) }}`, `{{ $theme->thumbnail ? asset('storage/' . $theme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png') }}`)">
                            <div class="aspect-[3/4] bg-brand-bg relative overflow-hidden">
                                <img src="{{ $theme->thumbnail ? asset('storage/' . $theme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png') }}" onerror="this.src=`{{ asset('assets/img/thumbnail-tema/demo1.png') }}`" alt="{{ $theme->name }}" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-500">
                                
                                {{-- Indicator --}}
                                <div id="theme-indicator-{{ $theme->id }}" class="theme-indicator absolute inset-0 bg-brand-accent/20 items-center justify-center hidden opacity-0 transition-opacity duration-300">
                                    <div class="bg-brand-accent text-white rounded-full p-2 shadow-lg transform scale-90 group-hover:scale-100 transition-transform">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 text-center border-t border-brand-dark/5 mt-auto">
                                <h4 class="font-bold text-[13px] text-brand-dark">{{ $theme->name }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════════ --}}
    <script>
        // Modal Handlers
        const modal = document.getElementById('register-modal');
        const content = document.getElementById('register-content');

        function openRegisterModal(themeId = null, themeName = null, themeThumb = null) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95', 'translate-y-8', 'opacity-0');
            document.body.style.overflow = 'hidden';

            if (themeId && themeName && themeThumb) {
                selectRegisterTheme(themeId, themeName, themeThumb);
            } else if (!themeId) {
                // Reset form state for theme if opened generally
                document.getElementById('register-theme-id').value = '';
                
                const nameEl = document.getElementById('register-theme-name');
                nameEl.textContent = 'Belum memilih tema';
                nameEl.classList.add('text-brand-dark/40');
                nameEl.classList.remove('text-brand-dark');

                const thumbEl = document.getElementById('register-theme-thumbnail');
                thumbEl.innerHTML = `<svg class="w-6 h-6 text-brand-dark/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>`;

                document.querySelectorAll('.theme-indicator').forEach(el => {
                    el.classList.add('hidden', 'opacity-0');
                    el.classList.remove('flex');
                });
            }
        }
        function closeRegisterModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.add('scale-95', 'translate-y-8', 'opacity-0');
            document.body.style.overflow = '';
        }
        modal.addEventListener('click', e => { if (e.target === modal) closeRegisterModal(); });
        document.addEventListener('keydown', e => { 
            if (e.key === 'Escape') {
                closeThemePickerModal();
                closeRegisterModal(); 
            }
        });

        // Theme Picker Modal Handlers
        const pickerModal = document.getElementById('theme-picker-modal');
        const pickerContent = document.getElementById('theme-picker-content');

        function openThemePickerModal() {
            pickerModal.classList.remove('opacity-0', 'pointer-events-none');
            pickerContent.classList.remove('scale-95', 'opacity-0');
        }

        function closeThemePickerModal() {
            pickerModal.classList.add('opacity-0', 'pointer-events-none');
            pickerContent.classList.add('scale-95', 'opacity-0');
        }

        pickerModal.addEventListener('click', e => { if (e.target === pickerModal) closeThemePickerModal(); });

        function selectRegisterTheme(id, name, thumb) {
            document.getElementById('register-theme-id').value = id;
            
            const nameEl = document.getElementById('register-theme-name');
            nameEl.textContent = name;
            nameEl.classList.remove('text-brand-dark/40');
            nameEl.classList.add('text-brand-dark');

            const thumbEl = document.getElementById('register-theme-thumbnail');
            thumbEl.innerHTML = `<img src="${thumb}" alt="${name}" class="w-full h-full object-cover">`;

            // Reset all indicators
            document.querySelectorAll('.theme-indicator').forEach(el => {
                el.classList.add('hidden', 'opacity-0');
                el.classList.remove('flex');
            });
            // Show indicator on selected
            const activeIndicator = document.getElementById('theme-indicator-' + id);
            if (activeIndicator) {
                activeIndicator.classList.remove('hidden');
                activeIndicator.classList.add('flex');
                setTimeout(() => activeIndicator.classList.remove('opacity-0'), 10);
            }

            closeThemePickerModal();
        }

        @if($errors->any())
            openRegisterModal();
        @endif

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
