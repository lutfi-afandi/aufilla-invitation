<?php

$target = 'resources/views/themes/aufilla-diff/index.blade.php';

$html = <<<'EOD'
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Undangan Pernikahan - {{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}</title>

  <!-- SEO Meta -->
  <meta name="description" content="Kami mengundang Anda untuk hadir dan memberikan doa restu pada acara pernikahan kami: {{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
  
  <!-- FontAwesome & AOS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#FFF0F7', 100: '#FFE0F0', 200: '#FFC2E2', 300: '#FFA3D3', 
              400: '#FF85C4', 500: '#FF80C7', 600: '#E6008A', 700: '#B3006B', 
              800: '#99005c', 900: '#66003d', 950: '#33001f'
            },
            accent: '#C5A031',
            base: '#FFF5F8'
          },
          fontFamily: {
            serif: ['Cormorant Garamond', 'serif'],
            sans: ['Montserrat', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #FFF5F8; }
    ::-webkit-scrollbar-thumb { background: #FFC2E2; border-radius: 4px; }
    ::-webkit-scrollbar-thumb:hover { background: #FF80C7; }

    .locked { overflow: hidden; }
    
    /* Shape Utilities */
    .arch-mask {
      border-radius: 9999px 9999px 0 0;
    }
    
    .text-vertical {
      writing-mode: vertical-rl;
      text-orientation: mixed;
    }
    
    .glass-dark {
      background: rgba(51, 0, 31, 0.4);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
  </style>
</head>

<body class="font-sans text-stone-700 bg-base relative locked selection:bg-primary-500 selection:text-white">

  <!-- LOADING SCREEN -->
  <div id="loading-screen" class="fixed inset-0 bg-primary-950 z-[99] flex flex-col justify-center items-center transition-opacity duration-700">
    <div class="relative w-20 h-20 border-2 border-accent/30 border-t-accent rounded-full animate-spin"></div>
    <p class="font-serif text-accent mt-6 tracking-widest uppercase text-sm animate-pulse">Memuat Undangan...</p>
  </div>

  <!-- SINGLE CANVAS CONTAINER -->
  <div class="w-full max-w-2xl mx-auto bg-white shadow-2xl relative min-h-screen overflow-x-hidden">

    <!-- 1. COVER OVERLAY -->
    <div id="cover-screen" class="absolute inset-0 z-50 bg-base flex flex-col justify-end transition-all duration-1000 ease-in-out origin-bottom">
      
      <!-- Cover Image (Top Right Asymmetric) -->
      <div class="absolute top-0 right-0 w-[85%] h-[75%] rounded-bl-[120px] overflow-hidden shadow-xl"
           style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
      </div>

      <!-- Cover Content Block (Bottom Left Asymmetric) -->
      <div class="relative w-[85%] bg-primary-950 rounded-tr-[80px] p-10 z-10 text-white shadow-2xl mb-8">
        <span class="font-sans text-xs tracking-[0.3em] uppercase text-accent mb-2 block">The Wedding Of</span>
        <h1 class="font-serif text-4xl md:text-5xl font-bold mb-6 leading-tight text-white">
          {{ $invitation->pria_nama }} <br>
          <span class="text-accent text-3xl font-light italic">&amp;</span> <br>
          {{ $invitation->wanita_nama }}
        </h1>
        
        <p class="text-xs text-white/70 tracking-widest uppercase mb-1">Kepada Yth.</p>
        <h2 class="font-serif text-xl font-semibold text-white mb-8 truncate">
          {{ request('to') ? ucwords(str_replace('-', ' ', request('to'))) : 'Tamu Kehormatan' }}
        </h2>

        <button id="btn-open-invitation" class="bg-accent text-primary-950 font-bold uppercase tracking-widest text-[10px] px-8 py-4 rounded-full shadow-lg hover:bg-white transition-all transform hover:scale-105">
          Buka Undangan
        </button>
      </div>
    </div>

    <!-- MAIN SCROLLABLE CONTENT -->
    <div id="main-content" class="w-full relative opacity-0">

      <!-- HERO SECTION -->
      <section id="hero" class="relative min-h-[90vh] bg-base flex flex-col justify-end">
        <div class="absolute top-0 right-0 w-full h-[80%] rounded-bl-[120px] overflow-hidden">
           <img src="{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}" alt="Hero" class="w-full h-full object-cover opacity-90">
           <div class="absolute inset-0 bg-black/10"></div>
        </div>
        
        <div class="relative z-10 w-[90%] bg-white rounded-tr-[80px] p-8 shadow-2xl mb-12 self-start" data-aos="fade-up" data-aos-duration="1000">
           <span class="font-sans text-[10px] tracking-[0.2em] uppercase text-stone-400 block mb-2">Pernikahan Impian</span>
           <h2 class="font-serif text-4xl font-bold text-primary-900 mb-6 leading-none">
             {{ $invitation->pria_nama }} <span class="text-accent">&amp;</span> {{ $invitation->wanita_nama }}
           </h2>

           <!-- Countdown Grid -->
           <div class="flex gap-4">
             <div>
               <span id="dt-days" class="font-serif text-2xl font-bold text-primary-900 block">00</span>
               <span class="text-[9px] uppercase tracking-wider text-stone-500">Hari</span>
             </div>
             <div>
               <span id="dt-hours" class="font-serif text-2xl font-bold text-primary-900 block">00</span>
               <span class="text-[9px] uppercase tracking-wider text-stone-500">Jam</span>
             </div>
             <div>
               <span id="dt-minutes" class="font-serif text-2xl font-bold text-primary-900 block">00</span>
               <span class="text-[9px] uppercase tracking-wider text-stone-500">Mnt</span>
             </div>
             <div>
               <span id="dt-seconds" class="font-serif text-2xl font-bold text-primary-900 block">00</span>
               <span class="text-[9px] uppercase tracking-wider text-stone-500">Dtk</span>
             </div>
           </div>
        </div>
      </section>

      <!-- GREETING SECTION -->
      <section class="py-16 px-8 text-center bg-white">
        <h3 class="font-serif text-2xl text-accent mb-4 italic">Assalamu'alaikum Warahmatullahi Wabarakatuh</h3>
        <p class="text-sm leading-relaxed text-stone-600">
          {!! nl2br(e($invitation->salam_pembuka ?? 'Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i ke acara pernikahan kami.')) !!}
        </p>
      </section>

      <!-- COUPLE SECTION (Asymmetric Grid) -->
      <section id="couple" class="py-16 px-6 bg-base overflow-hidden">
        
        <!-- Groom Block -->
        <div class="flex items-end mb-16 relative" data-aos="fade-right">
          <div class="w-[60%]">
             <div class="relative w-full aspect-[3/4] arch-mask overflow-hidden shadow-xl border-4 border-white">
               <img src="{{ $invitation->pria_foto ? asset('storage/' . $invitation->pria_foto) : asset('assets/default/default_pria.jpg') }}" class="w-full h-full object-cover">
             </div>
          </div>
          <div class="w-[40%] bg-primary-900 h-64 -ml-6 relative z-10 flex items-center justify-center rounded-br-[60px] shadow-lg">
             <span class="text-vertical text-white font-serif tracking-[0.3em] uppercase text-sm rotate-180">The Groom</span>
          </div>
          <!-- Text Overlay below -->
          <div class="absolute -bottom-8 left-4 bg-white/90 backdrop-blur px-6 py-4 rounded-xl shadow-lg border border-white max-w-[80%]">
             <h3 class="font-serif text-2xl font-bold text-primary-900">{{ $invitation->pria_nama_lengkap }}</h3>
             <p class="text-[10px] uppercase tracking-widest text-accent mb-2">Mempelai Pria</p>
             <p class="text-xs text-stone-600">Putra dari Bapak {{ $invitation->pria_ayah }} &amp; Ibu {{ $invitation->pria_ibu }}</p>
             @if($invitation->pria_ig)
               <a href="https://instagram.com/{{ $invitation->pria_ig }}" target="_blank" class="inline-block mt-3 text-primary-600 text-[10px] border border-primary-300 rounded-full px-3 py-1"><i class="fab fa-instagram"></i> {{ $invitation->pria_ig }}</a>
             @endif
          </div>
        </div>

        <div class="h-16"></div> <!-- Spacer for absolute overflow -->

        <!-- Bride Block -->
        <div class="flex items-end justify-end mb-16 relative" data-aos="fade-left">
          <!-- Text Overlay below (z-20 so it overlaps) -->
          <div class="absolute -bottom-8 right-4 bg-white/90 backdrop-blur px-6 py-4 rounded-xl shadow-lg border border-white max-w-[80%] text-right z-20">
             <h3 class="font-serif text-2xl font-bold text-primary-900">{{ $invitation->wanita_nama_lengkap }}</h3>
             <p class="text-[10px] uppercase tracking-widest text-accent mb-2">Mempelai Wanita</p>
             <p class="text-xs text-stone-600">Putri dari Bapak {{ $invitation->wanita_ayah }} &amp; Ibu {{ $invitation->wanita_ibu }}</p>
             @if($invitation->wanita_ig)
               <a href="https://instagram.com/{{ $invitation->wanita_ig }}" target="_blank" class="inline-block mt-3 text-primary-600 text-[10px] border border-primary-300 rounded-full px-3 py-1"><i class="fab fa-instagram"></i> {{ $invitation->wanita_ig }}</a>
             @endif
          </div>

          <div class="w-[40%] bg-primary-900 h-64 -mr-6 relative z-10 flex items-center justify-center rounded-bl-[60px] shadow-lg">
             <span class="text-vertical text-white font-serif tracking-[0.3em] uppercase text-sm">The Bride</span>
          </div>
          <div class="w-[60%] z-0">
             <div class="relative w-full aspect-[3/4] arch-mask overflow-hidden shadow-xl border-4 border-white">
               <img src="{{ $invitation->wanita_foto ? asset('storage/' . $invitation->wanita_foto) : asset('assets/default/default_wanita.jpg') }}" class="w-full h-full object-cover">
             </div>
          </div>
        </div>
        
        <div class="h-16"></div>

      </section>

      <!-- EVENT SECTION -->
      <section id="event" class="py-20 px-6 bg-white">
        <div class="text-center mb-12" data-aos="fade-up">
          <span class="font-sans text-[10px] tracking-[0.3em] text-accent uppercase block mb-2">Agenda</span>
          <h2 class="font-serif text-4xl text-primary-900 font-bold">Rangkaian Acara</h2>
        </div>

        <div class="space-y-8">
          @if($akad)
          <div class="bg-base rounded-tr-[60px] rounded-bl-[60px] p-8 shadow-md border border-primary-100 relative" data-aos="fade-up">
            <div class="absolute top-0 right-0 bg-primary-900 text-white font-serif text-xs px-6 py-2 rounded-bl-2xl rounded-tr-[60px]">01</div>
            <h3 class="font-serif text-3xl text-primary-900 font-bold mb-1">Akad Nikah</h3>
            <p class="text-xs text-accent uppercase tracking-widest mb-6">Momen Suci</p>
            
            <div class="flex items-start gap-4 mb-4 text-stone-600 text-sm">
              <i class="fa-solid fa-calendar-alt mt-1 text-primary-500"></i>
              <div>
                <span class="font-bold block">{{ \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l, d F Y') }}</span>
                <span>Pukul {{ \Carbon\Carbon::parse($akad->jam_mulai)->format('H:i') }} - Selesai</span>
              </div>
            </div>
            <div class="flex items-start gap-4 mb-6 text-stone-600 text-sm">
              <i class="fa-solid fa-map-marker-alt mt-1 text-primary-500"></i>
              <div>
                <span class="font-bold block">{{ $akad->tempat }}</span>
                <span class="text-xs">{{ $akad->alamat }}</span>
              </div>
            </div>
            
            @if($akad->link_maps)
            <a href="{{ $akad->link_maps }}" target="_blank" class="inline-block bg-primary-900 text-white text-xs px-6 py-3 rounded-full hover:bg-primary-700 transition shadow-lg">
              <i class="fa-solid fa-location-arrow mr-2"></i> Buka Google Maps
            </a>
            @endif
          </div>
          @endif

          @if($resepsi)
          <div class="bg-primary-900 rounded-tl-[60px] rounded-br-[60px] p-8 shadow-xl relative text-white" data-aos="fade-up" data-aos-delay="100">
            <div class="absolute top-0 left-0 bg-accent text-primary-950 font-serif text-xs px-6 py-2 rounded-br-2xl rounded-tl-[60px]">02</div>
            <h3 class="font-serif text-3xl text-white font-bold mb-1 mt-4 text-right">Resepsi</h3>
            <p class="text-xs text-primary-200 uppercase tracking-widest mb-6 text-right">Perayaan Cinta</p>
            
            <div class="flex items-start gap-4 mb-4 text-stone-200 text-sm justify-end text-right">
              <div>
                <span class="font-bold block">{{ \Carbon\Carbon::parse($resepsi->tgl_acara)->translatedFormat('l, d F Y') }}</span>
                <span>Pukul {{ \Carbon\Carbon::parse($resepsi->jam_mulai)->format('H:i') }} - {{ $resepsi->jam_selesai ? \Carbon\Carbon::parse($resepsi->jam_selesai)->format('H:i') : 'Selesai' }}</span>
              </div>
              <i class="fa-solid fa-calendar-alt mt-1 text-accent"></i>
            </div>
            <div class="flex items-start gap-4 mb-6 text-stone-200 text-sm justify-end text-right">
              <div>
                <span class="font-bold block">{{ $resepsi->tempat }}</span>
                <span class="text-xs">{{ $resepsi->alamat }}</span>
              </div>
              <i class="fa-solid fa-map-marker-alt mt-1 text-accent"></i>
            </div>
            
            <div class="text-right">
              @if($resepsi->link_maps)
              <a href="{{ $resepsi->link_maps }}" target="_blank" class="inline-block bg-white text-primary-900 text-xs font-bold px-6 py-3 rounded-full hover:bg-accent transition shadow-lg">
                <i class="fa-solid fa-location-arrow mr-2"></i> Buka Google Maps
              </a>
              @endif
            </div>
          </div>
          @endif
        </div>
      </section>

      <!-- STORY & GALLERY -->
      @if($invitation->is_cerita_aktif && count($ceritas) > 0)
      <section id="story" class="py-20 px-6 bg-base">
        <div class="text-center mb-12" data-aos="fade-up">
          <span class="font-sans text-[10px] tracking-[0.3em] text-accent uppercase block mb-2">Kisah Kami</span>
          <h2 class="font-serif text-4xl text-primary-900 font-bold">Perjalanan Cinta</h2>
        </div>
        
        <div class="relative border-l border-primary-300 ml-4 space-y-10">
          @foreach($ceritas as $cerita)
          <div class="relative pl-6" data-aos="fade-up">
            <div class="absolute -left-2 top-0 w-4 h-4 rounded-full bg-primary-900 border-2 border-white shadow"></div>
            <h4 class="font-serif font-bold text-primary-800 text-xl">{{ $cerita->judul }}</h4>
            <span class="text-[10px] text-accent uppercase tracking-widest block mb-2">{{ \Carbon\Carbon::parse($cerita->tanggal)->translatedFormat('F Y') }}</span>
            <p class="text-sm text-stone-600 bg-white p-4 rounded-r-xl rounded-bl-xl shadow-sm border border-primary-50">{{ $cerita->isi }}</p>
          </div>
          @endforeach
        </div>
      </section>
      @endif

      @if($invitation->is_galeri_aktif && count($galeris) > 0)
      <section id="gallery" class="py-20 px-6 bg-white">
        <div class="text-center mb-12" data-aos="fade-up">
          <span class="font-sans text-[10px] tracking-[0.3em] text-accent uppercase block mb-2">Memori</span>
          <h2 class="font-serif text-4xl text-primary-900 font-bold">Galeri Foto</h2>
        </div>
        
        <div class="columns-2 md:columns-3 gap-3 space-y-3">
          @foreach($galeris as $galeri)
          <div class="overflow-hidden rounded-xl bg-base shadow-sm break-inside-avoid relative group" data-aos="zoom-in">
             <img src="{{ asset('storage/' . $galeri->file_path) }}" class="w-full h-auto object-cover transform transition duration-500 group-hover:scale-110">
             <div class="absolute inset-0 bg-primary-900/0 group-hover:bg-primary-900/40 transition duration-300"></div>
          </div>
          @endforeach
        </div>
      </section>
      @endif

      <!-- RSVP SECTION -->
      <section id="rsvp" class="py-20 px-6 bg-primary-950 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-wedding-foliage opacity-10"></div>
        <div class="relative z-10">
          <div class="text-center mb-10" data-aos="fade-up">
            <span class="font-sans text-[10px] tracking-[0.3em] text-accent uppercase block mb-2">Kehadiran</span>
            <h2 class="font-serif text-4xl font-bold">RSVP</h2>
          </div>
          
          <div class="bg-white/10 backdrop-blur-md rounded-tr-[80px] rounded-bl-[80px] p-8 border border-white/20 shadow-2xl" data-aos="fade-up">
            <form id="rsvp-form" class="space-y-4">
               <div>
                  <label class="text-[10px] uppercase tracking-widest text-primary-200 mb-1 block">Nama Lengkap</label>
                  <input type="text" id="rsvp-name" class="w-full bg-black/20 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-accent" value="{{ request('to') ? ucwords(str_replace('-', ' ', request('to'))) : '' }}" required>
               </div>
               <div>
                  <label class="text-[10px] uppercase tracking-widest text-primary-200 mb-1 block">Konfirmasi Kehadiran</label>
                  <select id="rsvp-status" class="w-full bg-black/20 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-accent" required>
                     <option value="Hadir" class="text-stone-800">Ya, Saya Akan Hadir</option>
                     <option value="Tidak Hadir" class="text-stone-800">Maaf, Tidak Bisa Hadir</option>
                  </select>
               </div>
               <div>
                  <label class="text-[10px] uppercase tracking-widest text-primary-200 mb-1 block">Pesan & Doa</label>
                  <textarea id="rsvp-message" rows="3" class="w-full bg-black/20 border border-white/10 rounded-lg px-4 py-3 text-sm text-white focus:outline-none focus:border-accent" required></textarea>
               </div>
               <button type="submit" class="w-full bg-accent text-primary-950 font-bold uppercase tracking-widest text-xs py-4 rounded-xl shadow-lg hover:bg-white transition-all mt-4">
                  Kirim Konfirmasi
               </button>
            </form>
          </div>
        </div>
      </section>

      <!-- GIFT SECTION -->
      @if($invitation->is_kado_aktif && count($rekenings) > 0)
      <section class="py-20 px-6 bg-base">
        <div class="text-center mb-10" data-aos="fade-up">
          <span class="font-sans text-[10px] tracking-[0.3em] text-accent uppercase block mb-2">Tanda Kasih</span>
          <h2 class="font-serif text-4xl text-primary-900 font-bold mb-4">Wedding Gift</h2>
          <p class="text-sm text-stone-600 max-w-sm mx-auto">Doa restu Anda merupakan karunia yang sangat berarti bagi kami. Namun, jika Anda ingin memberikan tanda kasih, dapat melalui tautan berikut:</p>
        </div>

        <div class="space-y-6 max-w-sm mx-auto">
          @foreach($rekenings as $rek)
          <div class="bg-white rounded-2xl p-6 shadow-sm border border-primary-100 flex items-center justify-between" data-aos="fade-up">
             <div>
                <p class="font-bold text-primary-900">{{ $rek->bank }}</p>
                <p class="text-lg font-mono text-stone-700 my-1" id="rek-{{ $rek->id }}">{{ $rek->no_rekening }}</p>
                <p class="text-xs text-stone-500 uppercase">a.n {{ $rek->nama_pemilik }}</p>
             </div>
             <button onclick="copyRekening('{{ $rek->no_rekening }}')" class="bg-primary-50 text-primary-800 p-3 rounded-full hover:bg-primary-900 hover:text-white transition">
                <i class="fa-regular fa-copy"></i>
             </button>
          </div>
          @endforeach
        </div>
      </section>
      @endif

      <!-- FOOTER -->
      <footer class="py-16 pb-32 bg-primary-950 text-center text-white relative">
         <h2 class="font-serif text-3xl font-bold mb-6">
           {{ $invitation->pria_nama }} <span class="text-accent">&amp;</span> {{ $invitation->wanita_nama }}
         </h2>
         <p class="text-[10px] text-primary-300">Terima kasih atas doa dan restu yang telah diberikan.</p>
         <div class="w-12 h-[1px] bg-accent/50 mx-auto my-6"></div>
         <p class="text-[9px] uppercase tracking-widest text-primary-400">Dibuat dengan dedikasi cinta &copy; {{ date('Y') }} Aufilla Invitation</p>
         <p class="text-[8px] uppercase tracking-widest text-accent/80 font-bold mt-1">Premium Wedding Concierge</p>
      </footer>

    </div>
  </div>

  <!-- FLOATING NAVIGATION -->
  <div id="floating-nav-bar" class="fixed bottom-6 left-1/2 transform -translate-x-1/2 z-40 bg-primary-950/90 backdrop-blur-md rounded-full px-6 py-4 shadow-2xl border border-white/10 flex items-center gap-6 transition-all duration-500 translate-y-32 opacity-0">
    <a href="#hero" class="nav-icon-trigger text-stone-400 hover:text-accent transition-colors"><i class="fa-solid fa-circle-notch"></i></a>
    <a href="#couple" class="nav-icon-trigger text-stone-400 hover:text-accent transition-colors"><i class="fa-solid fa-heart"></i></a>
    <a href="#event" class="nav-icon-trigger text-stone-400 hover:text-accent transition-colors"><i class="fa-solid fa-calendar-alt"></i></a>
    @if($invitation->is_cerita_aktif)
    <a href="#story" class="nav-icon-trigger text-stone-400 hover:text-accent transition-colors"><i class="fa-solid fa-shoe-prints"></i></a>
    @endif
    @if($invitation->is_galeri_aktif)
    <a href="#gallery" class="nav-icon-trigger text-stone-400 hover:text-accent transition-colors"><i class="fa-solid fa-images"></i></a>
    @endif
    <a href="#rsvp" class="nav-icon-trigger text-stone-400 hover:text-accent transition-colors"><i class="fa-solid fa-envelope"></i></a>
  </div>

  <!-- MUSIC BUTTON -->
  <div id="floating-music-trigger" class="fixed bottom-24 right-6 z-40 transition-all duration-500 translate-x-32 opacity-0 hidden md:block">
    <button id="btn-toggle-music" class="w-12 h-12 bg-accent text-primary-950 rounded-full shadow-lg flex items-center justify-center animate-spin-slow">
      <i id="music-icon" class="fa-solid fa-compact-disc text-xl"></i>
    </button>
  </div>

  @if($invitation->musik)
  <audio id="bg-music" loop>
    <source src="{{ asset('storage/' . $invitation->musik) }}" type="audio/mpeg">
  </audio>
  @endif

  <!-- SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    AOS.init({ once: true, offset: 50 });

    $(document).ready(function() {
      // Buka Undangan
      $('#btn-open-invitation').on('click', function() {
        $('#cover-screen').css('transform', 'translateY(-100%)');
        setTimeout(() => {
          $('#cover-screen').hide();
          $('body').removeClass('locked');
          $('#main-content').removeClass('opacity-0');
          $('#floating-nav-bar').removeClass('translate-y-32 opacity-0');
          $('#floating-music-trigger').removeClass('translate-x-32 opacity-0').addClass('translate-x-0 opacity-100');
          
          // Play music
          let audio = document.getElementById('bg-music');
          if(audio) {
            audio.play().catch(e => console.log('Auto-play prevented'));
          }
        }, 1000);
      });

      // Remove Loading Screen
      setTimeout(() => {
        $('#loading-screen').addClass('opacity-0');
        setTimeout(() => {
          $('#loading-screen').hide();
        }, 700);
      }, 1500);

      // Countdown Timer
      const akadDate = "{{ $akad ? $akad->tgl_acara . ' ' . $akad->jam_mulai : '' }}";
      if(akadDate) {
        const countDownDate = new Date(akadDate).getTime();
        setInterval(function() {
          const now = new Date().getTime();
          const distance = countDownDate - now;
          if (distance > 0) {
            $('#dt-days').text(Math.floor(distance / (1000 * 60 * 60 * 24)).toString().padStart(2, '0'));
            $('#dt-hours').text(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0'));
            $('#dt-minutes').text(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0'));
            $('#dt-seconds').text(Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0'));
          }
        }, 1000);
      }

      // Music Toggle
      let isPlaying = true;
      $('#btn-toggle-music').on('click', function() {
        let audio = document.getElementById('bg-music');
        if(!audio) return;
        if (isPlaying) {
          audio.pause();
          $('#music-icon').removeClass('fa-compact-disc').addClass('fa-play');
          $(this).removeClass('animate-spin-slow');
        } else {
          audio.play();
          $('#music-icon').removeClass('fa-play').addClass('fa-compact-disc');
          $(this).addClass('animate-spin-slow');
        }
        isPlaying = !isPlaying;
      });

      // Navigation Scroll Highlight
      const sections = ['#hero', '#couple', '#event', '#story', '#gallery', '#rsvp'];
      $(window).on('scroll', function() {
        const scrollPos = $(window).scrollTop() + 200;
        sections.forEach(function(id) {
          const el = $(id);
          if(el.length) {
            const top = el.offset().top;
            const bottom = top + el.outerHeight();
            if(scrollPos >= top && scrollPos < bottom) {
              $(`a[href="${id}"]`).removeClass('text-stone-400').addClass('text-amber-300 font-bold scale-125 drop-shadow-md');
            } else {
              $(`a[href="${id}"]`).removeClass('text-amber-300 font-bold scale-125 drop-shadow-md').addClass('text-stone-400');
            }
          }
        });
      });

      // Smooth scroll navigation
      $('.nav-icon-trigger').on('click', function(e) {
        e.preventDefault();
        const target = $($(this).attr('href'));
        if(target.length) {
          $('html, body').animate({ scrollTop: target.offset().top }, 800);
        }
      });

      // RSVP Form Submit
      $('#rsvp-form').on('submit', function(e) {
        e.preventDefault();
        const data = {
          invitation_id: '{{ $invitation->id }}',
          nama: $('#rsvp-name').val(),
          status_kehadiran: $('#rsvp-status').val(),
          pesan: $('#rsvp-message').val(),
          _token: $('meta[name="csrf-token"]').attr('content')
        };
        
        $.ajax({
          url: '/rsvp',
          method: 'POST',
          data: data,
          success: function(res) {
            Swal.fire({
              icon: 'success',
              title: 'Terima Kasih!',
              text: 'Konfirmasi kehadiran dan pesan Anda telah terkirim.',
              confirmButtonColor: '#99005c'
            });
            $('#rsvp-form')[0].reset();
          },
          error: function(err) {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Terjadi kesalahan. Silakan coba lagi.'
            });
          }
        });
      });
    });

    function copyRekening(no) {
      navigator.clipboard.writeText(no).then(() => {
        Swal.fire({
          icon: 'success',
          title: 'Tersalin',
          text: 'Nomor rekening ' + no + ' berhasil disalin!',
          timer: 1500,
          showConfirmButton: false
        });
      });
    }
  </script>
</body>
</html>
EOD;

file_put_contents($target, $html);
echo "Aufilla Diff completely generated from scratch using single-column Magazine layout!\n";
