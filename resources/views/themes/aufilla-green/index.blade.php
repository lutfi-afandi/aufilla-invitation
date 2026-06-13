<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    @php
    $pengaturan = (object) [
    'nama_mempelai_wanita' => $invitation->wanita_nama_lengkap ?? 'Nama Wanita Lengkap',
    'nama_panggilan_wanita' => $invitation->wanita_nama ?? 'Wanita',
    'nama_ayah_wanita' => $invitation->wanita_ayah ?? 'Bapak Wanita',
    'nama_ibu_wanita' => $invitation->wanita_ibu ?? 'Ibu Wanita',
    'instagram_wanita' => null,
    'foto_wanita' => $invitation->wanita_foto ? asset('storage/' . $invitation->wanita_foto) : asset('assets/default/default_wanita.jpg'),

    'nama_mempelai_pria' => $invitation->pria_nama_lengkap ?? 'Nama Pria Lengkap',
    'nama_panggilan_pria' => $invitation->pria_nama ?? 'Pria',
    'nama_ayah_pria' => $invitation->pria_ayah ?? 'Bapak Pria',
    'nama_ibu_pria' => $invitation->pria_ibu ?? 'Ibu Pria',
    'instagram_pria' => null,
    'foto_pria' => $invitation->pria_foto ? asset('storage/' . $invitation->pria_foto) : asset('assets/default/default_pria.jpg'),

    'foto_hero' => $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg'),

    'tanggal_pernikahan' => $akad && $akad->tgl_acara ? \Carbon\Carbon::parse($akad->tgl_acara) : now(),
    'lokasi_akad' => $akad->lokasi ?? 'Lokasi Akad',
    'alamat_akad' => $akad->alamat ?? 'Alamat lengkap akad',
    'lokasi_resepsi' => $resepsi->lokasi ?? 'Lokasi Resepsi',
    'alamat_resepsi' => $resepsi->alamat ?? 'Alamat lengkap resepsi',
    'google_maps_url' => $akad->gmaps_link ?? '#',

    'musik_background' => $invitation->music_file ? asset('storage/' . $invitation->music_file) : asset('assets/default/default-music.mp3'),

    'rekening_1_nama' => null,
    'rekening_1_nomor' => null,
    'rekening_1_bank' => null,
    'rekening_2_nama' => null,
    'rekening_2_nomor' => null,
    'rekening_2_bank' => null,
    'alamat_pengiriman' => null,
    ];

    $meta_title = "The Wedding of " . $pengaturan->nama_panggilan_wanita . " & " . $pengaturan->nama_panggilan_pria;
    $meta_desc = "Kami mengundang Anda untuk hadir di acara pernikahan kami pada " . $pengaturan->tanggal_pernikahan->translatedFormat('l, d F Y') . ".";

    $nama_tamu_display = $tamu ? $tamu->nama_tamu : request('to', 'Bapak/Ibu/Saudara/i');
    @endphp
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Primary Meta Tags -->
    <title>{{ $meta_title }}</title>
    <meta name="title" content="{{ $meta_title }}">
    <meta name="description" content="{{ $meta_desc }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $meta_title }}">
    <meta property="og:description" content="{{ $meta_desc }}">
    <meta property="og:image" content="{{ $pengaturan->foto_hero }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $meta_title }}">
    <meta property="twitter:description" content="{{ $meta_desc }}">
    <meta property="twitter:image" content="{{ $pengaturan->foto_hero }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('themes/aufilla-green/css/tailwind.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/aufilla-green/css/google-fonts.css') }}" rel="stylesheet" />
    <link href="{{ asset('themes/aufilla-green/css/aos.css') }}" rel="stylesheet" />
    <style>
        @import url('{{ asset("assets/css/google-theme.css") }}');

        body {
            font-family: 'Inter', 'DM Sans', sans-serif;
            color: #2c3930;
            background-color: #faf6f0;
            overflow-x: hidden;
            margin: 0;
        }

        .font-heading {
            font-family: 'Cormorant Garamond', 'Playfair Display', serif;
        }

        .font-body {
            font-family: 'Inter', 'DM Sans', sans-serif;
        }

        /* Bulletproof Tailwind CSS Fallback Utilities */
        .flex {
            display: flex !important;
        }

        .flex-col {
            flex-direction: column !important;
        }

        .flex-wrap {
            flex-wrap: wrap !important;
        }

        .items-center {
            align-items: center !important;
        }

        .items-start {
            align-items: flex-start !important;
        }

        .items-stretch {
            align-items: stretch !important;
        }

        .justify-center {
            justify-content: center !important;
        }

        .justify-between {
            justify-content: space-between !important;
        }

        .justify-end {
            justify-content: flex-end !important;
        }

        .grid {
            display: grid !important;
        }

        .grid-cols-2 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
        }

        .grid-cols-3 {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
        }

        .w-full {
            width: 100% !important;
        }

        .h-full {
            height: 100% !important;
        }

        .w-3 {
            width: 12px !important;
        }

        .h-3 {
            height: 12px !important;
        }

        .w-3\.5 {
            width: 14px !important;
        }

        .h-3\.5 {
            height: 14px !important;
        }

        .w-4 {
            width: 16px !important;
        }

        .h-4 {
            height: 16px !important;
        }

        .w-5 {
            width: 20px !important;
        }

        .h-5 {
            height: 20px !important;
        }

        .w-6 {
            width: 24px !important;
        }

        .h-6 {
            height: 24px !important;
        }

        .w-8 {
            width: 32px !important;
        }

        .h-8 {
            height: 32px !important;
        }

        .w-12 {
            width: 48px !important;
        }

        .h-12 {
            height: 48px !important;
        }

        .w-16 {
            width: 64px !important;
        }

        .h-16 {
            height: 64px !important;
        }

        .w-20 {
            width: 80px !important;
        }

        .h-20 {
            height: 80px !important;
        }

        .w-24 {
            width: 96px !important;
        }

        .h-24 {
            height: 96px !important;
        }

        .w-32 {
            width: 128px !important;
        }

        .h-32 {
            height: 128px !important;
        }

        .bg-cover {
            background-size: cover !important;
        }

        .bg-center {
            background-position: center !important;
        }

        .bg-no-repeat {
            background-repeat: no-repeat !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .hidden {
            display: none !important;
        }

        .block {
            display: block !important;
        }

        .inline-block {
            display: inline-block !important;
        }

        .relative {
            position: relative !important;
        }

        .absolute {
            position: absolute !important;
        }

        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #c5a880 0%, #b39265 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            box-shadow: 0 4px 15px rgba(179, 146, 101, 0.3);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(179, 146, 101, 0.4);
            background: linear-gradient(135deg, #b39265 0%, #a07d50 100%);
        }

        .btn-gold:active {
            transform: translateY(0);
        }

        .btn-outline-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            color: #b39265;
            padding: 0.7rem 1.8rem;
            border-radius: 9999px;
            font-size: 0.95rem;
            font-weight: 500;
            letter-spacing: 0.05em;
            border: 1.5px solid #c5a880;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-outline-gold:hover {
            background: rgba(197, 168, 128, 0.1);
            color: #8c6e45;
            border-color: #8c6e45;
        }

        .arch-frame {
            border-top-left-radius: 9999px;
            border-top-right-radius: 9999px;
            overflow: hidden;
        }

        .arch-card {
            border-top-left-radius: 9999px;
            border-top-right-radius: 9999px;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(197, 168, 128, 0.25);
        }

        .arch-outline-wrapper {
            position: relative;
            padding: 10px;
            border: 1px solid rgba(197, 168, 128, 0.3);
            border-top-left-radius: 9999px;
            border-top-right-radius: 9999px;
            border-bottom-left-radius: 24px;
            border-bottom-right-radius: 24px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(12px) saturate(180%);
            -webkit-backdrop-filter: blur(12px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.55);
            box-shadow: 0 10px 30px -5px rgba(29, 50, 38, 0.04);
        }

        .glass-card-gold {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(197, 168, 128, 0.35);
            box-shadow: 0 15px 35px -5px rgba(197, 168, 128, 0.1);
        }

        .glass-card-dark {
            background: rgba(29, 50, 38, 0.75);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(197, 168, 128, 0.3);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25);
        }

        .floating-leaf {
            position: absolute;
            pointer-events: none;
            z-index: 1;
            animation: fall linear forwards;
        }

        @keyframes fall {
            0% {
                transform: translateY(-20px) rotate(0deg) translateX(0);
                opacity: 0;
            }

            10% {
                opacity: 0.6;
            }

            90% {
                opacity: 0.6;
            }

            100% {
                transform: translateY(105vh) rotate(360deg) translateX(80px);
                opacity: 0;
            }
        }

        .floating-navbar {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            opacity: 0;
            z-index: 45;
            transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .floating-navbar.visible {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .music-controller {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(197, 168, 128, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 48;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .music-controller:hover {
            transform: scale(1.08);
            border-color: #c5a880;
        }

        .music-controller.playing .disc {
            animation: rotate-disc 6s linear infinite;
        }

        @keyframes rotate-disc {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .pulse-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #c5a880;
            animation: pulse-ring-anim 2.5s cubic-bezier(0.215, 0.610, 0.355, 1) infinite;
            opacity: 0;
        }

        @keyframes pulse-ring-anim {
            0% {
                transform: scale(0.95);
                opacity: 0.8;
            }

            100% {
                transform: scale(1.45);
                opacity: 0;
            }
        }

        .toast-notification {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%) translateY(30px);
            background: rgba(29, 50, 38, 0.95);
            color: #faf6f0;
            border: 1px solid #c5a880;
            padding: 10px 24px;
            border-radius: 30px;
            z-index: 100;
            font-size: 0.9rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .toast-notification.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            visibility: visible;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #faf6f0;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5a880;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #b39265;
        }

        #splash-screen {
            position: fixed;
            inset: 0;
            z-index: 50;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 1.2s cubic-bezier(0.77, 0, 0.175, 1);
        }

        #splash-screen.hidden-splash {
            opacity: 0;
            transform: scale(1.08);
            pointer-events: none;
        }

        #main-content {
            opacity: 0;
            transition: opacity 1.2s ease-out;
        }

        #main-content.visible {
            opacity: 1;
        }

        .text-gold-gradient {
            background: linear-gradient(135deg, #e5c088 0%, #b39265 50%, #e5c088 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .ornament-divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            justify-content: center;
            margin: 1.5rem 0;
        }

        .ornament-divider::before,
        .ornament-divider::after {
            content: '';
            flex: 1;
            max-width: 80px;
            height: 1px;
            background: linear-gradient(to right, transparent, #c5a880);
        }

        .ornament-divider::after {
            background: linear-gradient(to left, transparent, #c5a880);
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom, transparent, #c5a880 15%, #c5a880 85%, transparent);
        }

        @media (max-width: 768px) {
            .timeline-line {
                left: 24px;
            }
        }

        .hero-arch-wrapper {
            width: 260px;
            height: 360px;
        }

        @media (min-width: 768px) {
            .hero-arch-wrapper {
                width: 320px;
                height: 440px;
            }

            .mempelai-grid {
                display: flex !important;
                flex-wrap: nowrap !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 4rem !important;
            }

            .venue-grid {
                display: flex !important;
                flex-wrap: nowrap !important;
                gap: 2rem !important;
                justify-content: center !important;
                align-items: stretch !important;
            }

            .gift-grid {
                display: flex !important;
                flex-direction: row !important;
                gap: 1.5rem !important;
                justify-content: center !important;
                align-items: center !important;
            }

            .rsvp-grid {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 3rem !important;
            }
        }

        @media (max-width: 767px) {
            .mempelai-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 3rem !important;
                align-items: center !important;
            }

            .venue-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 2rem !important;
                align-items: center !important;
            }

            .gift-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 1.5rem !important;
                align-items: center !important;
            }

            .rsvp-grid {
                display: flex !important;
                flex-direction: column !important;
                gap: 3rem !important;
            }
        }
    </style>
