<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Undangan Digital - Aufilla Invitation</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #fcfaf7; }
        .font-serif-custom { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-brand-bg text-gray-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white/80 backdrop-blur-md border-b border-brand-accent/15 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <span class="text-xl font-bold font-serif-custom text-brand-dark tracking-wide">Aufilla<span class="text-brand-accent">Invitation</span></span>
            </a>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-xs sm:text-sm font-semibold text-brand-dark hover:text-brand-accent transition-colors">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </header>

    <!-- Main Registration Container -->
    <main class="max-w-3xl mx-auto px-4 py-8 sm:py-12 w-full">
        
        <!-- Top Heading -->
        <div class="text-center mb-8 sm:mb-10">
            <span class="inline-block px-3 py-1 rounded-full bg-brand-accent/15 text-brand-accent-dark text-[11px] font-bold uppercase tracking-widest mb-3">
                Mulai Trial Gratis 3 Hari
            </span>
            <h1 class="text-3xl sm:text-4xl font-bold text-brand-dark font-serif-custom mb-3">
                Buat Undangan Digital Anda
            </h1>
            <p class="text-sm sm:text-base text-gray-600 max-w-lg mx-auto leading-relaxed">
                Isi data awal pengantin di bawah ini untuk melihat pratinjau langsung undangan Anda. Bebas diedit kembali kapan saja.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl border border-brand-accent/20 shadow-xl overflow-hidden">
            
            @if ($errors->any())
                <div class="p-6 bg-red-50 border-b border-red-100 text-sm text-red-700 space-y-1">
                    <p class="font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Harap periksa kembali beberapa isian di bawah ini:
                    </p>
                    <ul class="list-disc list-inside space-y-0.5 text-xs text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('landing.register') }}" method="POST" class="p-6 sm:p-10 space-y-8">
                @csrf

                <!-- Section 1: Identitas Pasangan Pengantin -->
                <div>
                    <div class="flex items-center gap-2 pb-3 mb-5 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-brand-accent/15 text-brand-accent-dark flex items-center justify-center font-bold text-sm">1</div>
                        <h3 class="text-lg font-bold text-brand-dark font-serif-custom">Identitas Pasangan Mempelai</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Mempelai Pria -->
                        <div class="bg-brand-bg/40 p-5 rounded-2xl border border-brand-accent/15 space-y-4">
                            <h4 class="text-sm font-bold text-brand-dark uppercase tracking-wider flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span>Mempelai Pria</span>
                            </h4>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Panggilan Pria <span class="text-red-500">*</span></label>
                                <input type="text" name="pria_nama" id="pria_nama" value="{{ old('pria_nama') }}" required placeholder="Contoh: Romeo" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar Pria</label>
                                <input type="text" name="pria_nama_lengkap" value="{{ old('pria_nama_lengkap') }}" placeholder="Contoh: Romeo Montague, S.T." class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                            </div>
                        </div>

                        <!-- Mempelai Wanita -->
                        <div class="bg-brand-bg/40 p-5 rounded-2xl border border-brand-accent/15 space-y-4">
                            <h4 class="text-sm font-bold text-brand-dark uppercase tracking-wider flex items-center gap-2">
                                <div class="w-6 h-6 rounded-lg bg-pink-50 text-pink-500 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                                <span>Mempelai Wanita</span>
                            </h4>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Panggilan Wanita <span class="text-red-500">*</span></label>
                                <input type="text" name="wanita_nama" id="wanita_nama" value="{{ old('wanita_nama') }}" required placeholder="Contoh: Juliet" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar Wanita</label>
                                <input type="text" name="wanita_nama_lengkap" value="{{ old('wanita_nama_lengkap') }}" placeholder="Contoh: Juliet Capulet, S.Ked" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Link URL Kustom Undangan -->
                <div>
                    <div class="flex items-center gap-2 pb-3 mb-5 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-brand-accent/15 text-brand-accent-dark flex items-center justify-center font-bold text-sm">2</div>
                        <h3 class="text-lg font-bold text-brand-dark font-serif-custom">Link URL Kustom Undangan</h3>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1">Buat Alamat Link URL Undangan Anda <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <span class="bg-gray-100 border border-r-0 border-gray-200 rounded-l-xl px-3.5 py-2.5 text-xs text-gray-500 font-mono select-none hidden sm:inline">
                                {{ url('/') }}/
                            </span>
                            <input type="text" name="slug" id="slug_input" value="{{ old('slug') }}" required placeholder="romeo-juliet" class="w-full sm:rounded-l-none rounded-xl border border-gray-200 px-3.5 py-2.5 text-sm font-mono focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                        </div>
                        
                        <!-- Live URL Preview Box -->
                        <div class="mt-2.5 bg-emerald-50/80 border border-emerald-200/80 rounded-xl px-4 py-2.5 flex items-center gap-2 text-xs text-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            <span>Live Link URL Preview: <strong id="live_url_preview" class="font-mono text-emerald-900 font-bold underline">{{ url('/') }}/<span id="preview_text">romeo-juliet</span></strong></span>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Akun Login -->
                <div>
                    <div class="flex items-center gap-2 pb-3 mb-5 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-lg bg-brand-accent/15 text-brand-accent-dark flex items-center justify-center font-bold text-sm">3</div>
                        <h3 class="text-lg font-bold text-brand-dark font-serif-custom">Kredensial Akun Login</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Username Login <span class="text-red-500">*</span></label>
                            <input type="text" name="username" value="{{ old('username') }}" required placeholder="Contoh: romeomontague" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                            <p class="text-[10px] text-gray-400 mt-1">Username khusus digunakan untuk login ke dashboard klien.</p>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi (Password) <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="Ketik ulang password" class="w-full bg-white border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm focus:border-brand-accent focus:ring-2 focus:ring-brand-accent/20 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Section 4: Pilihan Tema Undangan (Ringkas dengan Modal Picker) -->
                <div>
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-brand-accent/15 text-brand-accent-dark flex items-center justify-center font-bold text-sm">4</div>
                            <h3 class="text-lg font-bold text-brand-dark font-serif-custom">Pilihan Tema Undangan</h3>
                        </div>
                        <button type="button" onclick="$('#modal-theme-picker').removeClass('hidden').addClass('flex')" class="text-xs font-semibold text-brand-accent-dark hover:underline flex items-center gap-1">
                            <span>Ganti Tema</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                    </div>

                    <input type="hidden" name="theme_id" id="selected_theme_id" value="{{ $selectedTheme ? $selectedTheme->id : ($themes->first() ? $themes->first()->id : '') }}">

                    <!-- Selected Theme Display Card -->
                    <div onclick="$('#modal-theme-picker').removeClass('hidden').addClass('flex')" class="bg-brand-bg/50 border border-brand-accent/30 hover:border-brand-accent rounded-2xl p-4 cursor-pointer transition-all flex items-center justify-between group shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-16 rounded-xl overflow-hidden bg-gray-200 border border-gray-300 shrink-0">
                                <img id="selected_theme_img" src="{{ ($selectedTheme && $selectedTheme->thumbnail) ? asset('storage/' . $selectedTheme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png') }}" onerror="this.src='{{ asset('assets/img/thumbnail-tema/demo1.png') }}'" alt="Tema" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-brand-accent-dark">Tema Terpilih:</span>
                                <h4 id="selected_theme_title" class="text-base font-bold text-brand-dark font-serif-custom">{{ $selectedTheme ? $selectedTheme->name : 'Pilih Tema' }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Klik di sini untuk memilih atau mengganti tema dari katalog</p>
                            </div>
                        </div>
                        <span class="bg-white border border-gray-200 group-hover:bg-brand-accent group-hover:text-white text-gray-700 text-xs font-semibold px-3.5 py-2 rounded-xl transition-colors shadow-sm shrink-0">
                            Pilih Tema
                        </span>
                    </div>
                </div>

                <!-- Submit Action -->
                <div class="pt-6 border-t border-gray-100">
                    <button type="submit" class="w-full bg-gradient-to-r from-brand-accent to-brand-accent-dark hover:from-brand-accent-dark hover:to-[#745a37] text-white font-bold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 text-sm sm:text-base flex items-center justify-center gap-2">
                        <span>Buat Undangan Saya Sekarang (Trial Gratis)</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <p class="text-center text-xs text-gray-500 mt-3">
                        Dengan menekan tombol di atas, Anda menyetujui Ketentuan Layanan Aufilla Invitation.
                    </p>
                </div>
            </form>
        </div>
    </main>

    <!-- Modal Theme Picker -->
    <div id="modal-theme-picker" class="hidden fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-3xl overflow-hidden max-h-[85vh] flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-brand-bg">
                <div>
                    <h3 class="text-lg font-bold text-brand-dark font-serif-custom">Pilih Tema Undangan Digital</h3>
                    <p class="text-xs text-gray-500">Filter berdasarkan kategori atau gaya desain pilihan Anda</p>
                </div>
                <button type="button" onclick="$('#modal-theme-picker').removeClass('flex').addClass('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Category Filter -->
            <div class="px-6 py-3 border-b border-gray-100 bg-gray-50/70 flex items-center gap-2 overflow-x-auto no-scrollbar">
                <button type="button" onclick="filterModalCategory('all')" class="modal-cat-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-brand-dark text-white shrink-0 transition-colors" data-cat="all">Semua</button>
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $cat)
                        <button type="button" onclick="filterModalCategory('{{ $cat->slug }}')" class="modal-cat-btn px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white text-gray-700 hover:bg-gray-100 border border-gray-200 shrink-0 transition-colors" data-cat="{{ $cat->slug }}">{{ $cat->nama }}</button>
                    @endforeach
                @endif
            </div>
            
            <div class="p-6 overflow-y-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($themes as $theme)
                @php
                    $thumbUrl = $theme->thumbnail ? asset('storage/' . $theme->thumbnail) : asset('assets/img/thumbnail-tema/demo1.png');
                    $themeCat = $theme->category ?? 'minimalis';
                @endphp
                <div onclick="pickTheme({{ $theme->id }}, '{{ addslashes($theme->name) }}', '{{ $thumbUrl }}')" 
                     class="theme-card-option cursor-pointer group border-2 {{ ($selectedTheme && $selectedTheme->id === $theme->id) ? 'border-brand-accent ring-2 ring-brand-accent/20' : 'border-gray-200' }} rounded-2xl overflow-hidden bg-white hover:border-brand-accent transition-all shadow-sm flex flex-col" 
                     data-id="{{ $theme->id }}" 
                     data-category="{{ $themeCat }}">
                    <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
                        <img src="{{ $thumbUrl }}" onerror="this.src='{{ asset('assets/img/thumbnail-tema/demo1.png') }}'" alt="{{ $theme->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @if(($theme->harga_tambahan ?? 0) > 0)
                            <span class="absolute top-2 right-2 bg-purple-600 text-white text-[8px] font-bold px-1.5 py-0.5 rounded-md shadow-xs">
                                +Rp {{ number_format($theme->harga_tambahan, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>
                    <div class="p-2.5 text-center mt-auto">
                        <span class="block text-xs font-bold text-brand-dark group-hover:text-brand-accent transition-colors truncate">{{ $theme->name }}</span>
                        <span class="text-[10px] text-gray-400 capitalize block">{{ str_replace('_', ' ', $themeCat) }}</span>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="px-6 py-3.5 bg-gray-50 border-t border-gray-100 flex justify-end">
                <button type="button" onclick="$('#modal-theme-picker').removeClass('flex').addClass('hidden')" class="px-5 py-2 text-xs font-semibold bg-brand-dark text-white rounded-xl hover:bg-brand-accent transition-colors">Selesai Pilih</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-6 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} Aufilla Invitation. All rights reserved.
    </footer>

    <!-- JavaScript for Live Slug Preview & Theme Picker (Local Asset) -->
    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
    <script>
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        function filterModalCategory(category) {
            $('.modal-cat-btn').removeClass('bg-brand-dark text-white').addClass('bg-white text-gray-700 hover:bg-gray-100 border border-gray-200');
            $('.modal-cat-btn[data-cat="' + category + '"]').removeClass('bg-white text-gray-700 hover:bg-gray-100 border border-gray-200').addClass('bg-brand-dark text-white');

            if (category === 'all') {
                $('.theme-card-option').removeClass('hidden');
            } else {
                $('.theme-card-option').each(function() {
                    var cardCat = $(this).data('category');
                    if (cardCat === category) {
                        $(this).removeClass('hidden');
                    } else {
                        $(this).addClass('hidden');
                    }
                });
            }
        }

        function pickTheme(id, name, img) {
            $('#selected_theme_id').val(id);
            $('#selected_theme_title').text(name);
            $('#selected_theme_img').attr('src', img);
            $('.theme-card-option').removeClass('border-brand-accent ring-2 ring-brand-accent/20').addClass('border-gray-200');
            $('.theme-card-option[data-id="' + id + '"]').removeClass('border-gray-200').addClass('border-brand-accent ring-2 ring-brand-accent/20');
            $('#modal-theme-picker').removeClass('flex').addClass('hidden');
        }

        $(document).ready(function() {
            function updateSlug() {
                var manualSlug = $('#slug_input').val();
                var pria = $('#pria_nama').val();
                var wanita = $('#wanita_nama').val();

                var targetSlug = '';
                if (manualSlug && manualSlug.trim() !== '') {
                    targetSlug = slugify(manualSlug);
                } else if (pria || wanita) {
                    targetSlug = slugify((pria || 'pria') + '-' + (wanita || 'wanita'));
                } else {
                    targetSlug = 'romeo-juliet';
                }

                $('#preview_text').text(targetSlug);
            }

            $('#slug_input, #pria_nama, #wanita_nama').on('input', updateSlug);
            updateSlug();
        });
    </script>
</body>
</html>
