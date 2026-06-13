<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layar Penyambutan - {{ $invitation->pria_nama }} & {{ $invitation->wanita_nama }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cormorant-garamond:400,600,700|inter:400,500,600" rel="stylesheet" />
    
    @vite(['resources/css/app.css'])
    
    <style>
        body, html {
            margin: 0; padding: 0; width: 100%; height: 100%;
            overflow: hidden; background-color: #0f172a;
            font-family: 'Inter', sans-serif;
        }
        
        #dynamic-bg {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-size: cover; background-position: center;
            transition: background-image 1.5s ease-in-out;
            z-index: 1;
        }
        
        #overlay-tint {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6); /* Slate-900 tint */
            z-index: 2;
        }

        #welcome-container {
            position: absolute; inset: 0; z-index: 10;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(0.95) translateY(20px);
        }

        #welcome-container.active {
            opacity: 1; transform: scale(1) translateY(0);
        }

        .welcome-card {
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            border-left: 1px solid rgba(255, 255, 255, 0.25);
            padding: 5rem 8rem;
            border-radius: 2rem;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(0,0,0,0.3);
            max-width: 90vw;
            min-width: 60vw;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .title-text {
            font-family: 'Cormorant Garamond', serif;
            color: #D4AF37; /* Luxury Gold */
            font-size: 2.5rem;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            font-weight: 600;
        }

        .subtitle {
            font-family: 'Inter', sans-serif;
            color: rgba(255, 255, 255, 0.85);
            font-size: 1rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .guest-name {
            font-family: 'Cormorant Garamond', serif;
            color: #ffffff;
            font-size: 7rem;
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 1rem;
            text-shadow: 0 10px 30px rgba(0,0,0,0.6);
            letter-spacing: 0.02em;
            padding: 0 2rem;
        }

        .thank-you {
            font-family: 'Inter', sans-serif;
            color: #D4AF37;
            font-size: 0.9rem;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            margin-top: 2rem;
            opacity: 0.9;
            font-weight: 600;
        }

        .ornament {
            width: 80px;
            height: auto;
            margin-bottom: 1.5rem;
            opacity: 0.8;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        }

        .ornament-bottom {
            width: 80px;
            height: auto;
            margin-top: 2.5rem;
            opacity: 0.8;
            transform: rotate(180deg);
            filter: drop-shadow(0 -2px 4px rgba(0,0,0,0.3));
        }

        .couple-names {
            position: absolute;
            bottom: 2.5rem;
            width: 100%;
            text-align: center;
            z-index: 5;
            color: rgba(255,255,255,0.6);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            font-weight: 500;
            text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }

        /* Idle State */
        #idle-state {
            position: absolute; inset: 0; z-index: 5;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            opacity: 1; transition: opacity 1s ease;
        }

        #idle-state.hidden {
            opacity: 0;
        }

        .idle-title {
            font-family: 'Cormorant Garamond', serif;
            color: #ffffff;
            font-size: 5rem;
            font-weight: 700;
            text-shadow: 0 10px 30px rgba(0,0,0,0.8);
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body>

    <div id="dynamic-bg" style="background-image: url('{{ !empty($invitation->cover_img) ? asset('storage/'.$invitation->cover_img) : asset('assets/default/default-pasangan.jpg') }}');"></div>
    <div id="overlay-tint"></div>

    <div id="idle-state">
        <h1 class="idle-title">{{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}</h1>
        <p class="subtitle mt-4 text-white/60">Mohon tunjukkan QR Code Anda kepada Resepsionis</p>
    </div>

    <div id="welcome-container">
        <div class="welcome-card">
            <!-- Gold Floral Ornament -->
            <svg class="ornament" viewBox="0 0 100 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M50 15C45 5 35 0 25 0C10 0 0 10 0 20C0 25 5 30 15 30C30 30 40 25 50 15ZM50 15C55 5 65 0 75 0C90 0 100 10 100 20C100 25 95 30 85 30C70 30 60 25 50 15Z" fill="#D4AF37" opacity="0.8"/>
                <circle cx="50" cy="15" r="4" fill="#D4AF37"/>
            </svg>

            <div class="title-text">Selamat Datang</div>
            <div class="subtitle">Bapak / Ibu / Saudara / i</div>
            
            <div class="guest-name" id="guest-name-display">Nama Tamu</div>
            
            <div class="thank-you">Terima Kasih Atas Kehadirannya</div>

            <svg class="ornament-bottom" viewBox="0 0 100 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M50 15C45 5 35 0 25 0C10 0 0 10 0 20C0 25 5 30 15 30C30 30 40 25 50 15ZM50 15C55 5 65 0 75 0C90 0 100 10 100 20C100 25 95 30 85 30C70 30 60 25 50 15Z" fill="#D4AF37" opacity="0.8"/>
                <circle cx="50" cy="15" r="4" fill="#D4AF37"/>
            </svg>
        </div>
    </div>

    <div class="couple-names">The Wedding of {{ $invitation->pria_nama }} &amp; {{ $invitation->wanita_nama }}</div>

    <!-- Audio Permission Hint -->
    <div id="audio-hint" style="position: absolute; top: 1rem; right: 1rem; color: rgba(255,255,255,0.5); font-size: 0.8rem; z-index: 50; cursor: pointer; border: 1px solid rgba(255,255,255,0.2); padding: 0.5rem 1rem; border-radius: 2rem; backdrop-filter: blur(10px);">
        Klik di mana saja untuk mengaktifkan Suara 🔊
    </div>

    <script>
        const INVITATION_ID = {{ $invitation->id }};
        const guestKey = 'welcome_guest_' + INVITATION_ID;
        const bgKey = 'welcome_bg_' + INVITATION_ID;
        
        const welcomeContainer = document.getElementById('welcome-container');
        const idleState = document.getElementById('idle-state');
        const guestNameDisplay = document.getElementById('guest-name-display');
        const dynamicBg = document.getElementById('dynamic-bg');

        let displayTimeout;
        let audioCtx;

        // --- Web Audio API untuk Notifikasi Suara Elegan ---
        function initAudio() {
            if(!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if(audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            document.getElementById('audio-hint').style.display = 'none';
        }

        // Browser memblokir audio sebelum ada interaksi, jadi kita harus tangkap klik pertama
        document.body.addEventListener('click', initAudio);

        function playElegantChime() {
            if (!audioCtx) initAudio();
            if (audioCtx.state === 'suspended') return; // Tidak bisa play kalau belum diklik

            const playNote = (freq, startTime, duration) => {
                const osc = audioCtx.createOscillator();
                const gainNode = audioCtx.createGain();
                
                // Gelombang Sine untuk suara bel yang lembut dan mewah
                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, audioCtx.currentTime + startTime);
                
                // Volume Envelope: Tiba-tiba keras, lalu pelan-pelan menghilang
                gainNode.gain.setValueAtTime(0, audioCtx.currentTime + startTime);
                gainNode.gain.linearRampToValueAtTime(0.4, audioCtx.currentTime + startTime + 0.05);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + startTime + duration);
                
                osc.connect(gainNode);
                gainNode.connect(audioCtx.destination);
                
                osc.start(audioCtx.currentTime + startTime);
                osc.stop(audioCtx.currentTime + startTime + duration);
            };

            // Mainkan dua nada berturut-turut (E5 lalu C6) seperti bel resepsionis hotel
            playNote(659.25, 0, 1.5);    // Nada 1: E5
            playNote(1046.50, 0.2, 2.0); // Nada 2: C6 (Lebih tinggi)
        }

        // Cek LocalStorage awal
        if(localStorage.getItem(bgKey)) {
            let bgVal = localStorage.getItem(bgKey);
            if(bgVal.startsWith('bg-')) {
                dynamicBg.style.backgroundImage = 'none';
                dynamicBg.className = bgVal;
            } else {
                dynamicBg.className = '';
                dynamicBg.style.backgroundImage = `url('${bgVal}')`;
            }
        }

        // Listen for LocalStorage changes
        window.addEventListener('storage', function(e) {
            // Jika ada perubahan background
            if(e.key === bgKey) {
                let bgVal = e.newValue;
                if(bgVal.startsWith('bg-')) {
                    dynamicBg.style.backgroundImage = 'none';
                    dynamicBg.className = bgVal;
                } else {
                    dynamicBg.className = '';
                    dynamicBg.style.backgroundImage = `url('${bgVal}')`;
                }
            }

            // Jika ada tamu baru yang check-in
            if(e.key === guestKey && e.newValue) {
                let data = JSON.parse(e.newValue);
                showWelcomeMessage(data.nama);
            }
        });

        function showWelcomeMessage(namaTamu) {
            // Mainkan suara notifikasi elegan
            playElegantChime();

            // Set text
            guestNameDisplay.innerText = namaTamu;

            // Show UI
            idleState.classList.add('hidden');
            welcomeContainer.classList.add('active');

            // Clear previous timeout if multiple guests scan quickly
            clearTimeout(displayTimeout);

            // Hide after 5 seconds
            displayTimeout = setTimeout(() => {
                welcomeContainer.classList.remove('active');
                
                // Show idle state slightly after welcome hides
                setTimeout(() => {
                    idleState.classList.remove('hidden');
                }, 500);
            }, 6000);
        }
    </script>
</body>
</html>
