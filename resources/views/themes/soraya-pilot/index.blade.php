<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="color-scheme" content="light only">
  <meta name="supported-color-schemes" content="light">

  <title>{{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }} - Undangan Pernikahan</title>
  @php
    $ogUrl  = str_replace('http://', 'https://', url('/' . $invitation->slug));
    $ogImg  = $invitation->cover_img
        ? str_replace('http://', 'https://', asset('storage/' . $invitation->cover_img))
        : str_replace('http://', 'https://', asset('assets/default/default-pasangan.jpg'));
    $ogDesc = 'Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir di acara pernikahan kami pada ' . (isset($resepsi) ? $resepsi->tgl_acara->translatedFormat('l, d F Y') : (isset($akad) ? $akad->tgl_acara->translatedFormat('l, d F Y') : 'hari yang telah ditentukan')) . '.';
  @endphp
  <!-- Meta Data & Open Graph untuk WhatsApp / Sosmed -->
  <meta name="description" content="{{ $ogDesc }}">
  <meta property="og:url" content="{{ $ogUrl }}">
  <meta property="og:site_name" content="Aufilla Digital Invitation">
  <meta property="og:locale" content="id_ID">
  <meta property="og:type" content="article">
  <meta property="og:title" content="Undangan Pernikahan: {{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}">
  <meta property="og:description" content="{{ $ogDesc }}">
  <meta property="og:image" content="{{ $ogImg }}">
  <meta property="og:image:secure_url" content="{{ $ogImg }}">
  <meta property="og:image:width" content="800">
  <meta property="og:image:height" content="600">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Undangan Pernikahan: {{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}">
  <meta name="twitter:description" content="{{ $ogDesc }}">
  <meta name="twitter:image:src" content="{{ $ogImg }}">
  
  <!-- Google Fonts: Playfair Display, Great Vibes, Montserrat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  
  <!-- Favicon -->
  <link rel="icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">
  <link rel="shortcut icon" href="{{ asset('assets/img/logo-icon.png') }}" type="image/png">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              900: '#3D171C', // Dark brown/maroon as in reference
              800: '#4A1E24',
              700: '#5C252D',
            },
            accent: '#B8860B', // Dark goldenrod
          },
          fontFamily: {
            serif: ['Playfair Display', 'serif'],
            sans: ['Montserrat', 'sans-serif'],
            script: ['Great Vibes', 'cursive'],
          }
        }
      }
    }
  </script>

  <style>
    .locked { overflow: hidden; }
    
    .text-vertical {
      writing-mode: vertical-rl;
      text-orientation: mixed;
      transform: rotate(180deg);
    }
    
    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Gallery Lightbox */
    #lightbox {
      backdrop-filter: blur(8px);
    }

    /* Ornament Patterns */
    .ornament-dots {
      background-image: radial-gradient(circle, rgba(74,30,36,0.04) 1.5px, transparent 1.5px);
      background-size: 24px 24px;
    }
    .ornament-corner::before,
    .ornament-corner::after {
      content: '';
      position: absolute;
      width: 120px;
      height: 120px;
      border: 1.5px solid rgba(74,30,36,0.08);
      border-radius: 0 60px 0 60px;
      pointer-events: none;
    }
    .ornament-corner::before {
      top: 24px; left: 24px;
      border-right: none; border-bottom: none;
    }
    .ornament-corner::after {
      bottom: 24px; right: 24px;
      border-left: none; border-top: none;
      border-radius: 60px 0 60px 0;
    }
    .ornament-leaf::before {
      content: '\f4d8';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      font-size: 8rem;
      color: rgba(74,30,36,0.03);
      top: 50%;
      right: -20px;
      transform: translateY(-50%) rotate(15deg);
      pointer-events: none;
    }

    /* Wish card hover */
    .wish-card {
      transition: all 0.3s ease;
    }
    .wish-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }
  </style>
</head>

