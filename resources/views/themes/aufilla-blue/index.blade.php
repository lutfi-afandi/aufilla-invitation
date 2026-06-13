<!doctype html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Undangan Pernikahan: {{ $invitation->pria_nama }} & {{ $invitation->wanita_nama }}</title>

  <!-- Meta Data & Open Graph untuk WhatsApp / Sosmed -->
  <meta name="description" content="Kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pernikahan kami.">
  <meta property="og:title" content="Undangan Pernikahan: {{ $invitation->pria_nama }} & {{ $invitation->wanita_nama }}">
  <meta property="og:description" content="Kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pernikahan kami.">
  <meta property="og:image" content="{{ route('og-image', $invitation->id) }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">

  <!-- Local Google Fonts -->
  <link href="{{ asset('assets/vendor/css/fonts.css') }}" rel="stylesheet">

  <!-- Local Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('assets/vendor/css/fontawesome.min.css') }}" />

  <!-- Local AOS CSS -->
  <link href="{{ asset('assets/vendor/css/aos.css') }}" rel="stylesheet">

  <!-- Local Tailwind CSS -->
  <script src="{{ asset('assets/vendor/js/tailwindcss.min.js') }}"></script>

  <!-- Tailwind Custom Configuration -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            royal: {
              50: '#F4F7FC',
              100: '#E7ECF6',
              200: '#CAD6EA',
              300: '#A7B7D9',
              400: '#7B8FBF',
              500: '#4B5F9E',
              600: '#384B7F',
              700: '#28335A',
              800: '#1D2646', // Base Royal Blue
              900: '#12182E', // Deep Royal Blue
              950: '#0A0F1E',
            },
            burgundy: '#6B2737',
            gold: {
              50: '#FEFBF0',
              100: '#FDF6D9',
              200: '#F9EBAC',
              300: '#F4DC7D',
              400: '#EECD4F',
              500: '#D4AF37', // Gold Metallic Accent
              600: '#B08E27',
              700: '#8A6D1B',
              800: '#644F13',
              900: '#4D3B0D',
            },
            cream: {
              50: '#FAF8F5',
              100: '#F7F2EC', // Premium Background
              200: '#EFE7DC',
              300: '#DECDBD',
              450: '#CCAFAA',
            },
          },
          fontFamily: {
            serif: ['Cormorant Garamond', 'Georgia', 'serif'],
            sans: ['Poppins', 'Helvetica Neue', 'Arial', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <!-- Custom CSS Tweaks -->
  <style>
    html {
      scroll-behavior: smooth;
    }

    /* Premium custom scrollbars */
    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #F7F2EC;
    }

    ::-webkit-scrollbar-thumb {
      background: #1D2646;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #C5A031;
    }

    /* Spin-slow custom classes for music note/disc */
    @keyframes spin-slow {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .animate-spin-slow {
      animation: spin-slow 12s linear infinite;
    }

    /* Glow & elegant border frames */
    .gold-border-glow {
      box-shadow: 0 0 15px rgba(212, 175, 55, 0.25);
    }

    /* Glassmorphism utility card */
    .glass-premium {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(212, 175, 55, 0.2);
    }

    .glass-dark {
      background: rgba(29, 38, 70, 0.85);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(212, 175, 55, 0.3);
    }

    /* Gold floral ornaments absolute background masking */
    .bg-wedding-foliage {
      background-image: radial-gradient(rgba(212, 175, 55, 0.08) 1.5px, transparent 1.5px);
      background-size: 24px 24px;
    }

    /* Floating item indicator animation */
    @keyframes float-gentle {
      0% {
        transform: translateY(0px) rotate(0deg);
      }

      50% {
        transform: translateY(-8px) rotate(2deg);
      }

      100% {
        transform: translateY(0px) rotate(0deg);
      }
    }

    .float-gentle {
      animation: float-gentle 6s ease-in-out infinite;
    }

    /* Standard fade & unlock controls */
    body.locked {
      overflow: hidden;
    }
  </style>
</head>

<body class="font-sans text-stone-800 bg-[#F7F2EC] relative selection:bg-royal-800 selection:text-white locked">

  <!-- 1. LOADING SCREEN -->
  <div id="loading-screen" class="fixed inset-0 bg-[#1D2646] z-[99] flex flex-col justify-center items-center transition-all duration-700 ease-out">
    <div class="flex flex-col items-center">
      <!-- Floating circular ornaments -->
      <div class="relative w-24 h-24 flex items-center justify-center">
        <div class="absolute inset-0 border-2 border-gold-500/30 border-t-gold-500 rounded-full animate-spin"></div>
        <span class="font-serif text-3xl font-bold text-gold-500 relative z-10 leading-none">{{ strtoupper(substr($invitation->pria_nama, 0, 1)) }}&amp;{{ strtoupper(substr($invitation->wanita_nama, 0, 1)) }}</span>
      </div>
      <p class="font-serif text-amber-200 mt-6 tracking-widest uppercase text-sm animate-pulse-gentle">Bahagia Marayakan Cinta...</p>
    </div>
  </div>





  <!-- 3. PREMIUM DESKTOP LAYOUT (SPLIT PANEL: left background fixed, right scrollable) -->
  <div class="min-h-screen lg:flex lg:h-[calc(100vh-2rem)] lg:m-4 lg:rounded-2xl lg:border-[12px] lg:border-[#1D2646] lg:outline lg:outline-[2px] lg:outline-[#D4AF37] lg:outline-offset-[-12px] lg:shadow-2xl lg:overflow-hidden relative bg-[#F7F2EC]">

    <!-- 2. COVER SCREEN OVERLAY (FADE OUT UPON CLICKING "BUKA UNDANGAN") -->
    <div id="cover-screen" class="fixed lg:absolute inset-0 lg:left-auto lg:w-[480px] lg:right-0 z-50 flex items-center justify-center transition-all duration-1000 ease-in-out bg-cover bg-center"
      style="background-image: linear-gradient(to bottom, rgba(18, 24, 46,0.85) 0%, rgba(29,38,70,0.9) 60%, rgba(10, 15, 30,0.95) 100%), url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}');">
      <!-- Ornaments -->
      <div class="absolute inset-0 bg-wedding-foliage opacity-20"></div>

      <!-- Top Left/Right Gilded Flowers -->
      <div class="absolute top-0 left-0 w-32 h-32 md:w-48 md:h-48 border-l-4 border-t-4 border-gold-500/20 m-6 rounded-tl-3xl"></div>
      <div class="absolute bottom-0 right-0 w-32 h-32 md:w-48 md:h-48 border-r-4 border-b-4 border-gold-500/20 m-6 rounded-br-3xl"></div>

      <!-- Core Display Content -->
      <div class="max-w-md w-full px-6 text-center z-10 flex flex-col items-center">

        <!-- Elegant Wedding Motif -->
        <div class="mb-4 text-gold-500 float-gentle">
          <svg class="w-16 h-16 mx-auto fill-current" viewBox="0 0 100 100">
            <!-- Simulated gold line art branch ornament -->
            <path d="M50 15 C45 30 35 40 15 50 C35 60 45 70 50 85 C55 70 65 60 85 50 C65 40 55 30 50 15 Z" />
            <circle cx="50" cy="50" r="10" class="stroke-gold-400 fill-none stroke-2" />
          </svg>
        </div>

        <p class="font-serif text-amber-200 text-xs md:text-sm tracking-[0.25em] uppercase mb-3 text-shadow">UNDANGAN PERNIKAHAN</p>

        <h1 class="font-serif text-5xl md:text-6xl text-white font-bold leading-tight tracking-wide mb-2 drop-shadow-lg">
          {{ $invitation->pria_nama }} <span class="font-serif text-gold-500 block md:inline text-3xl md:text-5xl my-1 md:my-0 font-normal">&amp;</span> {{ $invitation->wanita_nama }}
        </h1>

        @if($akad)
        <p class="text-stone-200 text-xs md:text-sm tracking-wide mt-2 mb-8 font-semibold uppercase tracking-widest bg-black/10 px-4 py-1.5 rounded-full backdrop-blur-xs">
          {{ \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l, d F Y') }}
        </p>
        @endif

        <!-- Guest dynamic tag container -->
        <div class="w-full bg-[#1D2646]/75 backdrop-blur-md border border-gold-500/30 p-6 rounded-2xl mb-8 gold-border-glow shadow-xl animate-fade-in">
          <p class="text-amber-200/80 text-xs tracking-widest uppercase mb-2">Kepada Yth. Bapak/Ibu/Saudara/i</p>
          <h2 id="guest-name-cover" class="font-serif text-2xl font-semibold text-white tracking-wide truncate max-w-full">
            {{ request('to') ? ucwords(str_replace('-', ' ', request('to'))) : 'Tamu Terhormat' }}
          </h2>
          <div class="w-12 h-[1px] bg-gold-400 mx-auto my-3"></div>
          <p class="text-[11px] text-stone-300 italic">*Mohon maaf apabila ada kesalahan penulisan nama/gelar</p>
        </div>

        <!-- Pulse trigger button -->
        <button id="btn-open-invitation" class="relative group inline-flex items-center gap-3 bg-gradient-to-r from-gold-600 via-gold-500 to-gold-600 hover:from-gold-500 hover:to-gold-600 text-[#12182E] font-semibold tracking-widest uppercase text-xs px-8 py-4 rounded-full shadow-2xl border-2 border-amber-300/50 transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer">
          <i class="fa-solid fa-envelope-open text-sm animate-bounce"></i>
          <span>Buka Undangan</span>
        </button>

      </div>
    </div>

    <!-- LEFT COLUMN: Desktop Premium Backdrop Static (Only visible on lg screens) -->
    <div class="hidden lg:flex lg:flex-1 lg:h-full bg-gradient-to-br from-[#12182E] to-[#1D2646] p-16 flex-col justify-between relative bg-cover bg-center overflow-hidden"
      style="background-image: linear-gradient(135deg, rgba(18, 24, 46,0.92) 0%, rgba(29,38,70,0.85) 100%), url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}');">

      <div class="absolute inset-0 bg-wedding-foliage opacity-15"></div>

      <!-- Frame border aesthetics -->
      <div class="absolute inset-8 border border-gold-500/20 pointer-events-none rounded-xl"></div>
      <div class="absolute inset-10 border-2 border-gold-500/10 pointer-events-none rounded-lg"></div>

      <!-- Floating corner arches -->
      <div class="absolute top-12 left-12 w-20 h-20 border-t border-l border-gold-500/40 rounded-tl-xl"></div>
      <div class="absolute bottom-12 right-12 w-20 h-20 border-b border-r border-gold-500/40 rounded-br-xl"></div>

      <!-- Logo / Intro Header -->
      <div class="z-10 bg-black/10 backdrop-blur-xs p-4 rounded-lg inline-self-start">
        <span class="font-serif text-gold-500 text-lg tracking-widest uppercase block mb-1">UNDANGAN PERNIKAHAN</span>
        <p class="text-[11px] text-stone-300 tracking-wider">THE WEDDING OF {{ strtoupper($invitation->pria_nama) }} &amp; {{ strtoupper($invitation->wanita_nama) }}</p>
      </div>

      <!-- Large names & countdown -->
      <div class="z-10 my-auto text-left">
        <span class="font-serif text-amber-200 text-sm tracking-widest uppercase block mb-2">PERNIKAHAN IMPIAN</span>
        <h2 class="font-serif text-6xl xl:text-7xl font-bold leading-tight text-white mb-4">
          {{ $invitation->pria_nama }} <br>
          <span class="font-light text-gold-500 text-4xl xl:text-5xl font-serif block my-1">&amp;</span>
          {{ $invitation->wanita_nama }}
        </h2>
        <div class="w-32 h-[2px] bg-gradient-to-r from-gold-500 to-transparent mb-6"></div>

        <div id="desktop-countdown-wrapper" class="flex justify-center gap-3 w-full">
          <div class="text-center w-20 py-3 rounded-xl bg-[#1D2646]/80 border border-[#D4AF37]/30 shadow-md">
            <span id="dt-days" class="font-serif text-3xl font-bold text-gold-500 block">00</span>
            <span class="text-[9px] text-[#FDF6D9]/80 uppercase tracking-widest">Hari</span>
          </div>
          <div class="text-center w-20 py-3 rounded-xl bg-[#1D2646]/80 border border-[#D4AF37]/30 shadow-md">
            <span id="dt-hours" class="font-serif text-3xl font-bold text-gold-500 block">00</span>
            <span class="text-[9px] text-[#FDF6D9]/80 uppercase tracking-widest">Jam</span>
          </div>
          <div class="text-center w-20 py-3 rounded-xl bg-[#1D2646]/80 border border-[#D4AF37]/30 shadow-md">
            <span id="dt-minutes" class="font-serif text-3xl font-bold text-gold-500 block">00</span>
            <span class="text-[9px] text-[#FDF6D9]/80 uppercase tracking-widest">Menit</span>
          </div>
          <div class="text-center w-20 py-3 rounded-xl bg-[#1D2646]/80 border border-[#D4AF37]/30 shadow-md">
            <span id="dt-seconds" class="font-serif text-3xl font-bold text-gold-500 block">00</span>
            <span class="text-[9px] text-[#FDF6D9]/80 uppercase tracking-widest">Detik</span>
          </div>
        </div>
      </div>

      <!-- Bottom details on Left Column -->
      <div class="z-10 flex justify-between items-end text-white">
        <div>
          @if($resepsi)
          <p class="font-serif text-amber-200 text-base">{{ $resepsi->tempat }}</p>
          <p class="text-xs text-stone-300">{{ \Carbon\Carbon::parse($resepsi->tgl_acara)->translatedFormat('l, d F Y') }}</p>
          @endif
        </div>
        <div class="text-right text-stone-400 text-xs">
          <span class="text-white"><i class="fa-solid fa-music mr-1 text-gold-500"></i> From Aufilla</span>
        </div>
      </div>

    </div>


    <!-- RIGHT COLUMN: Scrolling Full Invitation Content Panel (Visible everywhere) -->
    <div id="right-pane" class="w-full lg:w-[480px] lg:min-w-[480px] lg:shrink-0 min-h-screen lg:h-full lg:overflow-y-auto bg-cream-100 overflow-x-hidden relative shadow-2xl mx-auto">

      <!-- A: HERO HEADER (ANCHOR) -->
      <section id="hero" class="relative min-h-screen flex flex-col justify-center items-center py-20 px-6 text-center select-none bg-[#F7F2EC] overflow-hidden">

        <div class="absolute inset-0 bg-wedding-foliage opacity-15"></div>

        <!-- Gilded circular framing for Hero block -->
        <div class="absolute top-10 left-10 w-24 h-24 border-t-2 border-l-2 border-gold-500/20 rounded-tl-full pointer-events-none"></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 border-b-2 border-r-2 border-gold-500/20 rounded-br-full pointer-events-none"></div>

        <!-- Welcome Banner Text -->
        <div data-aos="fade-down" data-aos-duration="1000" class="mb-4">
          <span class="font-serif text-gold-600 text-xs tracking-[0.25em] uppercase block mb-1">Undangan Pernikahan</span>
          <div class="w-16 h-[1px] bg-gold-500 mx-auto"></div>
        </div>

        <!-- Hero Main Couple Image -->
        <div data-aos="zoom-in" data-aos-duration="1200" class="relative w-64 h-64 md:w-72 md:h-72 mx-auto my-8">
          <!-- Gilded frame backing -->
          <div class="absolute inset-[-10px] border border-gold-500 rounded-full animate-spin-slow opacity-60"></div>
          <div class="absolute inset-[-4px] border-2 border-gold-600 rounded-full"></div>

          <!-- Standard round portrait mask -->
          <div class="w-full h-full rounded-full overflow-hidden shadow-2xl gold-border-glow select-none bg-white">
            <img src="{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}"
              alt="{{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}"
              class="w-full h-full object-cover scale-105 hover:scale-110 transition-transform duration-700"
              referrerpolicy="no-referrer">
          </div>

          <!-- Absolute golden hanging leaves badge -->
          <div class="absolute bottom-1 -right-2 bg-gradient-to-br from-royal-800 to-burgundy border-2 border-gold-500 text-white rounded-full p-3 shadow-xl flex items-center justify-center w-12 h-12">
            <i class="fa-solid fa-heart text-gold-400"></i>
          </div>
        </div>

        <!-- Names of the couple in Serif -->
        <div data-aos="fade-up" data-aos-duration="1000">
          <h2 class="font-serif text-4xl md:text-5xl font-bold text-royal-800 leading-none">{{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}</h2>
          @if($akad)
          <div class="flex items-center justify-center gap-2 mt-4 text-stone-500 text-xs md:text-sm">
            <span class="uppercase">{{ \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l') }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-gold-500"></span>
            <span class="uppercase">{{ \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('d F Y') }}</span>
            <span class="w-1.5 h-1.5 rounded-full bg-gold-500"></span>
            <span class="uppercase">Di Tempat</span>
          </div>
          @endif
        </div>

        <!-- Countdown Timer Widget for Smart Screen -->
        <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000" class="mt-10 w-full max-w-sm">
          <p class="text-xs text-stone-500 uppercase tracking-[0.2em] mb-4 font-semibold">Menghitung Kisah Indah:</p>
          <div class="grid grid-cols-4 gap-3">
            <div class="bg-[#1D2646] rounded-2xl p-3 border border-[#D4AF37]/35 shadow-md">
              <span id="countdown-days" class="font-serif text-2xl md:text-3xl font-bold text-[#D4AF37] block">00</span>
              <span class="text-[9px] uppercase tracking-wider text-amber-100/80 block font-sans">Hari</span>
            </div>
            <div class="bg-[#1D2646] rounded-2xl p-3 border border-[#D4AF37]/35 shadow-md">
              <span id="countdown-hours" class="font-serif text-2xl md:text-3xl font-bold text-[#D4AF37] block">00</span>
              <span class="text-[9px] uppercase tracking-wider text-amber-100/80 block font-sans">Jam</span>
            </div>
            <div class="bg-[#1D2646] rounded-2xl p-3 border border-[#D4AF37]/35 shadow-md">
              <span id="countdown-minutes" class="font-serif text-2xl md:text-3xl font-bold text-[#D4AF37] block">00</span>
              <span class="text-[9px] uppercase tracking-wider text-amber-100/80 block font-sans">Menit</span>
            </div>
            <div class="bg-[#1D2646] rounded-2xl p-3 border border-[#D4AF37]/35 shadow-md">
              <span id="countdown-seconds" class="font-serif text-2xl md:text-3xl font-bold text-[#D4AF37] block">00</span>
              <span class="text-[9px] uppercase tracking-wider text-amber-100/80 block font-sans">Detik</span>
            </div>
          </div>
        </div>

        <!-- Guest greeting inside right hero for completeness -->
        <div data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000" class="mt-8 text-stone-600 text-xs">
          Selamat datang, <span id="guest-name-hero" class="font-semibold text-royal-800">{{ request('to') ? ucwords(str_replace('-', ' ', request('to'))) : 'Tamu Terhormat' }}</span>. Kami menantikan kehadiran Anda.
        </div>

        <div class="mt-10 self-center animate-bounce text-gold-500 text-lg">
          <i class="fa-solid fa-chevron-down opacity-55"></i>
        </div>

      </section>


      <!-- B: ROMANTIC QUOTE (QS. AR-RUM) -->
      <section id="quote" class="relative py-20 px-6 text-center bg-cream-50 overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-10"></div>

        <div class="max-w-md mx-auto" data-aos="fade-up" data-aos-duration="1200">
          <!-- Custom Gilded Flower Branch Motif -->
          <div class="text-gold-500 text-2xl mb-6">
            <i class="fa-solid fa-leaf"></i>
          </div>

          <!-- Arabic script styled inside a beautiful elegant font size -->
          <p class="font-serif text-2xl md:text-3xl text-royal-900 leading-loose mb-6 tracking-wide" dir="rtl">
            وَمِنْ آيَاتِهِ أَنْ خَلَقَ لَكُمْ مِنْ أَنْفُسِكُمْ أَزْوَاجًا لِتَسْكُنُوا إِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَوَدَّةً وَرَحْمَةً ۚ إِنَّ فِي ذَٰلِكَ لَآيَاتٍ لِقَوْمٍ يَتَفَكَّرُونَ
          </p>

          <blockquote class="text-sm md:text-base text-stone-600 leading-relaxed italic mb-4">
            "Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda bagi kaum yang berpikir."
          </blockquote>

          <cite class="font-serif text-xs md:text-sm tracking-widest text-[#D4AF37] block font-bold uppercase mt-4">
            — QS. Ar-Rum Ayat 21
          </cite>

          <div class="w-16 h-[1.5px] bg-gold-400 mx-auto mt-8"></div>
        </div>
      </section>


      <!-- C: COUPLE DETAILS (ANCHOR) -->
      <section id="couple" class="relative py-24 px-6 bg-[#F7F2EC] overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-15"></div>

        <!-- Section Intro -->
        <div class="text-center max-w-sm mx-auto mb-16" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Mempelai Indah</span>
          <h2 class="font-serif text-4xl font-bold text-royal-800 mb-4">Sepasang Kasih</h2>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
          <p class="text-xs md:text-sm leading-relaxed text-stone-600">
            Assalamu’alaikum Warahmatullahi Wabarakatuh. Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i ke acara pernikahan kami:
          </p>
        </div>

        <!-- Mempelai Grid (Pria & Wanita) with detailed credentials -->
        <div class="max-w-md mx-auto space-y-16">

          <!-- GROOM PROFILE CARD -->
          <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-duration="1200">
            <!-- Groom Styled Frame -->
            <div class="relative w-48 h-48 mb-6">
              <div class="absolute inset-0 border-2 border-gold-500 rounded-2xl rotate-3"></div>
              <div class="absolute inset-0 border border-royal-800 rounded-2xl -rotate-2 bg-cream-50 shadow-md"></div>
              <img src="{{ $invitation->pria_foto ? asset('storage/' . $invitation->pria_foto) : asset('assets/default/default_pria.jpg') }}"
                alt="{{ $invitation->pria_nama_lengkap }}"
                class="w-full h-full object-cover rounded-2xl relative z-10 border border-gold-500/20 bg-white"
                referrerpolicy="no-referrer">
            </div>

            <!-- Details -->
            <h3 class="font-serif text-2xl font-bold text-royal-800 tracking-wide mb-1">
              {{ $invitation->pria_nama_lengkap }}
            </h3>
            <p class="text-[11px] text-[#C5A031] uppercase tracking-[0.2em] font-semibold mb-3">Mempelai Pria</p>

            <div class="w-6 h-[1px] bg-gold-400 my-2"></div>

            <p class="text-xs leading-relaxed text-stone-600 max-w-xs font-sans">
              Putra dari <br>
              <span class="font-semibold text-stone-800">{{ $invitation->pria_ayah }}</span> <br>
              &amp; <span class="font-semibold text-stone-800">{{ $invitation->pria_ibu }}</span>
            </p>
          </div>

          <!-- Heart spacer divider symbol -->
          <div class="flex items-center justify-center gap-4 py-4" data-aos="zoom-in" data-aos-duration="1000">
            <div class="h-[1px] flex-1 bg-gradient-to-r from-transparent to-gold-500/40"></div>
            <span class="text-gold-500 text-lg"><i class="fa-solid fa-heart"></i></span>
            <div class="h-[1px] flex-1 bg-gradient-to-l from-transparent to-gold-500/40"></div>
          </div>

          <!-- BRIDE PROFILE CARD -->
          <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-duration="1200">
            <!-- Bride Styled Frame -->
            <div class="relative w-48 h-48 mb-6">
              <div class="absolute inset-0 border-2 border-gold-500 rounded-2xl -rotate-3"></div>
              <div class="absolute inset-0 border border-royal-800 rounded-2xl rotate-2 bg-cream-50 shadow-md"></div>
              <img src="{{ $invitation->wanita_foto ? asset('storage/' . $invitation->wanita_foto) : asset('assets/default/default_wanita.jpg') }}"
                alt="{{ $invitation->wanita_nama_lengkap }}"
                class="w-full h-full object-cover rounded-2xl relative z-10 border border-gold-500/20 bg-white"
                referrerpolicy="no-referrer">
            </div>

            <!-- Details -->
            <h3 class="font-serif text-2xl font-bold text-royal-800 tracking-wide mb-1">
              {{ $invitation->wanita_nama_lengkap }}
            </h3>
            <p class="text-[11px] text-[#C5A031] uppercase tracking-[0.2em] font-semibold mb-3">Mempelai Wanita</p>

            <div class="w-6 h-[1px] bg-gold-400 my-2"></div>

            <p class="text-xs leading-relaxed text-stone-600 max-w-xs font-sans">
              Putri dari <br>
              <span class="font-semibold text-stone-800">{{ $invitation->wanita_ayah }}</span> <br>
              &amp; <span class="font-semibold text-stone-800">{{ $invitation->wanita_ibu }}</span>
            </p>
          </div>

        </div>
      </section>


      <!-- D: INTERACTIVE EVENTS SECTION (ANCHOR) -->
      <section id="event" class="relative py-24 px-6 bg-cream-50 overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-10"></div>

        <!-- Ornaments -->
        <div class="absolute top-0 right-0 w-24 h-24 border-t-2 border-r-2 border-gold-500/20 m-4 rounded-tr-xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 border-b-2 border-l-2 border-gold-500/20 m-4 rounded-bl-xl pointer-events-none"></div>

        <!-- Section title -->
        <div class="text-center max-w-sm mx-auto mb-16" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Tanggal &amp; Lokasi</span>
          <h2 class="font-serif text-4xl font-bold text-royal-800 mb-3">Momentum Bahagia</h2>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
          <p class="text-xs md:text-sm text-stone-600 leading-relaxed">
            Dengan penuh kebahagiaan, rangkaian acara sakral pernikahan kami akan diselenggarakan pada:
          </p>
        </div>

        <!-- Cards container -->
        <div class="max-w-md mx-auto space-y-10">

          @if($akad)
          <!-- AKAD CARD -->
          <div class="bg-white rounded-3xl border border-gold-500/20 shadow-xl overflow-hidden glass-premium relative" data-aos="fade-up" data-aos-duration="1200">
            <!-- Gilded vertical ribbon edge -->
            <div class="absolute top-0 left-0 bottom-0 w-2 bg-gradient-to-b from-gold-600 to-gold-400"></div>

            <div class="p-8 truncate-normal">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-royal-50 border border-gold-500/30 flex items-center justify-center text-royal-800 text-xl shadow-inner">
                  <i class="fa-solid fa-ring"></i>
                </div>
                <div>
                  <h3 class="font-serif text-2xl font-bold text-royal-800">{{ $akad->nama_acara ?? 'Akad Nikah' }}</h3>
                  <span class="text-[10px] text-stone-500 tracking-wider block uppercase">PROSESI AKAD</span>
                </div>
              </div>

              <div class="w-full h-[1px] bg-stone-100 my-4"></div>

              <div class="space-y-4 text-xs md:text-sm text-stone-600">
                <div class="flex items-start gap-3">
                  <div class="text-gold-600 mt-1"><i class="fa-solid fa-calendar-days"></i></div>
                  <div>
                    <p class="font-semibold text-stone-800">Hari &amp; Tanggal</p>
                    <p>{{ \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l, d F Y') }}</p>
                  </div>
                </div>

                <div class="flex items-start gap-3">
                  <div class="text-gold-600 mt-1"><i class="fa-solid fa-clock"></i></div>
                  <div>
                    <p class="font-semibold text-stone-800">Waktu</p>
                    <p>Pukul {{ substr($akad->waktu_mulai, 0, 5) }} WIB s/d {{ $akad->waktu_selesai ? substr($akad->waktu_selesai, 0, 5) . ' WIB' : 'Selesai' }}</p>
                  </div>
                </div>

                <div class="flex items-start gap-3">
                  <div class="text-gold-600 mt-1"><i class="fa-solid fa-location-dot"></i></div>
                  <div>
                    <p class="font-semibold text-stone-800">Tempat / Lokasi</p>
                    <p class="font-medium text-royal-900">{{ $akad->tempat }}</p>
                    <p class="text-xs text-stone-500">{{ $akad->alamat }}</p>
                  </div>
                </div>
              </div>

              <!-- Google Maps Link Button -->
              <div class="mt-8">
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($akad->tempat . ' ' . $akad->alamat) }}" target="_blank" class="inline-flex items-center justify-center gap-2 w-full bg-royal-800 hover:bg-royal-900 text-white font-medium text-xs tracking-wider uppercase px-6 py-3 rounded-2xl shadow-lg border border-gold-500/25 transition-all duration-300">
                  <i class="fa-solid fa-map-marked-alt text-gold-400"></i>
                  <span>Petunjuk Lokasi Google Maps</span>
                </a>
              </div>
            </div>
          </div>
          @endif

          @if($resepsi)
          <!-- RESEPSI CARD -->
          <div class="bg-white rounded-3xl border border-gold-500/20 shadow-xl overflow-hidden glass-premium relative" data-aos="fade-up" data-aos-duration="1200">
            <!-- Gilded vertical ribbon edge -->
            <div class="absolute top-0 left-0 bottom-0 w-2 bg-gradient-to-b from-royal-900 via-royal-800 to-[#6B2737]"></div>

            <div class="p-8">
              <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-2xl bg-royal-50 border border-gold-500/30 flex items-center justify-center text-royal-800 text-xl shadow-inner">
                  <i class="fa-solid fa-champagne-glasses"></i>
                </div>
                <div>
                  <h3 class="font-serif text-2xl font-bold text-royal-800">{{ $resepsi->nama_acara ?? 'Resepsi Pernikahan' }}</h3>
                  <span class="text-[10px] text-stone-500 tracking-wider block uppercase font-sans">PERAYAAN</span>
                </div>
              </div>

              <div class="w-full h-[1px] bg-stone-100 my-4"></div>

              <div class="space-y-4 text-xs md:text-sm text-stone-600">
                <div class="flex items-start gap-3">
                  <div class="text-gold-600 mt-1"><i class="fa-solid fa-calendar-days"></i></div>
                  <div>
                    <p class="font-semibold text-stone-800">Hari &amp; Tanggal</p>
                    <p>{{ \Carbon\Carbon::parse($resepsi->tgl_acara)->translatedFormat('l, d F Y') }}</p>
                  </div>
                </div>

                <div class="flex items-start gap-3">
                  <div class="text-gold-600 mt-1"><i class="fa-solid fa-clock"></i></div>
                  <div>
                    <p class="font-semibold text-stone-800">Waktu</p>
                    <p>Pukul {{ substr($resepsi->waktu_mulai, 0, 5) }} WIB s/d {{ $resepsi->waktu_selesai ? substr($resepsi->waktu_selesai, 0, 5) . ' WIB' : 'Selesai' }}</p>
                  </div>
                </div>

                <div class="flex items-start gap-3">
                  <div class="text-gold-600 mt-1"><i class="fa-solid fa-location-dot"></i></div>
                  <div>
                    <p class="font-semibold text-stone-800">Tempat / Lokasi</p>
                    <p class="font-medium text-royal-900">{{ $resepsi->tempat }}</p>
                    <p class="text-xs text-stone-500">{{ $resepsi->alamat }}</p>
                  </div>
                </div>
              </div>

              <!-- Google Maps Link Button -->
              <div class="mt-8">
                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($resepsi->tempat . ' ' . $resepsi->alamat) }}" target="_blank" class="inline-flex items-center justify-center gap-2 w-full bg-royal-800 hover:bg-royal-900 text-white font-medium text-xs tracking-wider uppercase px-6 py-3 rounded-2xl shadow-lg border border-gold-500/25 transition-all duration-300">
                  <i class="fa-solid fa-map-marked-alt text-gold-400"></i>
                  <span>Petunjuk Lokasi Google Maps</span>
                </a>
              </div>
            </div>
          </div>
          @endif

        </div>
      </section>




      @if($invitation->is_cerita_aktif && count($ceritas) > 0)
      <!-- E: OUR LOVE STORY TIMELINE (ANCHOR) -->
      <section id="story" class="relative py-24 px-6 bg-[#F7F2EC] overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-15"></div>

        <!-- Section title -->
        <div class="text-center max-w-sm mx-auto mb-16" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Kisah Asmara</span>
          <h2 class="font-serif text-4xl font-bold text-royal-800 mb-3">Cerita Cinta Kami</h2>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
        </div>

        <!-- Timeline core container -->
        <div class="max-w-md mx-auto space-y-0">

          @foreach($ceritas as $cerita)
          <div class="flex gap-4 relative" data-aos="fade-up" data-aos-duration="1250">
            <div class="flex flex-col items-center">
              <span class="w-8 h-8 rounded-full bg-gradient-to-r from-gold-500 to-amber-400 border border-white shadow-md flex items-center justify-center shrink-0 z-10 relative mt-1">
                <i class="fa-solid fa-heart text-[10px] text-[#12182E]"></i>
              </span>
              @if(!$loop->last)
              <div class="w-[2px] h-full bg-gold-500/30 mt-[-8px]"></div>
              @endif
            </div>

            <div class="bg-white/80 p-6 rounded-2xl border border-gold-500/20 shadow-md flex-1 mb-10">
              <div class="flex items-center justify-between mb-2">
                <h3 class="font-serif text-lg font-bold text-royal-800">{{ $cerita->judul }}</h3>
                <span class="text-[10px] text-amber-600 bg-gold-100 font-semibold px-2.5 py-1 rounded-full uppercase">{{ $cerita->tanggal }}</span>
              </div>
              <p class="text-xs text-stone-600 leading-relaxed mt-2">
                {{ $cerita->isi_cerita }}
              </p>
            </div>
          </div>
          @endforeach

        </div>
      </section>
      @endif


      @if($invitation->is_galeri_aktif && count($galeris) > 0)
      <!-- F: GALLERY (ANCHOR) -->
      <section id="gallery" class="relative py-24 px-6 bg-cream-50 overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-10"></div>

        <!-- Section title -->
        <div class="text-center max-w-sm mx-auto mb-16" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Galeri Foto</span>
          <h2 class="font-serif text-4xl font-bold text-royal-800 mb-3">Galeri Kebahagiaan</h2>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
          <p class="text-xs md:text-sm text-stone-600 leading-relaxed">
            Memori abadi yang terukir manis dalam bingkai romansa. (Klik salah satu gambar untuk memperbesar)
          </p>
        </div>

        <!-- Masonry Grid -->
        <div class="max-w-md mx-auto columns-2 gap-4 space-y-4 [column-fill:_balance] box-border">

          @foreach($galeris as $galeri)
          @php
          $galeriUrl = str_starts_with($galeri->image_path, 'assets/') ? asset($galeri->image_path) : asset('storage/' . $galeri->image_path);
          @endphp
          <div class="break-inside-avoid relative overflow-hidden rounded-2xl border border-gold-500/20 shadow-md group cursor-pointer gallery-trigger"
            data-aos="zoom-in" data-aos-duration="1200"
            data-src="{{ $galeriUrl }}"
            data-caption="Momen Kebahagiaan">
            <img src="{{ $galeriUrl }}"
              alt="Galeri"
              class="w-full object-cover h-auto rounded-2xl group-hover:scale-110 transition-transform duration-500"
              referrerpolicy="no-referrer">
            <div class="absolute inset-0 bg-gradient-to-t from-royal-900/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
              <span class="text-[10px] text-amber-200 uppercase tracking-widest font-serif block">Momen Indah</span>
            </div>
          </div>
          @endforeach

        </div>
      </section>
      @endif


      @if($invitation->is_kado_aktif && count($kados) > 0)
      <!-- G: WEDDING GIFT / DIGITAL ENVELOPE (ANCHOR) -->
      <section id="gift" class="relative py-24 px-6 bg-[#F7F2EC] overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-15"></div>

        <!-- Section title -->
        <div class="text-center max-w-sm mx-auto mb-16" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Tanda Kasih</span>
          <h2 class="font-serif text-4xl font-bold text-royal-800 mb-3">Kado Digital</h2>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
          <p class="text-xs md:text-sm text-stone-600 leading-relaxed font-sans">
            Doa restu Anda adalah karunia terindah. Namun, jika Anda ingin memberikan tanda kasih secara digital, Anda dapat mentransfer melalui saluran berikut:
          </p>
        </div>

        <!-- Gift Cards -->
        <div class="max-w-md mx-auto space-y-8">

          @foreach($kados as $index => $kado)
          <div class="relative bg-gradient-to-br from-[#F8FAFC] via-[#E2E8F0] to-[#CBD5E1] text-royal-900 rounded-3xl border border-gray-400/50 shadow-2xl overflow-hidden p-6 hover:scale-105 transition-transform duration-300" data-aos="fade-up" data-aos-duration="1200">
            <!-- Hologram chip aesthetic -->
            <div class="flex justify-between items-start mb-6">
              <div>
                <h4 class="font-serif text-xl tracking-widest text-royal-900 font-bold block">{{ strtoupper($kado->nama_bank) }}</h4>
                <span class="text-[8px] text-stone-500 block uppercase tracking-widest">Digital Envelope</span>
              </div>
              <div class="w-10 h-8 rounded bg-gradient-to-br from-gray-300 via-gray-100 to-gray-400 border border-white/80 shadow-inner"></div>
            </div>

            <div class="mb-4">
              <span class="text-[9px] uppercase text-stone-500 block tracking-widest">Nomor Rekening</span>
              <p class="font-mono text-xl tracking-wider text-royal-900 font-bold">{{ $kado->nomor_rekening }}</p>
            </div>

            <div class="flex justify-between items-end">
              <div>
                <span class="text-[9px] uppercase text-stone-500 block">Atas Nama</span>
                <p class="font-serif text-sm tracking-wide text-royal-800 font-bold uppercase font-sans">{{ $kado->atas_nama }}</p>
              </div>
              <!-- Copy Button Trigger -->
              <button class="btn-copy-account flex items-center gap-1 bg-white/60 hover:bg-white/90 border border-gray-300 text-royal-900 text-xs px-4 py-2 rounded-xl transition-all cursor-pointer font-sans"
                data-account="{{ $kado->nomor_rekening }}">
                <i class="fa-solid fa-copy text-royal-700"></i>
                <span>Salin</span>
              </button>
            </div>
          </div>
          @endforeach

        </div>
      </section>
      @endif


      <!-- H: MESSAGE / RSVP INPUT INTERCONNECTED FORM (ANCHOR) -->
      <section id="rsvp" class="relative py-24 px-6 bg-cream-50 overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-10"></div>

        <!-- Section title -->
        <div class="text-center max-w-sm mx-auto mb-12" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Konfirmasi Kehadiran</span>
          <h2 class="font-serif text-4xl font-bold text-royal-800 mb-3">Daftar Kehadiran</h2>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
        </div>

        <!-- RSVP Form Grid -->
        <div class="max-w-md mx-auto bg-white border border-gold-500/20 p-8 rounded-3xl shadow-xl glass-premium" data-aos="fade-up" data-aos-duration="1200">
          <form id="rsvp-form" class="space-y-6">

            <!-- Input: Nama -->
            <div>
              <label for="rsvp-name" class="block text-xs font-semibold text-stone-700 uppercase tracking-widest mb-2">
                Nama Lengkap Anda
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400">
                  <i class="fa-solid fa-user text-xs"></i>
                </span>
                <input type="text" id="rsvp-name" required placeholder="Contoh: Nama Anda..." class="w-full pl-10 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none text-xs text-stone-800 transition-all font-sans" value="{{ request('to') ? ucwords(str_replace('-', ' ', request('to'))) : '' }}">
              </div>
            </div>

            <!-- Selection: Konfirmasi Kehadiran -->
            <div>
              <label for="rsvp-status" class="block text-xs font-semibold text-stone-700 uppercase tracking-widest mb-2">
                Konfirmasi Kehadiran
              </label>
              <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-stone-400">
                  <i class="fa-solid fa-clipboard-question text-xs"></i>
                </span>
                <select id="rsvp-status" required class="w-full pl-10 pr-4 py-3 bg-stone-50 border border-stone-200 rounded-xl focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none text-xs text-stone-800 transition-all font-sans appearance-none">
                  <option value="" disabled selected>Pilih Kehadiran Anda...</option>
                  <option value="Hadir">Hadir</option>
                  <option value="Tidak Hadir">Mohon Maaf, Berhalangan Mandiri</option>
                  <option value="Masih Ragu">Belum Dapat Konfirmasi Kehadiran</option>
                </select>
              </div>
            </div>

            <!-- Textarea: Pesan Doa / Wishes -->
            <div>
              <label for="rsvp-message" class="block text-xs font-semibold text-stone-700 uppercase tracking-widest mb-2">
                Ucapan Selamat / Doa Restu
              </label>
              <div class="relative">
                <textarea id="rsvp-message" required rows="4" placeholder="Ketik ucapan doa restu indah Anda untuk sepasang mempelai..." class="w-full p-4 bg-stone-50 border border-stone-200 rounded-xl focus:border-gold-500 focus:ring-1 focus:ring-gold-500 outline-none text-xs text-stone-800 transition-all font-sans"></textarea>
              </div>
            </div>

            <!-- Action button submitting RSVP -->
            <div>
              <button type="submit" id="btn-submit-rsvp" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-royal-800 to-burgundy border border-gold-500/25 text-white font-semibold text-xs tracking-widest uppercase py-4 rounded-xl shadow-xl transition-all hover:brightness-110 cursor-pointer">
                <i class="fa-solid fa-paper-plane text-xs text-gold-400"></i>
                <span id="btn-submit-text">Kirim Konfirmasi Kehadiran</span>
              </button>
            </div>

          </form>
        </div>

        <!-- Divider -->
        <div class="max-w-md mx-auto my-12 text-center" data-aos="fade-up" data-aos-duration="1000">
          <span class="font-serif text-gold-500 text-xs tracking-widest uppercase block mb-2">Pilar Ucapan Restu</span>
          <div class="w-12 h-[1.5px] bg-gold-500 mx-auto my-3"></div>
        </div>

        <!-- Scrollable wall wishes -->
        <div class="max-w-md mx-auto" data-aos="fade-up" data-aos-duration="1200">
          <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 overscroll-contain relative pointer-events-auto" id="wishes-scroll-box">
            <div id="wishes-list" class="space-y-4">
              @forelse($wishes as $wish)
              <div class="bg-white p-5 rounded-2xl border border-stone-100 shadow-sm flex gap-4 transition-all hover:shadow-md">
                <div class="w-10 h-10 rounded-full bg-royal-800 text-gold-400 font-serif font-bold text-sm flex items-center justify-center shrink-0 border border-gold-500/25">
                  {{ strtoupper(substr($wish->nama, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                  <div class="flex flex-wrap items-center justify-between gap-1 mb-1.5">
                    <h4 class="font-serif text-sm font-bold text-royal-900 truncate">{{ $wish->nama }}</h4>
                    <span class="text-[9px] text-stone-400">{{ $wish->created_at->diffForHumans() }}</span>
                  </div>
                  <div class="mb-2">
                    @if($wish->kehadiran == 'hadir')
                    <span class="text-[9px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium"><i class="fa-solid fa-circle-check mr-0.5"></i> Hadir</span>
                    @elseif($wish->kehadiran == 'tidak')
                    <span class="text-[9px] bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium"><i class="fa-solid fa-circle-xmark mr-0.5"></i> Berhalangan</span>
                    @else
                    <span class="text-[9px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-medium"><i class="fa-solid fa-circle-question mr-0.5"></i> Masih Ragu</span>
                    @endif
                  </div>
                  <p class="text-xs text-stone-600 leading-relaxed font-sans italic">
                    "{{ $wish->pesan }}"
                  </p>
                </div>
              </div>
              @empty
              <p class="text-xs text-stone-500 text-center py-4">Belum ada ucapan. Jadilah yang pertama!</p>
              @endforelse
            </div>
          </div>
        </div>
      </section>


      <!-- J: APPRECIATE FOOTER (ANCHOR) -->
      <section class="relative py-20 px-6 bg-[#12182E] text-white text-center overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-10"></div>

        <div class="max-w-md mx-auto relative z-10" data-aos="fade-up" data-aos-duration="1200">
          <h4 class="font-serif text-2xl tracking-widest text-[#D4AF37] font-bold block mb-2">TERIMA KASIH</h4>
          <div class="w-12 h-[1px] bg-gold-500 mx-auto my-3"></div>

          <p class="text-stone-300 text-xs md:text-sm leading-relaxed max-w-xs mx-auto mb-12">
            Keberadaan serta untaian doa tulus Bapak/Ibu/Saudara/i sangatlah berharga bagi hidup baru kami yang akan dimulai.
          </p>

          <span class="font-serif text-3xl font-bold block bg-gradient-to-r from-amber-200 via-white to-amber-200 bg-clip-text text-transparent mb-1">
            {{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}
          </span>
          <!-- <p class="text-[10px] text-stone-400 tracking-widest uppercase mb-12">Wassalamu’alaikum Warahmatullahi Wabarakatuh</p> -->

          <div class="text-[10px] text-stone-500 border-t border-white/10 pt-8 flex flex-col items-center gap-1">
            <span>Dibuat dengan dedikasi cinta © {{ date('Y') }} Aufilla Invitation.</span>
            <span class="tracking-widest uppercase text-[8px] text-amber-500/80 font-semibold">Premium Wedding Concierge</span>
          </div>
        </div>
      </section>

    </div>

    @if(isset($tamu) && isset($qrCode))
    <!-- QR MODAL (Restricted to Panel on Desktop) -->
    <div id="qr-modal" onclick="this.style.display='none'" class="fixed lg:absolute inset-0 lg:left-auto lg:w-[480px] lg:right-0 z-[10000]" style="display:none; background-color:rgba(0,0,0,0.6); backdrop-filter:blur(4px); -webkit-backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:1rem; cursor:pointer;">
      <div onclick="event.stopPropagation()" style="background:#fff; border-radius:1rem; box-shadow:0 25px 50px rgba(0,0,0,0.25); width:100%; max-width:24rem; overflow:hidden; text-align:center; margin:auto; cursor:default;">
        <div style="background-color:#1D2646; padding:1rem; color:#fff; display:flex; justify-content:space-between; align-items:center;">
          <h3 style="font-size:1.125rem; font-weight:700; color:#D4AF37; margin:0; font-family:'Cormorant Garamond',serif;">Tiket Akses Masuk</h3>
          <button onclick="document.getElementById('qr-modal').style.display='none'" style="background:none; border:none; color:#fff; cursor:pointer; padding:4px;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        <div style="padding:2rem; display:flex; flex-direction:column; align-items:center;">
          <p style="font-size:0.875rem; color:#6b7280; margin-bottom:1.5rem; line-height:1.6;">Silakan tunjukkan QR Code ini kepada resepsionis saat Anda tiba di lokasi acara.</p>
          <div style="background:#fff; padding:0.75rem; border:4px solid rgba(29,38,70,0.1); border-radius:1rem; box-shadow:0 1px 3px rgba(0,0,0,0.05); display:inline-block; margin-bottom:1.5rem;">
            {!! $qrCode !!}
          </div>
          <div style="width:100%; height:1px; background-color:#e5e7eb; margin-bottom:1rem;"></div>
          <p style="font-weight:700; font-size:1.5rem; color:#1D2646; margin:0; font-family:'Cormorant Garamond',serif;">{{ ucwords($tamu->nama_tamu) }}</p>
          <span style="font-size:0.75rem; font-family:monospace; color:#9ca3af; margin-top:0.25rem; text-transform:uppercase; letter-spacing:0.1em;">{{ $tamu->kode_qr }}</span>
          <div style="margin-top:1.5rem;">
            <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ $tamu->kode_qr }}" download="QR_{{ $tamu->nama_tamu }}.png" target="_blank"
              style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.5rem 1.5rem; background-color:#1D2646; color:#D4AF37; border-radius:9999px; text-decoration:none; font-size:0.875rem; font-weight:600;">
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

  </div>


  <!-- 4. CONTROLS, EFFECTS & FLOATING NOTIFIERS -->

  <!-- CUSTOM TOAST NOTIFICATION -->
  <div id="toast" class="fixed bottom-32 left-1/2 lg:left-auto lg:right-[268px] transform -translate-x-1/2 lg:translate-x-1/2 z-[100] bg-[#1D2646] border border-[#D4AF37] text-amber-100 px-6 py-3 rounded-full shadow-2xl flex items-center gap-2.5 transition-all duration-300 opacity-0 pointer-events-none text-xs tracking-wider">
    <i class="fa-solid fa-circle-check text-[#D4AF37] text-sm animate-pulse"></i>
    <span id="toast-message" class="font-medium">Nomor Rekening Berhasil Disalin!</span>
  </div>

  <!-- GLASS FLOATING BOTTOM TAB BAR (Responsive thumb reach, scrolls dynamically) -->
  <div id="floating-nav-bar" class="fixed bottom-12 left-1/2 lg:left-auto lg:right-[268px] transform -translate-x-1/2 lg:translate-x-1/2 z-40 bg-royal-900/85 backdrop-blur-md rounded-full px-5 py-3 shadow-2xl border border-gold-500/25 flex items-center gap-6 max-w-[90%] md:max-w-sm transition-all duration-500 translate-y-32 opacity-0 select-none">
    <a href="#hero" class="nav-icon-trigger text-white hover:text-gold-400 text-sm transition-colors flex flex-col items-center" title="Cover">
      <i class="fa-solid fa-circle-notch"></i>
    </a>
    <a href="#couple" class="nav-icon-trigger text-stone-300 hover:text-gold-400 text-sm transition-colors flex flex-col items-center" title="Mempelai">
      <i class="fa-solid fa-heart"></i>
    </a>
    <a href="#event" class="nav-icon-trigger text-stone-300 hover:text-gold-400 text-sm transition-colors flex flex-col items-center" title="Acara">
      <i class="fa-solid fa-calendar-alt"></i>
    </a>
    @if($invitation->is_cerita_aktif && count($ceritas) > 0)
    <a href="#story" class="nav-icon-trigger text-stone-300 hover:text-gold-400 text-sm transition-colors flex flex-col items-center" title="Kisah">
      <i class="fa-solid fa-shoe-prints"></i>
    </a>
    @endif
    @if($invitation->is_galeri_aktif && count($galeris) > 0)
    <a href="#gallery" class="nav-icon-trigger text-stone-300 hover:text-gold-400 text-sm transition-colors flex flex-col items-center" title="Galeri">
      <i class="fa-solid fa-images"></i>
    </a>
    @endif
    <a href="#rsvp" class="nav-icon-trigger text-stone-300 hover:text-gold-400 text-sm transition-colors flex flex-col items-center" title="RSVP">
      <i class="fa-solid fa-marker"></i>
    </a>
  </div>

  <!-- FLOATING RIGHT-SIDE CONTROLS (stacked vertically: music -> qr -> back-to-top) -->
  <div id="floating-music-trigger" class="lg:!right-[52px]" style="position:fixed; bottom:104px; right:24px; z-index:48; transition:all 0.5s; transform:translateX(80px); opacity:0;">
    <button id="btn-toggle-music" style="width:48px; height:48px; border-radius:50%; background:linear-gradient(135deg,#B08E27,#D4AF37); color:#12182E; border:2px solid rgba(255,255,255,0.5); display:flex; align-items:center; justify-content:center; cursor:pointer; position:relative; box-shadow:0 8px 24px rgba(0,0,0,0.15);" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
      <span style="position:absolute; inset:0; border-radius:50%; border:1px solid #EECD4F; animation:ping 1.5s cubic-bezier(0,0,0.2,1) infinite; opacity:0.6;"></span>
      <i id="music-icon" class="fa-solid fa-compact-disc" style="font-size:1.25rem;"></i>
    </button>
  </div>

  @if(isset($tamu) && isset($qrCode))
  <!-- FLOATING QR BUTTON -->
  <button id="qr-btn" onclick="document.getElementById('qr-modal').style.display='flex'"
    class="lg:!right-[52px]"
    style="position:fixed; bottom:48px; right:24px; width:48px; height:48px; z-index:48; background-color:#1D2646; color:#D4AF37; border:1px solid rgba(212,175,55,0.3); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; box-shadow:0 4px 15px rgba(0,0,0,0.3); padding:0; transition:all 0.5s; transform:translateX(80px); opacity:0;">
    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
    </svg>
  </button>
  @endif

  <!-- BACK TO TOP BUTTON -->
  <button id="btn-back-to-top" class="lg:!right-[52px]" style="position:fixed; bottom:104px; right:24px; z-index:47; width:40px; height:40px; border-radius:50%; background:rgba(29,38,70,0.9); border:1px solid rgba(212,175,55,0.3); color:#D4AF37; box-shadow:0 4px 12px rgba(0,0,0,0.15); display:flex; align-items:center; justify-content:center; opacity:0; pointer-events:none; cursor:pointer; transition:all 0.3s;">
    <i class="fa-solid fa-arrow-up" style="font-size:0.75rem;"></i>
  </button>

  <!-- HIDDEN HTML5 WEDDING MP3 LOOP SINK -->
  <audio id="bg-music" loop preload="auto">
    @if($invitation->music_file)
    <source src="{{ asset('storage/' . $invitation->music_file) }}" type="audio/mpeg">
    @else
    <source src="{{ asset('assets/default/default-music.mp3') }}" type="audio/mpeg">
    @endif
  </audio>

  <style>
    @keyframes ping {

      75%,
      100% {
        transform: scale(1.5);
        opacity: 0;
      }
    }
  </style>


  <!-- 5. JQUERY CUSTOM LIGHTBOX SYSTEM MODAL -->
  <div id="lightbox" class="fixed inset-0 bg-black/95 backdrop-blur-md z-[100] flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 select-none">
    <!-- absolute controls -->
    <button id="close-lightbox" class="absolute top-6 right-6 text-white text-3xl hover:text-gold-400 transition-colors cursor-pointer">
      <i class="fa-solid fa-xmark"></i>
    </button>

    <div class="max-w-[90%] max-h-[85vh] relative flex flex-col items-center">
      <img id="lightbox-img" src="" alt="Zoomed View" class="max-w-full max-h-[70vh] object-contain rounded-2xl border border-gold-500/50 shadow-2xl">
      <div id="lightbox-caption" class="text-amber-100 font-serif mt-5 text-center text-sm md:text-base italic max-w-sm"></div>
    </div>
  </div>


  <!-- ================= IMPORT SCRIPTS SECTION ================= -->
  <!-- Local jQuery Library -->
  <script src="{{ asset('assets/vendor/js/jquery.min.js') }}"></script>

  <!-- Local AOS Animations Library JS -->
  <script src="{{ asset('assets/vendor/js/aos.js') }}"></script>

  <!-- Core Script Handler -->
  <script>
    $(document).ready(function() {

      // ================= LOADING SCREEN EXPIRY =================
      setTimeout(function() {
        $('#loading-screen').addClass('opacity-0 pointer-events-none');
        setTimeout(function() {
          $('#loading-screen').hide();
        }, 700);
      }, 1500);


      // ================= WEDDING TARGET DATE REALTIME COUNTDOWN =================
      @if($akad)
      const targetDate = new Date("{{ \Carbon\Carbon::parse(substr($akad->tgl_acara, 0, 10) . ' ' . $akad->waktu_mulai)->format('Y-m-d\TH:i:sP') }}").getTime();

      function runCountdown() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
          // Expired fallback display
          const zeroText = "00";
          $('#countdown-days, #dt-days').text(zeroText);
          $('#countdown-hours, #dt-hours').text(zeroText);
          $('#countdown-minutes, #dt-minutes').text(zeroText);
          $('#countdown-seconds, #dt-seconds').text(zeroText);
          return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        const fmtDays = days < 10 ? '0' + days : days;
        const fmtHours = hours < 10 ? '0' + hours : hours;
        const fmtMinutes = minutes < 10 ? '0' + minutes : minutes;
        const fmtSeconds = seconds < 10 ? '0' + seconds : seconds;

        // Mobile widgets
        $('#countdown-days').text(fmtDays);
        $('#countdown-hours').text(fmtHours);
        $('#countdown-minutes').text(fmtMinutes);
        $('#countdown-seconds').text(fmtSeconds);

        // Desktop side bar widgets
        $('#dt-days').text(fmtDays);
        $('#dt-hours').text(fmtHours);
        $('#dt-minutes').text(fmtMinutes);
        $('#dt-seconds').text(fmtSeconds);
      }

      setInterval(runCountdown, 1000);
      runCountdown(); // First evaluation
      @endif


      // ================= OPEN INVITATION FLOW (TRIGGER SOUND/ANIMATION) =================
      const bgMusic = document.getElementById('bg-music');
      let musicIsPlaying = false;

      $('#btn-open-invitation').on('click', function() {
        // Slide cover-screen up/out in luxurious transition
        $('#cover-screen').addClass('-translate-y-full opacity-0 pointer-events-none');

        // Unlock body scrolling
        $('body').removeClass('locked');

        // Initialize AOS - use right-pane as container on desktop to fix scroll detection
        const isDesktopInit = window.innerWidth >= 1024;
        if (isDesktopInit) {
          // Initialize AOS normally so elements keep `data-aos` and get `opacity:0` from CSS.
          AOS.init({
            duration: 1000,
            once: true,
            offset: 80
          });

          // Use IntersectionObserver to manually trigger animations inside the custom scroll container.
          const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
              if (entry.isIntersecting) {
                entry.target.classList.add('aos-animate');
              }
            });
          }, {
            root: document.getElementById('right-pane'),
            threshold: 0.15
          });

          document.querySelectorAll('[data-aos]').forEach(function(el) {
            observer.observe(el);
          });
        } else {
          AOS.init({
            duration: 1000,
            once: true,
            offset: 80
          });
        }

        // Play Wedding Instrumental audio loop handle
        if (bgMusic) {
          bgMusic.play().then(function() {
            musicIsPlaying = true;
            $('#music-icon').addClass('animate-spin-slow');
          }).catch(function(err) {
            console.log("Browser policy blocked autoplay. Toggle control active.");
            musicIsPlaying = false;
            $('#music-icon').removeClass('animate-spin-slow');
          });
        }

        // Slide in the bottom navbar and floating buttons
        setTimeout(function() {
          $('#floating-nav-bar').removeClass('translate-y-32 opacity-0');
          // Show music button
          var musicTrigger = document.getElementById('floating-music-trigger');
          if (musicTrigger) {
            musicTrigger.style.transform = 'translateX(0)';
            musicTrigger.style.opacity = '1';
          }
          // Show QR button
          var qrBtn = document.getElementById('qr-btn');
          if (qrBtn) {
            qrBtn.style.transform = 'translateX(0)';
            qrBtn.style.opacity = '1';
          }
        }, 800);
      });


      // ================= BACKGROUND MUSIC PLAY/PAUSE CONTROLLERS =================
      $('#btn-toggle-music').on('click', function() {
        if (!bgMusic) return;

        if (musicIsPlaying) {
          bgMusic.pause();
          musicIsPlaying = false;
          $('#music-icon').removeClass('animate-spin-slow');
          showNotificationToast("Lagu Latar Pernikahan Dinonaktifkan.");
        } else {
          bgMusic.play();
          musicIsPlaying = true;
          $('#music-icon').addClass('animate-spin-slow');
          showNotificationToast("Lagu Latar Pernikahan Diaktifkan.");
        }
      });


      // ================= AUDIO FEEDBACK TOASTS =================
      let toastTimeout;

      function showNotificationToast(msg) {
        $('#toast-message').text(msg);
        $('#toast').removeClass('opacity-0 translate-y-[10px] pointer-events-none').addClass('opacity-100 translate-y-0');

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(function() {
          $('#toast').removeClass('opacity-100 translate-y-0').addClass('opacity-0 translate-y-[10px] pointer-events-none');
        }, 3000);
      }


      // ================= DIGITAL GIFT COPING TO CLIPBOARD =================
      $('.btn-copy-account').on('click', function() {
        const accountNumber = $(this).data('account');

        if (!accountNumber) return;

        // Copy execution using Navigator API or standard backup buffer
        navigator.clipboard.writeText(accountNumber).then(function() {
          showNotificationToast("Nomor Rekening Berhasil Disalin!");
        }, function() {
          // Legacy/iframe fallback context
          const tempInput = document.createElement("input");
          tempInput.value = accountNumber;
          document.body.appendChild(tempInput);
          tempInput.select();
          document.execCommand("copy");
          document.body.removeChild(tempInput);
          showNotificationToast("Nomor Rekening Berhasil Disalin!");
        });
      });


      //Submit RSVP Interception with AJAX to Aufilla backend
      $('#rsvp-form').on('submit', function(e) {
        e.preventDefault();

        let formData = {
          _token: $('meta[name="csrf-token"]').attr('content'),
          name: $('#rsvp-name').val(),
          is_attending: $('#rsvp-status').val() === 'Hadir' ? 1 : ($('#rsvp-status').val() === 'Tidak Hadir' ? 0 : 2),
          message: $('#rsvp-message').val()
        };

        const btnSubmit = $('#btn-submit-rsvp');
        const btnText = $('#btn-submit-text');
        const originalText = btnText.text();

        btnSubmit.prop('disabled', true);
        btnText.text('Mengirim...');

        $.ajax({
          url: '{{ route("public.ucapan.store", $invitation->slug) }}',
          type: 'POST',
          data: formData,
          success: function(response) {
            showNotificationToast(response.message || 'Konfirmasi berhasil dikirim!');
            $('#rsvp-status').val('');
            $('#rsvp-message').val('');

            // Prepend new wish
            if (response.wish) {
              const initials = response.wish.nama.substring(0, 2).toUpperCase();

              let statusBadge = '';
              if (formData.is_attending === 1) {
                statusBadge = `<span class="text-[9px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium"><i class="fa-solid fa-circle-check mr-0.5"></i> Hadir</span>`;
              } else if (formData.is_attending === 0) {
                statusBadge = `<span class="text-[9px] bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-medium"><i class="fa-solid fa-circle-xmark mr-0.5"></i> Berhalangan</span>`;
              } else {
                statusBadge = `<span class="text-[9px] bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full font-medium"><i class="fa-solid fa-circle-question mr-0.5"></i> Masih Ragu</span>`;
              }

              const card = `
                          <div class="bg-white p-5 rounded-2xl border border-stone-100 shadow-sm flex gap-4 transition-all hover:shadow-md animate-fade-in">
                            <div class="w-10 h-10 rounded-full bg-royal-800 text-gold-400 font-serif font-bold text-sm flex items-center justify-center shrink-0 border border-gold-500/25">
                              ${initials}
                            </div>
                            <div class="flex-1 min-w-0">
                              <div class="flex flex-wrap items-center justify-between gap-1 mb-1.5">
                                <h4 class="font-serif text-sm font-bold text-royal-900 truncate">${response.wish.nama}</h4>
                                <span class="text-[9px] text-stone-400">Baru saja</span>
                              </div>
                              <div class="mb-2">
                                ${statusBadge}
                              </div>
                              <p class="text-xs text-stone-600 leading-relaxed font-sans italic">
                                "${formData.message}"
                              </p>
                            </div>
                          </div>
                        `;

              // Remove empty message if exists
              $('#wishes-list p.text-center').remove();
              $('#wishes-list').prepend(card);
            }
          },
          error: function(xhr) {
            showNotificationToast(xhr.responseJSON?.message || 'Terjadi kesalahan. Silakan coba lagi.');
          },
          complete: function() {
            btnSubmit.prop('disabled', false);
            btnText.text(originalText);
          }
        });
      });


      // ================= GALLERY JQUERY CUSTOM LIGHTBOX SYSTEM =================
      $('.gallery-trigger').on('click', function() {
        const imgSrc = $(this).data('src');
        const imgCap = $(this).data('caption');

        if (!imgSrc) return;

        // Set source inside overlay modal
        $('#lightbox-img').attr('src', imgSrc);
        $('#lightbox-caption').text(imgCap || "Momen Bahagia");

        // Open with smooth fade animations
        $('#lightbox').removeClass('opacity-0 pointer-events-none').addClass('opacity-100');
      });

      // Close functions
      $('#close-lightbox, #lightbox').on('click', function(e) {
        if (e.target !== this && e.target !== document.getElementById('close-lightbox') && $(e.target).closest('#close-lightbox').length === 0) {
          return; // click inside picture frame
        }
        $('#lightbox').removeClass('opacity-100').addClass('opacity-0 pointer-events-none');
      });


      // ================= BOTTOM FLOATING NAV BAR SCROLL HIGHLIGHT =================
      const sections = ['#hero', '#couple', '#event', '#story', '#gallery', '#rsvp'];

      // Intercept scrolls inside right side panel or window (depending on screen width)
      function checkScrollHighlights() {
        const isDesktop = window.innerWidth >= 1024;
        const container = isDesktop ? $('#right-pane') : $(window);
        const scrollPos = container.scrollTop() + 200;

        sections.forEach(function(id) {
          const targetEl = $(id);
          if (targetEl.length === 0) return;

          let elTop = 0;
          if (isDesktop) {
            elTop = targetEl.position().top + $('#right-pane').scrollTop();
          } else {
            elTop = targetEl.offset().top;
          }

          const elBottom = elTop + targetEl.outerHeight();

          if (scrollPos >= elTop && scrollPos < elBottom) {
            // Match active state
            $(`a[href="${id}"]`).removeClass('text-stone-300 text-stone-400').addClass('text-gold-400 font-bold scale-110');
          } else {
            $(`a[href="${id}"]`).removeClass('text-gold-400 font-bold scale-110').addClass('text-stone-300');
          }
        });

        // Show/Hide Back to top button
        const viewOffset = container.scrollTop();
        const bttBtn = document.getElementById('btn-back-to-top');
        if (bttBtn) {
          if (viewOffset > 500) {
            bttBtn.style.opacity = '1';
            bttBtn.style.pointerEvents = 'auto';
          } else {
            bttBtn.style.opacity = '0';
            bttBtn.style.pointerEvents = 'none';
          }
        }
      }

      // Attach listeners
      $('#right-pane').on('scroll', checkScrollHighlights);
      $(window).on('scroll', checkScrollHighlights);


      // Navigation Anchor Smooth Scrolling inside Split view
      $('.nav-icon-trigger').on('click', function(e) {
        e.preventDefault();
        const targetSelector = $(this).attr('href');
        const targetEl = $(targetSelector);

        if (targetEl.length === 0) return;

        const isDesktop = window.innerWidth >= 1024;

        if (isDesktop) {
          const currentPaneScroll = $('#right-pane').scrollTop();
          const coordinate = targetEl.position().top + currentPaneScroll;
          $('#right-pane').animate({
            scrollTop: coordinate
          }, 800);
        } else {
          const coordinate = targetEl.offset().top;
          $('html, body').animate({
            scrollTop: coordinate
          }, 800);
        }
      });

      // Back to Top trigger
      $('#btn-back-to-top').on('click', function() {
        const isDesktop = window.innerWidth >= 1024;
        if (isDesktop) {
          $('#right-pane').animate({
            scrollTop: 0
          }, 800);
        } else {
          $('html, body').animate({
            scrollTop: 0
          }, 800);
        }
      });

    });
  </script>
</body>

</html>