</head>

<body class="antialiased leading-relaxed">

    <!-- Toast Notification -->
    <div id="toast" class="toast-notification"></div>

    <!-- Splash Screen -->
    <div id="splash-screen"
        style="background-image: url('{{ asset('themes/aufilla-green/images/bg-splash.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
        <div
            style="position: absolute; inset: 0; background-color: rgba(29, 50, 38, 0.85); backdrop-filter: blur(3px); -webkit-backdrop-filter: blur(3px);">
        </div>
        <div class="relative z-10 w-[90%] max-w-[480px] p-8 md:p-12 text-center rounded-[32px] glass-card-dark text-[#faf6f0] border border-[#c5a880]/30 shadow-2xl"
            data-aos="zoom-in" data-aos-duration="1500"
            style="position: relative; z-index: 10; width: 90%; max-w: 480px; padding: 2.5rem; text-align: center; border-radius: 32px;">
            <p class="text-xs uppercase tracking-[0.3em] text-[#c5a880] mb-3"
                style="letter-spacing: 0.3em; margin-bottom: 0.75rem;">Pernikahan Dari</p>
            <h1 class="font-heading text-4xl md:text-5xl font-bold mb-4 tracking-wide leading-tight"
                style="margin-bottom: 1rem; line-height: 1.2;">
                {{ $invitation->wanita_nama }} <span class="text-[#c5a880] font-light">&</span>
                {{ $invitation->pria_nama }}
            </h1>
            <div class="ornament-divider text-[#c5a880] text-sm my-6"
                style="margin-top: 1.5rem; margin-bottom: 1.5rem;">&#10022;</div>
            <div class="mb-8" style="margin-bottom: 2rem;">
                <p class="text-xs uppercase tracking-[0.2em] text-[#faf6f0]/60 mb-2 font-body"
                    style="letter-spacing: 0.2em; margin-bottom: 0.5rem; opacity: 0.6;">Kepada Yth. Bapak/Ibu/Saudara/i:
                </p>
                <div class="inline-block py-2 px-6 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-md"
                    style="display: inline-block; padding: 0.5rem 1.5rem; border-radius: 16px; background-color: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <h2 id="guest-name" class="font-heading text-xl md:text-2xl text-[#e5c088] font-semibold font-serif"
                        style="margin: 0; font-weight: 600;">
                        {{ $nama_tamu_display }}
                    </h2>
                </div>
            </div>
            <button id="open-invitation-btn"
                class="btn-gold font-body cursor-pointer flex items-center justify-center gap-3 w-full"
                style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    fill="currentColor">
                    <path
                        d="M19.5 3h-15L3 4.5v15L4.5 21h15l1.5-1.5v-15L19.5 3zm-7.5 10.5L4.5 7.5h15L12 13.5zM4.5 9v10.5h15V9L12 15 4.5 9z" />
                </svg>
                Buka Undangan
            </button>
        </div>
        <audio id="background-music" loop preload="auto">
            <source
                src="{{ $invitation->music_url }}"
                type="audio/mpeg">
        </audio>
    </div>

    <!-- Music Controller -->
    <div id="music-btn" class="music-controller hidden shadow-lg" style="width: 48px; height: 48px;">
        <div class="pulse-ring"></div>
        <svg class="disc" viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
            fill="currentColor">
            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z" />
        </svg>
    </div>


    @if(isset($tamu) && isset($qrCode))
    <!-- Floating QR Button (100% inline styles) -->
    <button id="qr-btn" onclick="document.getElementById('qr-modal').style.display='flex'"
        style="position: fixed; bottom: 84px; right: 24px; width: 48px; height: 48px; z-index: 9999; background-color: #1d3226; color: #e5c088; border: 1px solid rgba(197,168,128,0.3); border-radius: 9999px; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 15px rgba(0,0,0,0.3); padding: 0;">
        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
        </svg>
    </button>

    <!-- QR Modal (100% inline styles) -->
    <div id="qr-modal"
        style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 10000; background-color: rgba(0,0,0,0.6); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); align-items: center; justify-content: center; padding: 1rem;">
        <div style="background: #fff; border-radius: 1rem; box-shadow: 0 25px 50px rgba(0,0,0,0.25); width: 100%; max-width: 24rem; overflow: hidden; text-align: center; margin: auto;">
            <div style="background-color: #1d3226; padding: 1rem; color: #fff; display: flex; justify-content: space-between; align-items: center;">
                <h3 class="font-heading" style="font-size: 1.125rem; font-weight: 700; color: #e5c088; margin: 0;">Tiket Akses Masuk</h3>
                <button onclick="document.getElementById('qr-modal').style.display='none'"
                    style="background: none; border: none; color: #fff; cursor: pointer; padding: 4px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div style="padding: 2rem; display: flex; flex-direction: column; align-items: center;">
                <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1.5rem; line-height: 1.6;">Selamat datang! Silakan tunjukkan QR Code ini kepada resepsionis saat Anda tiba di lokasi acara.</p>
                <div style="background: #fff; padding: 0.75rem; border: 4px solid rgba(29,50,38,0.1); border-radius: 1rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: inline-block; margin-bottom: 1.5rem;">
                    {!! $qrCode !!}
                </div>
                <div style="width: 100%; height: 1px; background-color: #e5e7eb; margin-bottom: 1rem;"></div>
                <p class="font-heading" style="font-weight: 700; font-size: 1.5rem; color: #1d3226; margin: 0;">{{ $tamu->nama_tamu }}</p>
                <span style="font-size: 0.75rem; font-family: monospace; color: #9ca3af; margin-top: 0.25rem; text-transform: uppercase; letter-spacing: 0.1em;">{{ $tamu->kode_qr }}</span>
                <div style="margin-top: 1.5rem;">
                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ $tamu->kode_qr }}" download="QR_{{ $tamu->nama_tamu }}.png" target="_blank"
                        style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1.5rem; background-color: #1d3226; color: #e5c088; border-radius: 9999px; text-decoration: none; font-size: 0.875rem; font-weight: 600;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Simpan Tiket (PNG)
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Floating Navbar -->
    <nav id="floating-nav" class="floating-navbar">
        <div class="flex items-center gap-1 p-2 rounded-full glass-card-dark border border-[#c5a880]/30 shadow-2xl backdrop-blur-xl"
            style="padding: 0.5rem; border-radius: 9999px; display: flex; align-items: center; gap: 0.25rem;">
            <a href="#hero"
                class="flex flex-col items-center p-2.5 rounded-full hover:bg-white/10 transition-colors text-[#faf6f0] hover:text-[#e5c088]"
                style="padding: 0.6rem; border-radius: 9999px; display: flex;" title="Cover">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    fill="none">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </a>
            <a href="#mempelai"
                class="flex flex-col items-center p-2.5 rounded-full hover:bg-white/10 transition-colors text-[#faf6f0] hover:text-[#e5c088]"
                style="padding: 0.6rem; border-radius: 9999px; display: flex;" title="Mempelai">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    fill="none">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                    </path>
                </svg>
            </a>
            <a href="#acara"
                class="flex flex-col items-center p-2.5 rounded-full hover:bg-white/10 transition-colors text-[#faf6f0] hover:text-[#e5c088]"
                style="padding: 0.6rem; border-radius: 9999px; display: flex;" title="Acara">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    fill="none">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </a>
            <a href="#story"
                class="flex flex-col items-center p-2.5 rounded-full hover:bg-white/10 transition-colors text-[#faf6f0] hover:text-[#e5c088]"
                style="padding: 0.6rem; border-radius: 9999px; display: flex;" title="Cerita">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    fill="none">
                    <path d="M12 20h9"></path>
                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                </svg>
            </a>
            <a href="#gift"
                class="flex flex-col items-center p-2.5 rounded-full hover:bg-white/10 transition-colors text-[#faf6f0] hover:text-[#e5c088]"
                style="padding: 0.6rem; border-radius: 9999px; display: flex;" title="Hadiah">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    fill="none">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </a>
            <a href="#rsvp"
                class="flex flex-col items-center p-2.5 rounded-full hover:bg-white/10 transition-colors text-[#faf6f0] hover:text-[#e5c088]"
                style="padding: 0.6rem; border-radius: 9999px; display: flex;" title="RSVP">
                <svg viewBox="0 0 24 24" width="20" height="20" style="width: 20px; height: 20px;"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    fill="none">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg>
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content">

        <!-- Hero Section -->
        <section id="hero"
            class="relative min-h-screen flex items-center justify-center text-center py-20 px-4 overflow-hidden"
            style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('themes/aufilla-green/images/bg-hero.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div style="position: absolute; inset: 0; background-color: rgba(250, 246, 240, 0.88);"></div>
            <div class="relative z-10 w-full max-w-[800px] flex flex-col items-center" data-aos="fade-up"
                data-aos-duration="1500">
                <p class="text-xs md:text-sm font-semibold tracking-[0.4em] uppercase text-[#849687] mb-6"
                    style="letter-spacing: 0.4em; margin-bottom: 1.5rem;">The Wedding Of</p>
                <div class="hero-arch-wrapper arch-outline-wrapper mb-8 bg-white/20 shadow-xl backdrop-blur-sm"
                    style="background-color: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                    <div class="arch-card w-full h-full relative">
                        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                            style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('themes/aufilla-green/images/bg-hero.svg') }}'); filter: brightness(0.9) contrast(1.05);">
                        </div>
                        <div
                            class="absolute inset-0 flex flex-col justify-end p-6 bg-gradient-to-t from-[#1d3226]/85 via-transparent to-transparent text-white text-center">
                            <h2 class="font-heading text-4xl md:text-5xl font-bold tracking-wide"
                                style="font-weight: 700; letter-spacing: 0.05em; margin: 0;">
                                {{ substr($invitation->wanita_nama, 0, 1) }} &
                                {{ substr($invitation->pria_nama, 0, 1) }}
                            </h2>
                            <p class="text-xs uppercase tracking-[0.22em] text-[#e5c088] mt-2 font-semibold"
                                style="letter-spacing: 0.22em; margin-top: 0.5rem;">
                                {{ $akad ? \Carbon\Carbon::parse($akad->tgl_acara)->format('d F Y') : '' }}
                            </p>
                        </div>
                    </div>
                </div>
                <h1 class="font-heading text-5xl md:text-7xl leading-none text-[#1d3226] font-bold mb-4 tracking-wide"
                    style="line-height: 1.1; margin-bottom: 1rem; font-weight: 700;">
                    {{ $invitation->wanita_nama_lengkap }} & {{ $invitation->pria_nama_lengkap }}
                </h1>
                <div class="ornament-divider text-[#c5a880] w-[180px] my-4"
                    style="width: 180px; margin-top: 1rem; margin-bottom: 1rem;">&#10022;</div>
                <p class="text-xs md:text-sm font-semibold text-[#c5a880] tracking-[0.3em] font-body mb-6"
                    style="letter-spacing: 0.3em; margin-bottom: 1.5rem;">
                    {{ $akad ? strtoupper(\Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l, d F Y')) : '' }}
                </p>
                <div class="max-w-[500px] mx-auto py-4 px-6 rounded-2xl glass-card border border-[#c5a880]/20 shadow-sm"
                    style="max-w: 500px; padding: 1rem 1.5rem; border-radius: 16px;">
                    <p class="text-xs md:text-sm text-[#5a6b5d] leading-relaxed italic font-body"
                        style="margin: 0; line-height: 1.6;">
                        "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu pasangan hidup dari
                        jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya di
                        antaramu rasa kasih dan sayang."
                    </p>
                    <span class="block mt-2 text-xs font-semibold text-[#849687] uppercase tracking-widest"
                        style="display: block; margin-top: 0.5rem; letter-spacing: 0.15em;">- QS. AR-RUM 21</span>
                </div>
            </div>
            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex flex-col items-center gap-1 text-[#c5a880] text-xs font-semibold tracking-widest opacity-80 animate-bounce"
                style="position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                <span class="uppercase" style="letter-spacing: 0.2em;">Scroll</span>
                <svg viewBox="0 0 24 24" width="16" height="16" style="width: 16px; height: 16px;"
                    fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </section>

        <!-- Couple Profile Section -->
        <section id="mempelai" class="py-24 px-6 bg-[#faf6f0] text-center relative overflow-hidden"
            style="padding: 6rem 1.5rem;">
            <div class="max-w-[1000px] mx-auto relative z-10">
                <p data-aos="fade-up" class="text-xs uppercase tracking-[0.3em] text-[#849687] mb-2 font-semibold"
                    style="letter-spacing: 0.3em; margin-bottom: 0.5rem;">Bismillah</p>
                <h2 data-aos="fade-up" class="font-heading text-3xl md:text-5xl text-[#1d3226] font-bold mb-4"
                    style="font-weight: 700; margin-bottom: 1rem;">Mempelai Pernikahan</h2>
                <p data-aos="fade-up"
                    class="text-xs md:text-sm text-[#5a6b5d] max-w-[620px] mx-auto mb-16 leading-relaxed font-body"
                    style="max-w: 620px; margin-bottom: 4rem; line-height: 1.6;">
                    Dengan memohon rahmat dan ridho Allah SWT, kami dengan sukacita mengundang Anda untuk menyaksikan
                    persatuan suci pernikahan kami.
                </p>
                <div class="mempelai-grid">
                    <!-- Bride -->
                    <div data-aos="fade-right" data-aos-duration="1200" class="flex flex-col items-center"
                        style="max-width: 280px; width: 100%;">
                        <div class="arch-outline-wrapper shadow-xl bg-white/30"
                            style="width: 200px; height: 280px; margin-bottom: 1.5rem; background-color: rgba(255,255,255,0.3); padding: 8px;">
                            <div class="arch-card w-full h-full">
                                <img src="{{ $invitation->wanita_foto ? asset('storage/' . $invitation->wanita_foto) : asset('themes/aufilla-green/images/bride.png') }}"
                                    alt="{{ $invitation->wanita_nama_lengkap ?? 'Mempelai Wanita' }}" class="w-full h-full object-cover"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <h3 class="font-heading text-2xl md:text-3xl text-[#1d3226] font-bold mb-1"
                            style="font-weight: 700; margin-bottom: 0.25rem;">{{ $invitation->wanita_nama_lengkap }}
                        </h3>
                        <p class="text-xs tracking-widest text-[#c5a880] uppercase font-semibold mb-3"
                            style="letter-spacing: 0.15em; margin-bottom: 0.75rem;">
                            {{ $invitation->wanita_nama }}
                        </p>
                        <p class="text-xs md:text-sm text-[#5a6b5d] mb-4 font-serif leading-relaxed"
                            style="margin-bottom: 1rem; line-height: 1.5;">
                            Putri terkasih dari <br><span class="font-semibold"
                                style="font-weight: 600;">{{ $invitation->wanita_ayah ?? 'Ayah' }}</span> <br>&
                            <span class="font-semibold"
                                style="font-weight: 600;">{{ $invitation->wanita_ibu ?? 'Ibu' }}</span>
                        </p>
                        @if ($pengaturan && $pengaturan->instagram_wanita)
                        <a href="https://instagram.com/{{ $pengaturan->instagram_wanita }}" target="_blank"
                            class="inline-flex items-center gap-2 text-xs text-[#faf6f0] bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-colors border border-white/20"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: #faf6f0; background-color: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 9999px; border: 1px solid rgba(255,255,255,0.2); text-decoration: none;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
                                stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                </rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                            @{{ $pengaturan->instagram_wanita }}
                        </a>
                        @endif
                    </div>

                    <div data-aos="zoom-in" class="hidden md:block">
                        <span class="font-heading text-6xl text-[#c5a880]/40 font-light"
                            style="font-weight: 300;">&</span>
                    </div>

                    <!-- Groom -->
                    <div data-aos="fade-left" data-aos-duration="1200" class="flex flex-col items-center"
                        style="max-width: 280px; width: 100%;">
                        <div class="arch-outline-wrapper shadow-xl bg-white/30"
                            style="width: 200px; height: 280px; margin-bottom: 1.5rem; background-color: rgba(255,255,255,0.3); padding: 8px;">
                            <div class="arch-card w-full h-full">
                                <img src="{{ $invitation->pria_foto ? asset('storage/' . $invitation->pria_foto) : asset('themes/aufilla-green/images/groom.png') }}"
                                    alt="{{ $invitation->pria_nama_lengkap ?? 'Mempelai Pria' }}" class="w-full h-full object-cover"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <h3 class="font-heading text-2xl md:text-3xl text-[#1d3226] font-bold mb-1"
                            style="font-weight: 700; margin-bottom: 0.25rem;">{{ $invitation->pria_nama_lengkap }}
                        </h3>
                        <p class="text-xs tracking-widest text-[#c5a880] uppercase font-semibold mb-3"
                            style="letter-spacing: 0.15em; margin-bottom: 0.75rem;">
                            {{ $invitation->pria_nama }}
                        </p>
                        <p class="text-xs md:text-sm text-[#5a6b5d] mb-4 font-serif leading-relaxed"
                            style="margin-bottom: 1rem; line-height: 1.5;">
                            Putra tercinta dari <br><span class="font-semibold"
                                style="font-weight: 600;">{{ $invitation->pria_ayah ?? 'Ayah' }}</span> <br>&
                            <span class="font-semibold"
                                style="font-weight: 600;">{{ $invitation->pria_ibu ?? 'Ibu' }}</span>
                        </p>
                        @if ($pengaturan && $pengaturan->instagram_pria)
                        <a href="https://instagram.com/{{ $pengaturan->instagram_pria }}" target="_blank"
                            class="inline-flex items-center gap-2 text-xs text-[#faf6f0] bg-white/10 hover:bg-white/20 px-4 py-2 rounded-full transition-colors border border-white/20"
                            style="display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.75rem; color: #faf6f0; background-color: rgba(255,255,255,0.1); padding: 0.5rem 1rem; border-radius: 9999px; border: 1px solid rgba(255,255,255,0.2); text-decoration: none;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none"
                                stroke="currentColor" stroke-width="2" style="width: 14px; height: 14px;">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5">
                                </rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                            @{{ $pengaturan->instagram_pria }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        @if($invitation->is_galeri_aktif && $galeris->count() > 0)
        <section id="gallery" class="py-24 px-6 bg-[#1d3226] relative overflow-hidden" style="padding: 6rem 1.5rem;">
            <div class="max-w-[1000px] mx-auto relative z-10">
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 4rem;">
                    <p data-aos="fade-up" class="text-xs uppercase tracking-[0.3em] text-[#849687] mb-2 font-semibold"
                        style="letter-spacing: 0.3em; margin-bottom: 0.5rem; color: #849687;">Momen Bahagia</p>
                    <h2 data-aos="fade-up" class="font-heading text-3xl md:text-5xl text-[#faf6f0] font-bold"
                        style="font-weight: 700; color: #faf6f0;">Galeri Kami</h2>
                    <div class="ornament-divider text-[#c5a880] w-[140px] mx-auto"
                        style="width: 140px; margin-left: auto; margin-right: auto; margin-top: 1rem;">&#10022;</div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    @foreach($galeris as $index => $galeri)
                    <div data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}" class="relative overflow-hidden rounded-2xl group border border-white/10" style="border-radius: 16px; aspect-ratio: 1/1; overflow: hidden;">
                        <img src="{{ asset('storage/' . $galeri->image_path) }}" alt="Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s;">
                        <div class="absolute inset-0 bg-[#1d3226]/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(29,50,38,0.4); opacity: 0; transition: opacity 0.5s;"></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Love Journey Timeline - Static content (can be enhanced later) -->
        @if($invitation->is_cerita_aktif && $ceritas->count() > 0)
        <section id="story" class="py-24 px-6 bg-[#faf6f0]/50 relative overflow-hidden"
            style="padding: 6rem 1.5rem;">
            <div class="max-w-[800px] mx-auto relative z-10">
                <div class="text-center mb-16" style="text-align: center; margin-bottom: 4rem;">
                    <p data-aos="fade-up" class="text-xs uppercase tracking-[0.3em] text-[#849687] mb-2 font-semibold"
                        style="letter-spacing: 0.3em; margin-bottom: 0.5rem;">Kisah Cinta</p>
                    <h2 data-aos="fade-up" class="font-heading text-3xl md:text-5xl text-[#1d3226] font-bold"
                        style="font-weight: 700;">Perjalanan Kita</h2>
                    <div class="ornament-divider text-[#c5a880] w-[140px] mx-auto"
                        style="width: 140px; margin-left: auto; margin-right: auto;">&#10022;</div>
                </div>
                <div class="relative" style="position: relative;">
                    <div class="timeline-line"></div>
                    @forelse ($ceritas as $index => $cerita)
                    <div class="relative flex flex-wrap md:flex-nowrap md:justify-between items-center mb-12 md:mb-16"
                        style="position: relative; display: flex; align-items: center; margin-bottom: 3rem;">

                        @if($index % 2 == 0)
                        <div class="w-full md:w-[45%] md:text-right md:pr-8 mb-4 md:mb-0 order-2 md:order-1"
                            data-aos="fade-right" style="width: 100%;">
                            <div class="glass-card p-6 rounded-2xl border border-white shadow-sm inline-block text-left w-full"
                                style="padding: 1.5rem; border-radius: 16px;">
                                <span class="text-xs uppercase tracking-widest text-[#c5a880] font-semibold block mb-1"
                                    style="letter-spacing: 0.1em; display: block; margin-bottom: 0.25rem;">{{ $cerita->tanggal }}</span>
                                <h4 class="font-heading text-xl text-[#1d3226] font-bold mb-2"
                                    style="font-weight: 700; margin-bottom: 0.5rem;">{{ $cerita->judul }}</h4>
                                <p class="text-xs md:text-sm text-[#5a6b5d] font-body leading-relaxed"
                                    style="margin: 0; line-height: 1.6;">{{ $cerita->isi_cerita }}</p>
                            </div>
                        </div>
                        <div class="absolute left-0 md:left-1/2 transform -translate-x-[11px] md:-translate-x-1/2 w-6 h-6 rounded-full bg-[#faf6f0] border-4 border-[#c5a880] flex items-center justify-center z-10 order-1 md:order-2"
                            style="position: absolute; left: 0; transform: translateX(-11px); width: 24px; height: 24px; border-radius: 50%; border: 4px solid #c5a880; background-color: #faf6f0; z-index: 10;">
                            <div style="width: 6px; height: 6px; border-radius: 50%; background-color: #1d3226;"></div>
                        </div>
                        <div class="w-full md:w-[45%] md:pl-8 order-3" data-aos="fade-left"></div>
                        @else
                        <div class="w-full md:w-[45%] md:pr-8 mb-4 md:mb-0 order-2 md:order-1" data-aos="fade-right"
                            style="width: 100%;"></div>
                        <div class="absolute left-0 md:left-1/2 transform -translate-x-[11px] md:-translate-x-1/2 w-6 h-6 rounded-full bg-[#faf6f0] border-4 border-[#c5a880] flex items-center justify-center z-10 order-1 md:order-2"
                            style="position: absolute; left: 0; transform: translateX(-11px); width: 24px; height: 24px; border-radius: 50%; border: 4px solid #c5a880; background-color: #faf6f0; z-index: 10;">
                            <div style="width: 6px; height: 6px; border-radius: 50%; background-color: #1d3226;"></div>
                        </div>
                        <div class="w-full md:w-[45%] md:pl-8 order-3" data-aos="fade-left" style="width: 100%;">
                            <div class="glass-card p-6 rounded-2xl border border-white shadow-sm w-full"
                                style="padding: 1.5rem; border-radius: 16px;">
                                <span class="text-xs uppercase tracking-widest text-[#c5a880] font-semibold block mb-1"
                                    style="letter-spacing: 0.1em; display: block; margin-bottom: 0.25rem;">{{ $cerita->tanggal }}</span>
                                <h4 class="font-heading text-xl text-[#1d3226] font-bold mb-2"
                                    style="font-weight: 700; margin-bottom: 0.5rem;">{{ $cerita->judul }}</h4>
                                <p class="text-xs md:text-sm text-[#5a6b5d] font-body leading-relaxed"
                                    style="margin: 0; line-height: 1.6;">{{ $cerita->isi_cerita }}</p>
                            </div>
                        </div>
                        @endif

                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>
        @endif

        <!-- Date & Venue Section -->
        <section id="acara" class="py-24 px-6 text-center relative overflow-hidden"
            style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('themes/aufilla-green/images/bg-hero.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div
                style="position: absolute; inset: 0; background-color: rgba(29, 50, 38, 0.85); backdrop-filter: blur(2px);">
            </div>
            <div class="max-w-[900px] mx-auto relative z-10 text-[#faf6f0]">
                <p data-aos="fade-up" class="text-xs uppercase tracking-[0.3em] text-[#c5a880] mb-2 font-semibold"
                    style="letter-spacing: 0.3em; margin-bottom: 0.5rem;">Save The Date</p>
                <h2 data-aos="fade-up" class="font-heading text-3xl md:text-5xl text-[#faf6f0] font-bold mb-8"
                    style="font-weight: 700; margin-bottom: 2rem;">Hari Bahagia Kami</h2>
                <div data-aos="zoom-in"
                    style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.75rem; max-width: 480px; margin: 0 auto 4rem; padding: 0 1rem;">
                    <div class="glass-card-dark py-4 px-2 rounded-2xl border border-white/10"
                        style="padding: 1rem 0.25rem; border-radius: 16px; display: flex; flex-direction: column; align-items: center;">
                        <span id="days" class="text-3xl md:text-4xl font-semibold text-[#e5c088] font-heading"
                            style="font-weight: 600;">00</span>
                        <span class="text-[10px] md:text-xs uppercase tracking-wider text-[#faf6f0]/70 mt-1"
                            style="opacity: 0.7;">Hari</span>
                    </div>
                    <div class="glass-card-dark py-4 px-2 rounded-2xl border border-white/10"
                        style="padding: 1rem 0.25rem; border-radius: 16px; display: flex; flex-direction: column; align-items: center;">
                        <span id="hours" class="text-3xl md:text-4xl font-semibold text-[#e5c088] font-heading"
                            style="font-weight: 600;">00</span>
                        <span class="text-[10px] md:text-xs uppercase tracking-wider text-[#faf6f0]/70 mt-1"
                            style="opacity: 0.7;">Jam</span>
                    </div>
                    <div class="glass-card-dark py-4 px-2 rounded-2xl border border-white/10"
                        style="padding: 1rem 0.25rem; border-radius: 16px; display: flex; flex-direction: column; align-items: center;">
                        <span id="minutes" class="text-3xl md:text-4xl font-semibold text-[#e5c088] font-heading"
                            style="font-weight: 600;">00</span>
                        <span class="text-[10px] md:text-xs uppercase tracking-wider text-[#faf6f0]/70 mt-1"
                            style="opacity: 0.7;">Menit</span>
                    </div>
                    <div class="glass-card-dark py-4 px-2 rounded-2xl border border-white/10"
                        style="padding: 1rem 0.25rem; border-radius: 16px; display: flex; flex-direction: column; align-items: center;">
                        <span id="seconds" class="text-3xl md:text-4xl font-semibold text-[#e5c088] font-heading"
                            style="font-weight: 600;">00</span>
                        <span class="text-[10px] md:text-xs uppercase tracking-wider text-[#faf6f0]/70 mt-1"
                            style="opacity: 0.7;">Detik</span>
                    </div>
                </div>
                <div class="venue-grid">
                    @if($akad)
                    <div data-aos="fade-up" data-aos-delay="100"
                        class="glass-card-dark border border-white/15 p-8 rounded-[28px]"
                        style="padding: 2rem; border-radius: 28px; max-width: 360px; width: 100%; text-align: left;">
                        <div>
                            <span class="text-xs uppercase tracking-[0.2em] text-[#e5c088] font-semibold block mb-4"
                                style="letter-spacing: 0.2em; display: block; margin-bottom: 1rem;">Akad Nikah</span>
                            <h3 class="font-heading text-2xl font-bold mb-2"
                                style="font-weight: 700; margin-bottom: 0.5rem;">{{ $akad->waktu_mulai ? \Carbon\Carbon::parse($akad->waktu_mulai)->format('H:i') : '' }} - {{ $akad->waktu_selesai ? \Carbon\Carbon::parse($akad->waktu_selesai)->format('H:i') : 'Selesai' }} {{ $akad->zona_waktu ?? 'WIB' }}</h3>
                            <p class="text-xs tracking-wider text-white/60 mb-6 font-body uppercase"
                                style="letter-spacing: 0.05em; margin-bottom: 1.5rem; opacity: 0.6;">
                                {{ $akad && $akad->tgl_acara ? \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l, d F Y') : '' }}
                            </p>
                            <div
                                style="width: 100%; height: 1px; background-color: rgba(255,255,255,0.15); margin: 1rem 0;">
                            </div>
                            <h4 class="font-semibold text-base mb-1"
                                style="font-weight: 600; margin-bottom: 0.25rem;">
                                {{ $akad->lokasi ?? 'Lokasi Akad' }}
                            </h4>
                            <p class="text-xs md:text-sm text-white/70 leading-relaxed mb-6 font-body"
                                style="opacity: 0.7; line-height: 1.5; margin-bottom: 1.5rem; font-size: 0.8rem;">
                                {{ $akad->alamat ?? 'Alamat Akad' }}
                            </p>
                        </div>
                        <div style="display: flex; flex-direction: column; width: 100%;">
                            <a href="{{ $akad->gmaps_link ?? '#' }}" target="_blank" class="btn-gold"
                                style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.8rem; padding: 0.6rem 1.5rem;">
                                <svg viewBox="0 0 24 24" width="16" height="16"
                                    style="width: 16px; height: 16px;" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Petunjuk Lokasi
                            </a>
                        </div>
                    </div>
                    @endif
                    @if($resepsi)
                    <div data-aos="fade-up" data-aos-delay="200"
                        class="glass-card-dark border border-white/15 p-8 rounded-[28px]"
                        style="padding: 2rem; border-radius: 28px; max-width: 360px; width: 100%; text-align: left;">
                        <div>
                            <span class="text-xs uppercase tracking-[0.2em] text-[#e5c088] font-semibold block mb-4"
                                style="letter-spacing: 0.2em; display: block; margin-bottom: 1rem;">Resepsi
                                Pernikahan</span>
                            <h3 class="font-heading text-2xl font-bold mb-2"
                                style="font-weight: 700; margin-bottom: 0.5rem;">{{ $resepsi->waktu_mulai ? \Carbon\Carbon::parse($resepsi->waktu_mulai)->format('H:i') : '' }} - {{ $resepsi->waktu_selesai ? \Carbon\Carbon::parse($resepsi->waktu_selesai)->format('H:i') : 'Selesai' }} {{ $resepsi->zona_waktu ?? 'WIB' }}</h3>
                            <p class="text-xs tracking-wider text-white/60 mb-6 font-body uppercase"
                                style="letter-spacing: 0.05em; margin-bottom: 1.5rem; opacity: 0.6;">
                                {{ $resepsi && $resepsi->tgl_acara ? \Carbon\Carbon::parse($resepsi->tgl_acara)->translatedFormat('l, d F Y') : '' }}
                            </p>
                            <div
                                style="width: 100%; height: 1px; background-color: rgba(255,255,255,0.15); margin: 1rem 0;">
                            </div>
                            <h4 class="font-semibold text-base mb-1"
                                style="font-weight: 600; margin-bottom: 0.25rem;">
                                {{ $resepsi->lokasi ?? 'Lokasi Resepsi' }}
                            </h4>
                            <p class="text-xs md:text-sm text-white/70 leading-relaxed mb-6 font-body"
                                style="opacity: 0.7; line-height: 1.5; margin-bottom: 1.5rem; font-size: 0.8rem;">
                                {{ $resepsi->alamat ?? 'Alamat Resepsi' }}
                            </p>
                        </div>
                        <div style="display: flex; flex-direction: column; width: 100%;">
                            <a href="{{ $resepsi->gmaps_link ?? '#' }}" target="_blank" class="btn-gold"
                                style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.8rem; padding: 0.6rem 1.5rem;">
                                <svg viewBox="0 0 24 24" width="16" height="16"
                                    style="width: 16px; height: 16px;" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                Petunjuk Lokasi
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Digital Gift Section -->
        @if($invitation->is_kado_aktif && ($kados->count() > 0 || $invitation->alamat_kado))
        <section id="gift" class="py-24 px-6 bg-[#faf6f0] text-center relative overflow-hidden"
            style="padding: 6rem 1.5rem;">
            <div class="max-w-[720px] mx-auto relative z-10">
                <p data-aos="fade-up" class="text-xs uppercase tracking-[0.3em] text-[#849687] mb-2 font-semibold"
                    style="letter-spacing: 0.3em; margin-bottom: 0.5rem;">Tanda Kasih</p>
                <h2 data-aos="fade-up" class="font-heading text-3xl md:text-5xl text-[#1d3226] font-bold"
                    style="font-weight: 700;">Dompet & Kado Digital</h2>
                <div class="ornament-divider text-[#c5a880] w-[140px] mx-auto mb-6"
                    style="width: 140px; margin-left: auto; margin-right: auto; margin-bottom: 1.5rem;">&#10022;</div>
                <p data-aos="fade-up"
                    class="text-xs md:text-sm text-[#5a6b5d] max-w-[500px] mx-auto mb-12 leading-relaxed font-body"
                    style="max-w: 500px; margin-bottom: 3rem; line-height: 1.6;">Doa restu Anda merupakan karunia
                    terindah bagi kami. Namun, apabila Anda ingin memberikan tanda kasih secara digital, Anda dapat
                    menyalurkannya melalui rekening berikut:</p>
                <div class="gift-grid">
                    @forelse ($kados as $kado)
                    <div data-aos="flip-up" class="glass-card-gold text-[#2c3930]"
                        style="width: 100%; max-width: 280px; border-radius: 24px; padding: 1.5rem; text-align: left;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                            <span
                                style="font-weight: 700; font-size: 1.125rem; letter-spacing: 0.05em; color: #1d3226;">{{ $kado->nama_bank }}</span>
                            <div
                                style="width: 32px; height: 24px; background-color: rgba(197, 168, 128, 0.2); border-radius: 6px; border: 1px solid rgba(197, 168, 128, 0.4); display: flex; align-items: center; justify-content: center;">
                            </div>
                        </div>
                        <p class="text-[10px] uppercase tracking-widest text-[#2c3930]/60 mb-1"
                            style="font-size: 10px; opacity: 0.6;">Nomor Rekening</p>
                        <h4 class="font-heading text-xl font-semibold tracking-widest text-[#1d3226] mb-4"
                            style="font-weight: 600; letter-spacing: 0.1em; margin-bottom: 1rem;">
                            {{ $kado->no_rekening }}
                        </h4>
                        <p class="text-[9px] uppercase tracking-wider text-[#2c3930]/60 mb-4"
                            style="font-size: 9px; opacity: 0.6; margin-bottom: 1rem;">A.N.
                            {{ $kado->nama_pemilik }}
                        </p>
                        <button
                            onclick="copyToClipboard('{{ $kado->no_rekening }}', '{{ $kado->nama_bank }}')"
                            class="btn-gold"
                            style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.75rem; padding: 0.5rem 1rem;">
                            <svg viewBox="0 0 24 24" width="14" height="14"
                                style="width: 14px; height: 14px;" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="9" y="9" width="13" height="13" rx="2" ry="2">
                                </rect>
                                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                            </svg>
                            Salin Rekening
                        </button>
                    </div>
                    @empty
                    @endforelse
                </div>
                @if ($invitation->alamat_kado)
                <div data-aos="fade-up" class="glass-card"
                    style="margin-top: 3rem; padding: 1.5rem; max-width: 500px; margin-left: auto; margin-right: auto; border-radius: 16px; text-align: left;">
                    <h4 class="font-heading text-lg font-bold text-[#1d3226] mb-2"
                        style="font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg viewBox="0 0 24 24" width="20" height="20"
                            style="width: 20px; height: 20px;" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="20 12 20 22 4 22 4 12"></polyline>
                            <rect x="2" y="7" width="20" height="5"></rect>
                            <line x1="12" y1="22" x2="12" y2="7"></line>
                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                        </svg>
                        Kado Fisik (Alamat Pengiriman)
                    </h4>
                    <p id="alamat-pengiriman" class="text-xs text-[#5a6b5d] mb-4 leading-relaxed font-body"
                        style="line-height: 1.5; margin-bottom: 1rem; font-size: 0.8rem;">
                        {{ $invitation->alamat_kado }}
                    </p>
                    <button onclick="copyAddressToClipboard('{{ $invitation->alamat_kado }}')"
                        class="btn-outline-gold"
                        style="padding: 0.5rem 1rem; font-size: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                        <svg viewBox="0 0 24 24" width="14" height="14"
                            style="width: 14px; height: 14px;" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2">
                            </rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        Salin Alamat Kirim
                    </button>
                </div>
                @endif
            </div>
        </section>
        @endif

        <!-- RSVP & Wishes Wall Section -->
        <section id="rsvp" class="py-24 px-6 text-center relative overflow-hidden"
            style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('themes/aufilla-green/images/bg-hero.svg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
            <div
                style="position: absolute; inset: 0; background-color: rgba(250, 246, 240, 0.92); backdrop-filter: blur(2px);">
            </div>
            <div class="max-w-[900px] mx-auto relative z-10">
                <div class="rsvp-grid">
                    <!-- Form RSVP Card -->
                    <div data-aos="fade-right"
                        class="glass-card border border-white p-8 rounded-3xl shadow-lg text-left"
                        style="padding: 2rem; border-radius: 24px; text-align: left;">
                        <span class="text-xs uppercase tracking-widest text-[#849687] font-semibold block mb-2"
                            style="letter-spacing: 0.1em; display: block; margin-bottom: 0.25rem;">Kehadiran</span>
                        <h3 class="font-heading text-2xl md:text-3xl text-[#1d3226] font-bold mb-4"
                            style="font-weight: 700; margin-bottom: 1rem;">Konfirmasi Kehadiran</h3>
                        <p class="text-xs text-[#5a6b5d] mb-6 leading-relaxed font-body"
                            style="line-height: 1.5; margin-bottom: 1.5rem; font-size: 0.8rem;">
                            Mohon konfirmasikan kehadiran Anda untuk mempermudah persiapan kami.
                        </p>
                        <form id="rsvp-form" style="display: flex; flex-direction: column; gap: 1rem;">
                            <div>
                                <label for="rsvp-name"
                                    class="block text-xs font-semibold text-[#2c3930]/80 mb-1 font-body"
                                    style="display: block; font-size: 0.75rem; margin-bottom: 0.25rem; font-weight: 600;">Nama
                                    Lengkap</label>
                                <input type="text" id="rsvp-name" name="nama" required
                                    class="w-full bg-white/50 border border-[#c5a880]/30 rounded-xl px-4 py-3 outline-none focus:border-[#c5a880] focus:ring-1 focus:ring-[#c5a880] transition-all"
                                    placeholder="Masukkan nama lengkap Anda" value="{{ $nama_tamu_display }}">
                            </div>
                            <div>
                                <label for="rsvp-status"
                                    class="block text-xs font-semibold text-[#2c3930]/80 mb-1 font-body"
                                    style="display: block; font-size: 0.75rem; margin-bottom: 0.25rem; font-weight: 600;">Konfirmasi</label>
                                <select id="rsvp-status" required
                                    style="width: 100%; padding: 0.6rem 1rem; border-radius: 12px; border: 1px solid rgba(197, 168, 128, 0.4); background-color: rgba(255,255,255,0.7); outline: none; font-size: 0.85rem; height: 38px;">
                                    <option value="" disabled selected>Pilih kehadiran...</option>
                                    <option value="Hadir">Ya, Saya Akan Hadir</option>
                                    <option value="Tidak Hadir">Maaf, Saya Tidak Bisa Hadir</option>
                                </select>
                            </div>
                            <div>
                                <label for="rsvp-guests"
                                    class="block text-xs font-semibold text-[#2c3930]/80 mb-1 font-body"
                                    style="display: block; font-size: 0.75rem; margin-bottom: 0.25rem; font-weight: 600;">Jumlah
                                    Pax / Tamu</label>
                                <select id="rsvp-guests"
                                    style="width: 100%; padding: 0.6rem 1rem; border-radius: 12px; border: 1px solid rgba(197, 168, 128, 0.4); background-color: rgba(255,255,255,0.7); outline: none; font-size: 0.85rem; height: 38px;">
                                    <option value="1">1 Orang</option>
                                    <option value="2">2 Orang</option>
                                    <option value="3">3 Orang</option>
                                </select>
                            </div>
                            <div>
                                <label for="rsvp-message"
                                    class="block text-xs font-semibold text-[#2c3930]/80 mb-1 font-body"
                                    style="display: block; font-size: 0.75rem; margin-bottom: 0.25rem; font-weight: 600;">Ucapan
                                    Selamat & Doa</label>
                                <textarea id="rsvp-message" rows="3" required
                                    placeholder="Tulis ucapan selamat dan doa terbaik Anda di sini..."
                                    style="width: 100%; padding: 0.6rem 1rem; border-radius: 12px; border: 1px solid rgba(197, 168, 128, 0.4); background-color: rgba(255,255,255,0.7); outline: none; font-size: 0.85rem; resize: vertical;"></textarea>
                            </div>
                            <button type="submit" class="btn-gold cursor-pointer"
                                style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.65rem 1.5rem;">
                                <svg viewBox="0 0 24 24" width="16" height="16"
                                    style="width: 16px; height: 16px; transform: rotate(45deg);" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                </svg>
                                Kirim Konfirmasi
                            </button>
                        </form>
                    </div>

                    <!-- Wishes Wall Card -->
                    <div data-aos="fade-left" class="flex flex-col h-full justify-between"
                        style="display: flex; flex-direction: column; justify-content: space-between; text-align: left; width: 100%;">
                        <div>
                            <span class="text-xs uppercase tracking-widest text-[#849687] font-semibold block mb-2"
                                style="letter-spacing: 0.15em; display: block; margin-bottom: 0.25rem;">Buku
                                Tamu</span>
                            <h3 class="font-heading text-2xl md:text-3xl text-[#1d3226] font-bold mb-4"
                                style="font-weight: 700; margin-bottom: 1rem;">Untaian Doa & Restu</h3>
                            <p class="text-xs text-[#5a6b5d] mb-6 leading-relaxed font-body"
                                style="line-height: 1.5; margin-bottom: 1.5rem; font-size: 0.8rem;">Berikut pesan, doa
                                restu, dan ucapan bahagia yang dikirimkan oleh keluarga serta sahabat terdekat:</p>
                            <div id="wishes-wall"
                                style="display: flex; flex-direction: column; gap: 1rem; max-height: 320px; overflow-y: auto; padding-right: 0.5rem;">
                                @forelse($wishes as $wish)
                                <div
                                    style="padding: 1rem; border-radius: 16px; background-color: rgba(255,255,255,0.6); border: 1px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                        <div>
                                            <h5 style="font-weight: 600; font-size: 0.85rem; margin: 0; color: #1d3226;">
                                                {{ $wish->nama }} <span class="text-xs text-[#c5a880] font-normal ml-1">({{ $wish->kehadiran == 'hadir' ? 'Hadir' : ($wish->kehadiran == 'tidak' ? 'Tidak Hadir' : 'Masih Ragu') }})</span>
                                            </h5>
                                        </div>
                                        <span
                                            style="font-size: 9px; color: #849687;">{{ $wish->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p
                                        style="font-size: 0.8rem; color: #5a6b5d; font-style: italic; margin: 0; line-height: 1.4;">
                                        "{{ $wish->pesan }}"</p>
                                </div>
                                @empty
                                <p style="font-size: 0.8rem; color: #849687; text-align: center;">Belum ada ucapan.
                                    Jadilah yang pertama!</p>
                                @endforelse
                            </div>
                            <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(197, 168, 128, 0.2); display: flex; justify-content: space-between; align-items: center;"
                                class="font-body">
                                <span style="font-size: 0.75rem; font-weight: 600; color: #2c3930;">Total Ucapan</span>
                                <span id="wishes-count"
                                    style="background-color: #1d3226; color: #faf6f0; padding: 2px 8px; border-radius: 9999px; font-size: 0.7rem;">{{ $wishes->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Closing Footer -->
        <section
            style="position: relative; padding: 5rem 1.5rem; background-color: #1d3226; text-align: center; color: #faf6f0; overflow: hidden;">
            <div style="position: absolute; top: 0; left: 0; width: 100%; overflow: hidden; line-height: 0;">
                <svg viewBox="0 0 1200 120" style="position: relative; display: block; width: 100%; height: 40px;"
                    preserveAspectRatio="none">
                    <path
                        d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                        fill="#faf6f0" opacity=".08"></path>
                </svg>
            </div>
            <div class="max-w-[600px] mx-auto relative z-10" data-aos="fade-up"
                style="position: relative; z-index: 10;">
                <div
                    style="font-size: 1.5rem; color: rgba(197, 168, 128, 0.7); margin-bottom: 1rem; letter-spacing: 0.2em;">
                    &#10022; &#10022; &#10022;</div>
                <p
                    style="font-size: 0.95rem; opacity: 0.8; line-height: 1.6; margin-bottom: 1.5rem; font-style: italic;">
                    Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan
                    memberikan doa restu bagi persatuan suci kami.
                </p>
                <p
                    style="font-size: 0.75rem; letter-spacing: 0.15em; color: #c5a880; font-weight: 600; margin-bottom: 2rem;">
                    WASSALAMU'ALAIKUM WARAHMATULLAHI WABARAKATUH</p>
                <h2 class="font-heading text-3xl md:text-4xl text-[#faf6f0] font-bold mb-2"
                    style="font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.05em;">
                    {{ $invitation->wanita_nama_lengkap }} & {{ $invitation->pria_nama_lengkap }}
                </h2>
                <div style="width: 80px; height: 1px; background-color: rgba(197,168,128,0.3); margin: 1rem auto;">
                </div>
                <p
                    style="font-size: 0.75rem; letter-spacing: 0.25em; color: #c5a880; font-weight: 600; margin-bottom: 2rem;">
                    {{ $akad ? \Carbon\Carbon::parse($akad->tgl_acara)->format('d F Y') : '' }}
                </p>
                <div
                    style="margin-top: 3rem; font-size: 9px; opacity: 0.4; letter-spacing: 0.1em; text-transform: uppercase;">
                    &copy; {{ date('Y') }} {{ $invitation->wanita_nama_lengkap }} &
                    {{ $invitation->pria_nama_lengkap }} Wedding. All Rights Reserved.
                </div>
            </div>
        </section>


    </main>

    <script src="{{ asset('themes/aufilla-green/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            offset: 50
        });

        // Parse guest name from URL
        function parseGuestName() {
            const urlParams = new URLSearchParams(window.location.search);
            let guestName = urlParams.get('to') || urlParams.get('guest');
            if (guestName) {
                guestName = decodeURIComponent(guestName.replace(/\+/g, ' '));
                let guestNameEl = document.getElementById('guest-name');
                if (guestNameEl) guestNameEl.innerText = guestName;

                let rsvpNameEl = document.getElementById('rsvp-name');
                if (rsvpNameEl) rsvpNameEl.value = guestName;
            }
        }
        parseGuestName();

        // Open Invitation
        const openBtn = document.getElementById('open-invitation-btn');
        const splashScreen = document.getElementById('splash-screen');
        const mainContent = document.getElementById('main-content');
        const bgMusic = document.getElementById('background-music');
        const musicBtn = document.getElementById('music-btn');
        const floatingNav = document.getElementById('floating-nav');
        let isMusicPlaying = false;

        openBtn.addEventListener('click', function() {
            splashScreen.classList.add('hidden-splash');
            mainContent.classList.add('visible');
            bgMusic.play().then(() => {
                isMusicPlaying = true;
                musicBtn.classList.remove('hidden');
                musicBtn.classList.add('playing');
            }).catch(() => {
                musicBtn.classList.remove('hidden');
            });
            setTimeout(() => {
                floatingNav.classList.add('visible');
            }, 1200);
            setTimeout(() => {
                splashScreen.style.display = 'none';
            }, 1300);
        });

        musicBtn.addEventListener('click', function() {
            if (isMusicPlaying) {
                bgMusic.pause();
                musicBtn.classList.remove('playing');
                isMusicPlaying = false;
            } else {
                bgMusic.play();
                musicBtn.classList.add('playing');
                isMusicPlaying = true;
            }
        });

        // Countdown
        const weddingDate = new Date(
            '{{ $akad && $akad->tgl_acara ? \Carbon\Carbon::parse($akad->tgl_acara)->format("Y-m-d") : "2026-05-26" }}T{{ $akad && $akad->waktu_mulai ? \Carbon\Carbon::parse($akad->waktu_mulai)->format("H:i:s") : "08:00:00" }}'
        ).getTime();
        setInterval(function() {
            const now = new Date().getTime();
            const distance = weddingDate - now;
            document.getElementById('days').innerText = Math.floor(distance / (1000 * 60 * 60 * 24)).toString()
                .padStart(2, '0');
            document.getElementById('hours').innerText = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 *
                60 * 60)).toString().padStart(2, '0');
            document.getElementById('minutes').innerText = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))
                .toString().padStart(2, '0');
            document.getElementById('seconds').innerText = Math.floor((distance % (1000 * 60)) / 1000).toString()
                .padStart(2, '0');
        }, 1000);

        // Gold particles
        function createGoldParticles() {
            const body = document.body;
            setInterval(function() {
                if (splashScreen.style.display === 'none') {
                    const leaf = document.createElement('div');
                    leaf.className = 'floating-leaf';
                    leaf.style.left = Math.random() * 100 + 'vw';
                    leaf.style.top = '-20px';
                    const size = Math.random() * 8 + 6;
                    leaf.style.width = size + 'px';
                    leaf.style.height = size + 'px';
                    leaf.style.backgroundColor = Math.random() > 0.5 ? '#d4af37' : '#c5a880';
                    leaf.style.borderRadius = '50% 0 50% 50%';
                    leaf.style.boxShadow = '0 0 6px rgba(212, 175, 55, 0.4)';
                    leaf.style.opacity = Math.random() * 0.4 + 0.3;
                    const duration = Math.random() * 8 + 10;
                    leaf.style.animationDuration = duration + 's';
                    body.appendChild(leaf);
                    setTimeout(() => leaf.remove(), duration * 1000);
                }
            }, 1200);
        }
        createGoldParticles();

        // Copy to clipboard
        function copyToClipboard(text, provider) {
            navigator.clipboard.writeText(text).then(() => {
                showToast(`Nomor Rekening ${provider.toUpperCase()} Berhasil Disalin!`);
            }).catch(err => console.error('Failed to copy:', err));
        }

        function copyAddressToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                showToast("Alamat Pengiriman Berhasil Disalin!");
            }).catch(err => console.error('Failed to copy:', err));
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.innerText = message;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2500);
        }

        // AJAX RSVP Submission
        $('#rsvp-form').on('submit', function(e) {
            e.preventDefault();
            const formData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                invitation_id: '{{ $invitation->id }}',
                name: $('#rsvp-name').val(),
                is_attending: $('#rsvp-status').val() === 'Hadir' ? 1 : 0,
                message: $('#rsvp-message').val()
            };

            $.ajax({
                url: '{{ route("public.ucapan.store", $invitation->slug) }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    showToast(response.message || 'Konfirmasi berhasil dikirim!');
                    $('#rsvp-status').val('');
                    $('#rsvp-guests').val('1');
                    $('#rsvp-message').val('');

                    // Prepend new wish
                    if (response.wish) {
                        const card = `
                            <div style="padding: 1rem; border-radius: 16px; background-color: rgba(255,255,255,0.6); border: 1px solid #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                    <h4 style="font-weight: 700; font-size: 0.85rem; color: #1d3226;">${response.wish.nama}</h4>
                                    <span style="font-size: 0.65rem; color: #849687;">${response.wish.created_at}</span>
                                </div>
                                <p style="font-size: 0.8rem; color: #5a6b5d; font-style: italic; margin: 0; line-height: 1.4;">"${formData.message}"</p>
                            </div>
                        `;
                        $('#wishes-wall').prepend(card);

                        let countElem = $('#wishes-count');
                        if (countElem.length) {
                            countElem.text(parseInt(countElem.text()) + 1);
                        }
                    }
                },
                error: function(xhr) {
                    const msg = xhr.responseJSON?.message || 'Gagal mengirim konfirmasi.';
                    showToast(msg);
                }
            });
        });
    </script>
</body>

</html>