<body class="font-sans text-stone-800 bg-[#F9F9F9] relative selection:bg-brand-800 selection:text-white locked">

  <!-- 1. LOADING SCREEN -->
  <div id="loading-screen" class="fixed inset-0 bg-brand-900 z-[99] flex flex-col justify-center items-center transition-all duration-700 ease-out">
    <div class="flex flex-col items-center">
      <div class="relative w-24 h-24 flex items-center justify-center">
        <div class="absolute inset-0 border-2 border-white/20 border-t-white rounded-full animate-spin"></div>
        <span class="font-serif text-3xl font-bold text-white relative z-10 leading-none">{{ strtoupper(substr($invitation->pria_nama, 0, 1)) }}&amp;{{ strtoupper(substr($invitation->wanita_nama, 0, 1)) }}</span>
      </div>
      <p class="font-serif text-white/80 mt-6 tracking-widest uppercase text-sm animate-pulse">Menyiapkan Undangan...</p>
    </div>
  </div>

  <!-- MAIN SCROLLABLE WRAPPER -->
  <div id="main-wrapper" class="w-full relative min-h-screen overflow-x-hidden">

    <!-- COVER SCREEN OVERLAY -->
    <!-- Reference 1 Style: Full image background, dark overlay, white card at bottom left -->
    <div id="cover-screen" class="fixed inset-0 z-50 transition-all duration-1000 ease-in-out bg-cover bg-center" style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}');">
      
      <!-- Gradient overlay to make text readable -->
      <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/60"></div>
      
      <!-- Top Text & Names -->
      <div class="absolute top-12 left-0 right-0 text-center px-6 z-10">
        <p class="font-sans text-white/90 text-[10px] tracking-[0.3em] uppercase mb-3">Undangan Pernikahan</p>
        <p class="font-sans text-white/70 text-xs tracking-widest uppercase mb-6">The Wedding Of</p>
        
        <h1 class="font-serif text-5xl md:text-8xl text-white font-bold drop-shadow-lg text-center leading-tight">
           {{ $invitation->pria_nama }} <br>
           <span class="font-script text-4xl md:text-7xl font-normal text-white/90 block my-1 md:my-2">&amp;</span>
           {{ $invitation->wanita_nama }}
        </h1>
      </div>

      <!-- Bottom White Card Overlap (Ref 1 Style) -->
      <div class="absolute bottom-0 left-0 w-[90%] md:w-[60%] lg:w-[45%] bg-white rounded-tr-[80px] p-8 md:p-12 z-20 shadow-[10px_-10px_30px_rgba(0,0,0,0.15)] flex flex-col justify-center transition-transform duration-1000" id="cover-card">
        
        <p class="font-serif italic text-brand-800 text-sm md:text-base mb-2">Kepada Yth. Bapak/Ibu/Saudara/i</p>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-brand-900 mb-2 truncate">
          {{ request('to') ? ucwords(str_replace('-', ' ', request('to'))) : 'Tamu Terhormat' }}
        </h2>
        <p class="text-[11px] text-stone-500 italic mb-4">*Mohon maaf apabila ada kesalahan penulisan nama/gelar</p>
        
        <p class="text-sm md:text-base text-stone-600 leading-relaxed mb-8">
          Tanpa mengurangi rasa hormat, kami mengundang Anda untuk hadir dan memberikan doa restu di acara pernikahan kami.
        </p>
        
        <button id="btn-open-invitation" class="self-start inline-flex items-center gap-3 bg-brand-800 text-white font-sans font-medium tracking-widest uppercase text-xs px-8 py-4 rounded-full shadow-lg transition-all duration-300 hover:bg-brand-900 active:scale-95 cursor-pointer">
          <i class="fa-solid fa-envelope-open text-sm"></i>
          <span>Buka Undangan</span>
        </button>
      </div>
    </div>


    <!-- MAIN CONTENT (Opacity 0 initially) -->
    <div id="main-content" class="w-full relative opacity-0 pointer-events-none">

      <!-- HERO SECTION -->
      <section id="hero" class="relative w-full min-h-screen flex flex-col items-center justify-center text-center overflow-hidden ornament-leaf">
        <!-- Background Image with Parallax effect -->
        <div class="absolute inset-0 z-0">
          <img src="{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}" class="w-full h-full object-cover" alt="Hero">
          <div class="absolute inset-0 bg-brand-900/60 mix-blend-multiply"></div>
          <div class="absolute inset-0 bg-gradient-to-t from-[#F9F9F9] via-transparent to-transparent"></div>
        </div>
        
        <!-- Content -->
        <div class="relative z-10 px-6 max-w-3xl" data-aos="fade-up" data-aos-duration="1500">
           <i class="fa-solid fa-quote-right text-4xl text-accent/50 mb-6"></i>
           <p class="font-serif italic text-white text-xl md:text-3xl leading-relaxed mb-6 font-light drop-shadow-md">
             "{{ $invitation->kutipan_teks ?? 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya diantaramu rasa kasih dan sayang.' }}"
           </p>
           <p class="font-sans text-xs text-white/80 tracking-[0.3em] uppercase font-bold">{{ $invitation->kutipan_sumber ?? 'QS. Ar-Rum: 21' }}</p>
        </div>
      </section>

      <!-- MEMPELAI (Ref 4 Style: Asymmetric Vertical Blocks) -->
      <section id="couple" class="relative py-16 px-6 bg-white overflow-hidden ornament-corner">
        <div class="max-w-4xl mx-auto flex flex-col items-center text-center mb-16" data-aos="fade-up">
           <h2 class="font-script text-5xl md:text-6xl text-brand-800 mb-2">Mempelai</h2>
           <p class="font-sans text-xs tracking-widest uppercase text-stone-500 mb-4">Dua Hati Menjadi Satu</p>
           <p class="text-sm md:text-base leading-relaxed text-stone-600 max-w-2xl">
             Dengan memohon rahmat dan ridho Allah SWT, kami bermaksud mengundang Bapak/Ibu/Saudara/i ke acara pernikahan kami:
           </p>
        </div>

        <div class="max-w-3xl mx-auto space-y-24">
          
          <!-- BRIDE CARD -->
          <div class="flex flex-col md:flex-row gap-6 md:gap-10 items-center md:items-start" data-aos="fade-up">
            <!-- Image with Vertical Label -->
            <div class="relative flex w-64 md:w-80 shrink-0">
               <div class="w-12 bg-brand-800 flex items-center justify-center rounded-l-md">
                 <span class="text-white text-vertical font-serif tracking-[0.2em] text-sm py-8 uppercase">The Bride</span>
               </div>
               <div class="flex-1 h-[350px] md:h-[450px] rounded-tr-[80px] rounded-bl-[40px] overflow-hidden shadow-lg border-2 border-white">
                 <img src="{{ $invitation->wanita_foto ? asset('storage/' . $invitation->wanita_foto) : asset('assets/default/default_wanita.jpg') }}" class="w-full h-full object-cover" alt="Bride">
               </div>
            </div>
            <!-- Text Details -->
            <div class="flex-1 text-center md:text-left pt-4 md:pt-12">
               <h3 class="font-serif text-3xl text-brand-900 mb-4">{{ $invitation->wanita_nama_lengkap }}</h3>
               <p class="font-serif italic text-brand-800 text-sm mb-2">Putri dari</p>
               <p class="font-sans text-sm text-stone-700 leading-relaxed">
                 Bapak <span class="font-semibold">{{ $invitation->wanita_ayah }}</span> <br>
                 dan Ibu <span class="font-semibold">{{ $invitation->wanita_ibu }}</span>
               </p>
               <div class="mt-6 flex justify-center md:justify-start gap-3">
                 <div class="w-8 h-8 rounded-full bg-brand-800 text-white flex items-center justify-center text-xs"><i class="fa-brands fa-instagram"></i></div>
               </div>
            </div>
          </div>

          <!-- SEPARATOR -->
          <div class="flex items-center justify-center gap-4" data-aos="zoom-in">
             <div class="h-[1px] w-24 bg-brand-800/30"></div>
             <span class="font-script text-5xl text-brand-800 -mt-2">&amp;</span>
             <div class="h-[1px] w-24 bg-brand-800/30"></div>
          </div>

          <!-- GROOM CARD -->
          <div class="flex flex-col md:flex-row-reverse gap-6 md:gap-10 items-center md:items-start" data-aos="fade-up">
            <!-- Image with Vertical Label -->
            <div class="relative flex w-64 md:w-80 shrink-0">
               <div class="flex-1 h-[350px] md:h-[450px] rounded-tl-[80px] rounded-br-[40px] overflow-hidden shadow-lg border-2 border-white z-10 relative">
                 <img src="{{ $invitation->pria_foto ? asset('storage/' . $invitation->pria_foto) : asset('assets/default/default_pria.jpg') }}" class="w-full h-full object-cover" alt="Groom">
               </div>
               <div class="w-12 bg-brand-800 flex items-center justify-center rounded-r-md -ml-2 z-0">
                 <span class="text-white text-vertical font-serif tracking-[0.2em] text-sm py-8 uppercase">The Groom</span>
               </div>
            </div>
            <!-- Text Details -->
            <div class="flex-1 text-center md:text-right pt-4 md:pt-12">
               <h3 class="font-serif text-3xl text-brand-900 mb-4">{{ $invitation->pria_nama_lengkap }}</h3>
               <p class="font-serif italic text-brand-800 text-sm mb-2">Putra dari</p>
               <p class="font-sans text-sm text-stone-700 leading-relaxed">
                 Bapak <span class="font-semibold">{{ $invitation->pria_ayah }}</span> <br>
                 dan Ibu <span class="font-semibold">{{ $invitation->pria_ibu }}</span>
               </p>
               <div class="mt-6 flex justify-center md:justify-end gap-3">
                 <div class="w-8 h-8 rounded-full bg-brand-800 text-white flex items-center justify-center text-xs"><i class="fa-brands fa-instagram"></i></div>
               </div>
            </div>
          </div>

        </div>
      </section>

      <!-- ACARA (Ref 2 Style: Image Top, Vertical Label Left, Details Right) -->
      <section id="event" class="relative py-24 px-6 bg-[#F9F9F9] overflow-hidden ornament-dots">
        
        <div class="max-w-4xl mx-auto flex flex-col items-center text-center mb-16" data-aos="fade-up">
           <div class="relative w-full max-w-[300px] mb-8">
             <div class="absolute top-1/2 left-0 right-0 h-[1px] bg-brand-800/30"></div>
             <h2 class="font-script text-6xl md:text-7xl text-brand-800 relative z-10 bg-[#F9F9F9] px-6 inline-block">Wedding <br><span class="ml-12">Event</span></h2>
           </div>
        </div>

        <div class="max-w-xl mx-auto space-y-12">
          
          @php
              $coverUrl = $invitation->cover_img ? (str_starts_with($invitation->cover_img, 'assets/') ? asset($invitation->cover_img) : asset('storage/' . $invitation->cover_img)) : asset('assets/default/default-pasangan.jpg');
              $eventImg1 = $coverUrl;
              $eventImg2 = $coverUrl;
              
              if (isset($galeris) && count($galeris) > 0) {
                  $firstGal = $galeris->first();
                  $eventImg1 = str_starts_with($firstGal->image_path, 'assets/') ? asset($firstGal->image_path) : asset('storage/' . $firstGal->image_path);
                  
                  if (count($galeris) > 1) {
                      $secondGal = $galeris->get(1);
                      $eventImg2 = str_starts_with($secondGal->image_path, 'assets/') ? asset($secondGal->image_path) : asset('storage/' . $secondGal->image_path);
                  } else {
                      $eventImg2 = $eventImg1;
                  }
              }
          @endphp
          
          @if($akad)
          <!-- AKAD CARD -->
          <div class="bg-white shadow-2xl rounded-tr-[80px] rounded-tl-[10px] rounded-b-[10px] overflow-hidden" data-aos="fade-up">
            <!-- Top Image -->
            <div class="w-full bg-stone-100 flex items-center justify-center overflow-hidden">
               <img src="{{ $eventImg1 }}" class="w-full h-auto max-h-[400px] object-contain" alt="Akad Image">
            </div>
            <!-- Bottom Details Split -->
            <div class="flex flex-row">
              <!-- Left Vertical Strip -->
              <div class="w-16 md:w-24 bg-brand-800 flex items-center justify-center shrink-0">
                <span class="text-white text-vertical font-serif tracking-[0.2em] text-sm md:text-lg py-8 uppercase">{{ $akad->nama_acara ?? 'Akad Nikah' }}</span>
              </div>
              <!-- Right Info -->
              <div class="flex-1 p-4 md:p-5 flex flex-col justify-center">
                <h3 class="font-serif text-xl md:text-2xl font-bold text-brand-900 mb-1">{{ \Carbon\Carbon::parse($akad->tgl_acara)->translatedFormat('l, d F Y') }}</h3>
                <p class="font-sans text-xs md:text-sm text-stone-600 mb-3">Pukul {{ substr($akad->waktu_mulai, 0, 5) }} WIB - Selesai</p>
                
                <div class="w-full h-[1px] bg-stone-300 mb-3"></div>
                
                <h4 class="font-serif text-lg font-bold text-brand-900 mb-1">Lokasi</h4>
                <p class="font-sans text-xs md:text-sm text-stone-700 mb-3 font-medium">{{ $akad->tempat }}</p>
                
                <a href="{{ $akad->gmaps_link ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($akad->tempat . ' ' . $akad->alamat) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-brand-800 text-white font-sans text-[10px] md:text-xs px-4 py-2 md:px-5 md:py-2.5 rounded-md hover:bg-brand-900 transition-colors w-max">
                  <i class="fa-solid fa-map-location-dot"></i> Google Maps Lokasi
                </a>
              </div>
            </div>
          </div>
          @endif

          @if($resepsi)
          <!-- RESEPSI CARD -->
          <div class="bg-white shadow-2xl rounded-tl-[80px] rounded-tr-[10px] rounded-b-[10px] overflow-hidden" data-aos="fade-up">
            <!-- Top Image -->
            <div class="w-full bg-stone-100 flex items-center justify-center overflow-hidden">
               <img src="{{ $eventImg2 }}" class="w-full h-auto max-h-[400px] object-contain" alt="Resepsi Image">
            </div>
            <!-- Bottom Details Split -->
            <div class="flex flex-row-reverse">
              <!-- Right Vertical Strip -->
              <div class="w-16 md:w-24 bg-brand-800 flex items-center justify-center shrink-0">
                <span class="text-white text-vertical font-serif tracking-[0.2em] text-sm md:text-lg py-8 uppercase">{{ $resepsi->nama_acara ?? 'Resepsi' }}</span>
              </div>
              <!-- Left Info -->
              <div class="flex-1 p-4 md:p-5 flex flex-col justify-center text-right items-end">
                <h3 class="font-serif text-xl md:text-2xl font-bold text-brand-900 mb-1">{{ \Carbon\Carbon::parse($resepsi->tgl_acara)->translatedFormat('l, d F Y') }}</h3>
                <p class="font-sans text-xs md:text-sm text-stone-600 mb-3">Pukul {{ substr($resepsi->waktu_mulai, 0, 5) }} WIB - Selesai</p>
                
                <div class="w-full h-[1px] bg-stone-300 mb-3"></div>
                
                <h4 class="font-serif text-lg font-bold text-brand-900 mb-1">Lokasi</h4>
                <p class="font-sans text-xs md:text-sm text-stone-700 mb-3 font-medium">{{ $resepsi->tempat }}</p>
                
                <a href="{{ $resepsi->gmaps_link ?: 'https://www.google.com/maps/search/?api=1&query=' . urlencode($resepsi->tempat . ' ' . $resepsi->alamat) }}" target="_blank" class="inline-flex items-center justify-center gap-2 bg-brand-800 text-white font-sans text-[10px] md:text-xs px-4 py-2 md:px-5 md:py-2.5 rounded-md hover:bg-brand-900 transition-colors w-max">
                  <i class="fa-solid fa-map-location-dot"></i> Google Maps Lokasi
                </a>
              </div>
            </div>
          </div>
          @endif
          
        </div>
      </section>

      <!-- CERITA (Ref 3 Style: Dark Brown Background, White Timeline) -->
      @if($invitation->is_cerita_aktif && isset($ceritas) && count($ceritas) > 0)
      <section id="story" class="relative py-24 px-6 bg-brand-900 text-white overflow-hidden">
        
        <div class="max-w-4xl mx-auto mb-16" data-aos="fade-up">
           <div class="relative w-full mb-8">
             <div class="absolute top-1/2 left-0 right-0 h-[1px] bg-white/30"></div>
             <h2 class="font-script text-6xl md:text-7xl text-white relative z-10 bg-brand-900 pr-6 inline-block">Our<br><span class="ml-12">Story</span></h2>
           </div>
        </div>

        <div class="max-w-3xl mx-auto relative pl-8 md:pl-12 border-l border-white/40">
           @foreach($ceritas as $index => $cerita)
           <div class="mb-16 relative" data-aos="fade-up">
             <!-- Heart Icon on timeline -->
             <div class="absolute -left-[45px] md:-left-[61px] top-4 w-6 h-6 bg-brand-900 rounded-full border border-white flex items-center justify-center text-white text-[10px]">
               <i class="fa-solid fa-heart"></i>
             </div>
             
             <!-- Story Card -->
             <div class="bg-white text-stone-800 p-6 md:p-8 rounded-xl shadow-lg relative">
               <!-- Arrow pointing to timeline -->
               <div class="absolute top-6 -left-2 w-4 h-4 bg-white rotate-45"></div>
               
               <h4 class="font-serif font-bold text-2xl text-brand-900 mb-1">{{ $cerita->judul }}</h4>
                 @php
                   $tanggalTampil = $cerita->tanggal;
                   try {
                     $tanggalTampil = \Carbon\Carbon::parse($cerita->tanggal)->translatedFormat('d F Y');
                   } catch (\Exception $e) {}
                 @endphp
                <p class="font-sans text-xs text-brand-800 uppercase tracking-widest font-semibold mb-4">{{ $tanggalTampil }}</p>
               <p class="font-sans text-sm leading-relaxed text-stone-600">{{ $cerita->isi_cerita }}</p>
             </div>
           </div>
           @endforeach
        </div>
      </section>
      @endif

      <!-- GALERI (Fixing image loads) -->
      @if($invitation->is_galeri_aktif && isset($galeris) && count($galeris) > 0)
      <section id="gallery" class="relative py-24 px-6 bg-white overflow-hidden ornament-corner">
        <div class="max-w-4xl mx-auto text-center mb-16" data-aos="fade-up">
           <h2 class="font-script text-5xl md:text-6xl text-brand-800 mb-2">Galeri Foto</h2>
           <p class="font-sans text-xs tracking-widest uppercase text-stone-500">Momen Bahagia Kami</p>
        </div>

        <div class="max-w-5xl mx-auto columns-2 md:columns-3 gap-4 space-y-4">
           @foreach($galeris as $galeri)
           @if($galeri->image_path)
           @php
             $galUrl = str_starts_with($galeri->image_path, 'assets/') ? asset($galeri->image_path) : asset('storage/' . $galeri->image_path);
           @endphp
           <div class="relative group rounded-lg overflow-hidden cursor-pointer shadow-sm break-inside-avoid gallery-trigger" data-src="{{ $galUrl }}">
             <img src="{{ $galUrl }}" class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-700" alt="Gallery">
             <div class="absolute inset-0 bg-brand-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
               <i class="fa-solid fa-expand text-white text-3xl"></i>
             </div>
           </div>
           @endif
           @endforeach
        </div>
      </section>
      @endif

      <!-- RSVP & GIFT -->
      <section id="rsvp" class="relative py-24 px-6 bg-[#F9F9F9] overflow-hidden ornament-dots ornament-corner">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16">
          
          <!-- RSVP -->
          <div data-aos="fade-right">
             <div class="mb-10">
               <h2 class="font-script text-5xl md:text-6xl text-brand-800 mb-2">Buku Tamu</h2>
               <p class="font-sans text-xs tracking-widest uppercase text-stone-500">Kehadiran dan doa restu Anda sangat berarti</p>
             </div>
             
             <form id="rsvp-form" class="bg-white p-6 md:p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.06)] border border-stone-100 mb-10 relative overflow-hidden">
                <!-- Accent line top -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-brand-900 via-brand-800 to-brand-700"></div>
                
                <div class="mb-5">
                  <label class="block font-sans text-[10px] uppercase tracking-[0.2em] text-stone-400 mb-2">Nama Anda</label>
                  <input type="text" id="rsvp-name" placeholder="Masukkan nama lengkap" class="w-full bg-stone-50/80 border border-stone-200 rounded-xl px-5 py-3.5 text-sm focus:outline-none focus:border-brand-800 focus:ring-2 focus:ring-brand-800/10 transition-all" required>
                </div>
                <div class="mb-5">
                  <label class="block font-sans text-[10px] uppercase tracking-[0.2em] text-stone-400 mb-2">Konfirmasi Kehadiran</label>
                  <select id="rsvp-status" class="w-full bg-stone-50/80 border border-stone-200 rounded-xl px-5 py-3.5 text-sm focus:outline-none focus:border-brand-800 focus:ring-2 focus:ring-brand-800/10 transition-all" required>
                    <option value="" disabled selected>Apakah Anda akan hadir?</option>
                    <option value="Hadir">Ya, Saya Akan Hadir</option>
                    <option value="Tidak Hadir">Maaf, Saya Tidak Bisa Hadir</option>
                    <option value="Ragu">Masih Ragu-ragu</option>
                  </select>
                </div>
                <div class="mb-6">
                  <label class="block font-sans text-[10px] uppercase tracking-[0.2em] text-stone-400 mb-2">Doa & Ucapan</label>
                  <textarea id="rsvp-message" placeholder="Tuliskan doa & ucapan terbaik Anda..." rows="3" class="w-full bg-stone-50/80 border border-stone-200 rounded-xl px-5 py-3.5 text-sm focus:outline-none focus:border-brand-800 focus:ring-2 focus:ring-brand-800/10 transition-all resize-none" required></textarea>
                </div>
                <button type="submit" id="btn-submit-rsvp" class="w-full bg-brand-800 text-white font-sans font-semibold uppercase tracking-[0.2em] text-xs py-4 rounded-full hover:bg-brand-900 transition-all shadow-lg hover:shadow-brand-900/30 active:scale-[0.98]">
                  <i class="fa-solid fa-paper-plane mr-2"></i>
                  <span id="btn-submit-text">Kirim Ucapan</span>
                </button>
             </form>

             <!-- Scrollable list of wishes -->
             <div class="max-h-[400px] overflow-y-auto space-y-4 pr-2 hide-scrollbar" id="wishes-list">
                @if(isset($wishes) && count($wishes) > 0)
                  @foreach($wishes as $wish)
                  <div class="wish-card bg-white p-5 rounded-2xl border border-stone-100 shadow-[0_2px_10px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-brand-800/60 rounded-full"></div>
                    <div class="pl-3">
                      <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-2">
                          <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-800 flex items-center justify-center text-xs font-bold font-serif shrink-0">{{ strtoupper(substr($wish->nama, 0, 1)) }}</div>
                          <h4 class="font-serif font-bold text-brand-900 text-sm">{{ $wish->nama }}</h4>
                        </div>
                        <span class="text-[10px] text-stone-400">{{ $wish->created_at->diffForHumans() }}</span>
                      </div>
                      <div class="mb-2">
                        @if($wish->kehadiran == 'hadir')
                        <span class="text-[10px] bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full font-medium"><i class="fa-solid fa-circle-check mr-1"></i> Hadir</span>
                        @elseif($wish->kehadiran == 'tidak hadir' || $wish->kehadiran == 'tidak_hadir')
                        <span class="text-[10px] bg-rose-50 text-rose-600 px-2.5 py-1 rounded-full font-medium"><i class="fa-solid fa-circle-xmark mr-1"></i> Berhalangan</span>
                        @else
                        <span class="text-[10px] bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full font-medium"><i class="fa-solid fa-circle-question mr-1"></i> Ragu</span>
                        @endif
                      </div>
                      <p class="font-sans text-sm text-stone-600 italic leading-relaxed">"{{ $wish->pesan }}"</p>
                    </div>
                  </div>
                  @endforeach
                @else
                  <p class="text-center text-sm text-stone-500 py-8 italic" id="empty-wish-msg">Belum ada ucapan. Jadilah yang pertama.</p>
                @endif
             </div>
          </div>

          <!-- GIFT -->
          @if($invitation->is_kado_aktif && isset($kados) && count($kados) > 0)
          <div data-aos="fade-left">
             <h2 class="font-serif text-4xl font-bold text-brand-900 mb-2">Wedding Gift</h2>
             <p class="font-sans text-sm text-stone-500 mb-8">Bagi Anda yang ingin memberikan tanda kasih.</p>
             
             <div class="space-y-6">
                @foreach($kados as $kado)
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-brand-800 flex items-center justify-between">
                  <div>
                    <h4 class="font-sans font-bold text-brand-900 uppercase text-xs tracking-widest mb-2">{{ $kado->nama_bank }}</h4>
                    <p class="font-serif text-2xl font-bold text-stone-800 mb-1">{{ $kado->no_rekening ??'Nomor Rekening' }}</p>
                    <p class="font-sans text-xs text-stone-500 uppercase">A.N. {{ $kado->nama_pemilik ??'Atas Nama' }}</p>
                  </div>
                  <button class="btn-copy-account w-12 h-12 rounded-full bg-brand-50 text-brand-800 flex items-center justify-center hover:bg-brand-800 hover:text-white transition-colors" data-account="{{ $kado->no_rekening }}">
                    <i class="fa-regular fa-copy"></i>
                  </button>
                </div>
                @endforeach
                
                @if($invitation->alamat_kado)
                <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-brand-800 flex items-center justify-between">
                  <div class="flex-1">
                    <h4 class="font-sans font-bold text-brand-900 uppercase text-xs tracking-widest mb-2"><i class="fa-solid fa-gift mr-1"></i> Kirim Kado Fisik</h4>
                    <p class="font-sans text-sm text-stone-700 leading-relaxed">{{ $invitation->alamat_kado }}</p>
                  </div>
                  <button class="btn-copy-account w-12 h-12 shrink-0 ml-4 rounded-full bg-brand-50 text-brand-800 flex items-center justify-center hover:bg-brand-800 hover:text-white transition-colors" data-account="{{ $invitation->alamat_kado }}">
                    <i class="fa-regular fa-copy"></i>
                  </button>
                </div>
                @endif
             </div>
          </div>
          @endif
        </div>
      </section>

      <!-- FOOTER -->
      <footer class="relative min-h-[60vh] md:min-h-[50vh] bg-black flex flex-col justify-end items-end overflow-hidden">
        
        <!-- Fading Background Slider -->
        <div id="footer-bg-slider" class="absolute inset-0 z-0 bg-cover bg-center transition-opacity duration-1000 ease-in-out" style="background-image: url('{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}'); opacity: 1;"></div>
        
        <!-- Subtle gradient overlay -->
        <div class="absolute inset-0 z-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent pointer-events-none"></div>
        
        <!-- White card overlay at bottom right -->
        <div class="relative z-10 w-[90%] md:w-[65%] lg:w-[50%] bg-white rounded-tl-[80px] p-8 md:p-12 pb-10 md:pb-16 mb-0 shadow-2xl" data-aos="fade-up">
           <h2 class="font-script text-5xl md:text-6xl text-brand-800 mb-4">Terima Kasih</h2>
           <p class="font-sans text-xs md:text-sm text-stone-600 leading-relaxed mb-8 max-w-md">
             Keberadaan serta untaian doa tulus Bapak/Ibu/Saudara/i sangatlah berharga bagi hidup baru kami yang akan dimulai.
           </p>
           
           <h3 class="font-serif text-3xl md:text-4xl font-bold text-brand-900 mb-8">{{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}</h3>
           
           <!-- Branding -->
           <div class="border-t border-stone-200 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
             <p class="font-sans text-[10px] md:text-xs text-stone-400">Dibuat dengan dedikasi cinta &copy; 2026 Aufilla Invitation.</p>
             <div class="flex gap-3">
               <a href="#" class="w-8 h-8 rounded-full bg-brand-50 text-brand-800 flex items-center justify-center hover:bg-brand-800 hover:text-white transition-colors"><i class="fa-brands fa-instagram"></i></a>
               <a href="#" class="w-8 h-8 rounded-full bg-brand-50 text-brand-800 flex items-center justify-center hover:bg-brand-800 hover:text-white transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
             </div>
           </div>
        </div>
      </footer>

    </div> <!-- End of #main-content -->
  </div> <!-- End of #main-wrapper -->


  <!-- QR MODAL IF NEEDED -->
  @php
     $tamuAktif = $tamu ?? (request('to') ? \App\Models\Tamu::where('nama_tamu', str_replace('-', ' ', request('to')))->first() : null);
     $qrAktif = $qrCode ?? ($tamuAktif ? \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($tamuAktif->kode_qr) : null);
  @endphp
  @if($tamuAktif && $tamuAktif->kode_qr)
  <div id="qr-modal" class="fixed inset-0 z-[100] bg-black/80 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 px-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full overflow-hidden transform scale-95 transition-transform duration-300" id="qr-modal-content">
      <div class="bg-brand-900 p-4 flex justify-between items-center text-white">
        <h3 class="font-serif font-bold text-lg">QR Akses Masuk</h3>
        <button id="close-qr-modal" class="text-white hover:text-stone-300"><i class="fa-solid fa-xmark text-xl"></i></button>
      </div>
      <div class="p-8 flex flex-col items-center">
        <div class="bg-white p-2 border-4 border-stone-100 rounded-lg shadow-sm mb-4">
          {!! $qrAktif !!}
        </div>
        <p class="font-serif text-2xl font-bold text-brand-900 mb-1">{{ ucwords($tamuAktif->nama_tamu) }}</p>
        <span class="font-sans text-xs tracking-widest uppercase text-stone-500">{{ $tamuAktif->kode_qr }}</span>
      </div>
    </div>
  </div>
  @endif


  <!-- LIGHTBOX FOR GALLERY -->
  <div id="lightbox" class="fixed inset-0 z-[110] bg-black/90 flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300 p-4">
    <button id="close-lightbox" class="absolute top-6 right-6 text-white hover:text-gray-300 text-3xl cursor-pointer p-2">&times;</button>
    <img id="lightbox-img" src="" alt="Gallery" class="max-w-full max-h-[85vh] object-contain rounded-md shadow-2xl">
  </div>


  <!-- FLOATING CONTROLS -->
  <button id="btn-toggle-music" class="fixed bottom-6 left-6 z-[60] w-12 h-12 bg-white text-brand-900 rounded-full shadow-lg flex items-center justify-center transform translate-y-24 opacity-0 transition-all duration-500 hover:bg-stone-100">
    <i id="music-icon" class="fa-solid fa-music"></i>
  </button>
  
  <button id="qr-btn" class="fixed bottom-20 left-6 z-[60] w-12 h-12 bg-brand-800 text-white rounded-full shadow-lg flex items-center justify-center transform translate-y-24 opacity-0 transition-all duration-500 hover:bg-brand-900">
    <i class="fa-solid fa-qrcode"></i>
  </button>

  <button id="btn-back-to-top" class="fixed bottom-6 right-6 z-[60] w-12 h-12 bg-brand-900 text-white rounded-full shadow-lg flex items-center justify-center opacity-0 pointer-events-none transition-all duration-300 hover:bg-brand-800">
    <i class="fa-solid fa-chevron-up"></i>
  </button>

  <!-- TOAST NOTIFICATION -->
  <div id="toast" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[100] bg-brand-900 text-white px-6 py-3 rounded-full shadow-xl opacity-0 pointer-events-none translate-y-[-10px] transition-all duration-300 font-sans text-xs tracking-wide">
    <span id="toast-message">Notifikasi</span>
  </div>


  <!-- JQUERY & SCRIPTS -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <audio id="bg-music" loop preload="auto">
    @if($invitation->music_file)
    <source src="{{ asset('storage/' . $invitation->music_file) }}" type="audio/mpeg">
    @else
    <source src="{{ asset('assets/default/default-music.mp3') }}" type="audio/mpeg">
    @endif
  </audio>

  <script>
        $(window).on('load', function() {
      setTimeout(function() {
        $('#loading-screen').addClass('opacity-0 pointer-events-none');
      }, 500);
    });
    // Fallback just in case
    setTimeout(function() {
      $('#loading-screen').addClass('opacity-0 pointer-events-none');
    }, 2000);
    
    $(document).ready(function() {
      
      const bgMusic = document.getElementById('bg-music');
      let musicIsPlaying = false;

      // OPEN INVITATION
      $('#btn-open-invitation').on('click', function() {
        $('#cover-card').addClass('translate-y-full opacity-0');
        $('#cover-screen').addClass('-translate-y-full opacity-0 pointer-events-none').css('transition-duration', '1500ms');
        
        setTimeout(() => {
          $('#cover-screen').hide();
          $('#main-content').removeClass('opacity-0 pointer-events-none').addClass('opacity-100');
          $('body').removeClass('locked');
          
          AOS.init({
            duration: 1000,
            once: true,
            offset: 50
          });
          
        }, 1200);

        if (bgMusic) {
          bgMusic.play().then(function() {
            musicIsPlaying = true;
            $('#music-icon').addClass('animate-spin');
          }).catch(function(err) {});
        }

        setTimeout(function() {
          $('#btn-toggle-music').removeClass('translate-y-24 opacity-0');
          $('#qr-btn').removeClass('translate-y-24 opacity-0');
        }, 1500);
      });


      // MUSIC TOGGLE
      $('#btn-toggle-music').on('click', function() {
        if (!bgMusic) return;
        if (musicIsPlaying) {
          bgMusic.pause();
          musicIsPlaying = false;
          $('#music-icon').removeClass('animate-spin');
          showToast("Musik dinonaktifkan");
        } else {
          bgMusic.play();
          musicIsPlaying = true;
          $('#music-icon').addClass('animate-spin');
          showToast("Musik diaktifkan");
        }
      });


      // GALLERY LIGHTBOX
      $('.gallery-trigger').on('click', function() {
        const src = $(this).data('src');
        if(src) {
          $('#lightbox-img').attr('src', src);
          $('#lightbox').removeClass('opacity-0 pointer-events-none').addClass('opacity-100');
        }
      });
      $('#close-lightbox, #lightbox').on('click', function(e) {
        if (e.target !== this && e.target !== document.getElementById('close-lightbox')) return;
        $('#lightbox').removeClass('opacity-100').addClass('opacity-0 pointer-events-none');
      });


      // QR MODAL
      $('#qr-btn').on('click', function() {
        $('#qr-modal').removeClass('opacity-0 pointer-events-none').addClass('opacity-100');
        setTimeout(() => {
          $('#qr-modal-content').removeClass('scale-95').addClass('scale-100');
        }, 50);
      });
      $('#close-qr-modal, #qr-modal').on('click', function(e) {
        if (e.target !== this && e.target !== document.getElementById('close-qr-modal')) return;
        $('#qr-modal-content').removeClass('scale-100').addClass('scale-95');
        setTimeout(() => {
          $('#qr-modal').removeClass('opacity-100').addClass('opacity-0 pointer-events-none');
        }, 300);
      });

      // COPY CLIPBOARD
      $('.btn-copy-account').on('click', function() {
        const acc = $(this).data('account');
        navigator.clipboard.writeText(acc).then(function() {
          showToast("Nomor rekening disalin!");
        }).catch(function() {
          const temp = document.createElement("input");
          temp.value = acc;
          document.body.appendChild(temp);
          temp.select();
          document.execCommand("copy");
          document.body.removeChild(temp);
          showToast("Nomor rekening disalin!");
        });
      });

      // BACK TO TOP SCROLL
      $(window).on('scroll', function() {
        if ($(this).scrollTop() > 500) {
          $('#btn-back-to-top').removeClass('opacity-0 pointer-events-none').addClass('opacity-100');
        } else {
          $('#btn-back-to-top').removeClass('opacity-100').addClass('opacity-0 pointer-events-none');
        }
      });
      $('#btn-back-to-top').on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 800);
      });

      // TOAST HELPER
      let toastTimer;
      function showToast(msg) {
        $('#toast-message').text(msg);
        $('#toast').removeClass('opacity-0 translate-y-[-10px] pointer-events-none').addClass('opacity-100 translate-y-0');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function() {
          $('#toast').removeClass('opacity-100 translate-y-0').addClass('opacity-0 translate-y-[-10px] pointer-events-none');
        }, 3000);
      }

      // RSVP AJAX
      $('#rsvp-form').on('submit', function(e) {
        e.preventDefault();
        
        const btn = $('#btn-submit-rsvp');
        const txt = $('#btn-submit-text');
        const origTxt = txt.text();
        
        btn.prop('disabled', true);
        txt.text('Mengirim...');
        
        let formData = {
          _token: $('meta[name="csrf-token"]').attr('content'),
          name: $('#rsvp-name').val(),
          is_attending: $('#rsvp-status').val() === 'Hadir' ? 1 : ($('#rsvp-status').val() === 'Tidak Hadir' ? 0 : 2),
          message: $('#rsvp-message').val()
        };

        $.ajax({
          url: '{{ route("public.ucapan.store", $invitation->slug) }}',
          type: 'POST',
          data: formData,
          success: function(res) {
            showToast(res.message || 'Terkirim!');
            $('#rsvp-status').val('');
            $('#rsvp-message').val('');
            
            if (res.wish) {
              const bg = formData.is_attending === 1 ? 'bg-green-100 text-green-700' : (formData.is_attending === 0 ? 'bg-red-100 text-red-700' : 'bg-stone-200 text-stone-700');
              const icon = formData.is_attending === 1 ? 'fa-check' : (formData.is_attending === 0 ? 'fa-xmark' : 'fa-circle-question');
              const lbl = formData.is_attending === 1 ? 'Hadir' : (formData.is_attending === 0 ? 'Berhalangan' : 'Ragu');
              
              const newCard = `
                  <div class="bg-white p-5 rounded-xl border border-stone-100 shadow-sm animate-fade-in">
                    <div class="flex items-center justify-between mb-2">
                      <h4 class="font-serif font-bold text-brand-900">${res.wish.nama_tamu || res.wish.nama}</h4>
                      <span class="text-[10px] text-stone-400">Baru saja</span>
                    </div>
                    <div class="mb-2">
                      <span class="text-[10px] ${bg} px-2 py-1 rounded-sm"><i class="fa-solid ${icon} mr-1"></i> ${lbl}</span>
                    </div>
                    <p class="font-sans text-sm text-stone-600 italic">"${formData.message}"</p>
                  </div>`;
              
              $('#empty-wish-msg').remove();
              $('#wishes-container').prepend(newCard); // Fallback to wishes-container if wishes-list doesn't exist
            }
          },
          error: function(err) {
            showToast(err.responseJSON?.message || 'Terjadi kesalahan');
          },
          complete: function() {
            btn.prop('disabled', false);
            txt.text(origTxt);
          }
        });
      });
    // FOOTER SLIDESHOW
    @if(isset($galeris) && count($galeris) > 0)
      const galleryImages = [
          @foreach($galeris as $gal)
              "{{ str_starts_with($gal->image_path, 'assets/') ? asset($gal->image_path) : asset('storage/' . $gal->image_path) }}",
          @endforeach
      ];
      if (galleryImages.length > 0) {
          let currentImgIndex = 0;
          setInterval(function() {
              currentImgIndex = (currentImgIndex + 1) % galleryImages.length;
              $('#footer-bg-slider').css('opacity', '0');
              setTimeout(function() {
                  $('#footer-bg-slider').css('background-image', `url('${galleryImages[currentImgIndex]}')`).css('opacity', '1');
              }, 1000);
          }, 3000); // Changed to 3 seconds as requested
      }
    @endif
  });
  </script>
</body>
</html>