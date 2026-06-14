@extends('layouts.receptionist')

@section('title', 'Buku Tamu - ' . ($invitation->pria_nama . ' & ' . $invitation->wanita_nama))
@section('header_title', 'Buku Tamu: ' . ($invitation->pria_nama . ' & ' . $invitation->wanita_nama))

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    
    <!-- Action Bar -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-recept-border flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-recept-dark tracking-tight">Pusat Penerimaan Tamu</h2>
            <p class="text-sm text-slate-500 mt-1">Gunakan alat scanner, ketik manual, atau gunakan kamera untuk check-in.</p>
        </div>
        <a href="{{ route('receptionist.welcome-screen', $invitation->id) }}" target="_blank" class="px-6 py-3 bg-recept-primary text-white rounded-xl font-semibold hover:bg-recept-primary-hover transition-colors shadow-lg shadow-indigo-500/30 flex items-center gap-2" onclick="initWelcomeScreen()">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            Buka Layar Penyambutan
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 items-start">
        
        <!-- Left Panel: Universal Input & Search -->
        <div class="lg:w-7/12 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-recept-border overflow-hidden flex flex-col h-full">
                <div class="p-6 border-b border-recept-border bg-slate-50/50">
                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Input Utama</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-recept-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                        <input type="text" id="universal-input" class="w-full pl-12 pr-4 py-4 bg-white border-2 border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 text-slate-800 placeholder-slate-400 font-medium text-lg transition-all shadow-sm" placeholder="Tembakkan alat scanner ATAU ketik nama..." autocomplete="off" autofocus>
                    </div>
                    <p class="text-xs text-slate-500 mt-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Alat Scanner akan otomatis menekan Enter.
                    </p>
                </div>

                <!-- Search Results Area -->
                <div class="flex-1 bg-white relative min-h-[300px]">
                    <div id="search-results" class="absolute inset-0 overflow-y-auto divide-y divide-slate-100 custom-scrollbar p-2">
                        <div class="h-full flex flex-col items-center justify-center text-slate-400 p-8 text-center">
                            <svg class="w-12 h-12 mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <p class="font-medium">Ketik minimal 2 huruf untuk mencari tamu.</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Add Guest Form -->
                <div class="p-5 border-t border-recept-border bg-slate-50">
                    <div class="flex items-center justify-between">
                        <button type="button" id="btn-toggle-add" class="text-sm font-semibold text-recept-primary hover:text-recept-primary-hover flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Tamu Tidak Ditemukan? Tambah Baru
                        </button>
                        <button type="button" onclick="document.getElementById('import-modal').classList.remove('hidden')" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 flex items-center gap-2 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200 shadow-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Import Excel
                        </button>
                    </div>
                    <form id="form-add-guest" class="mt-4 hidden animate-fade-in space-y-3">
                        <div class="flex gap-3">
                            <input type="text" name="nama_tamu" id="add-nama-tamu" required class="flex-1 px-4 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Nama Lengkap Tamu">
                            <input type="text" name="no_wa" class="w-1/3 px-4 py-2 bg-white border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="No. WA (Opsional)">
                        </div>
                        <button type="submit" class="w-full py-2 bg-slate-800 text-white rounded-lg text-sm font-semibold hover:bg-slate-700 transition-colors shadow-sm">
                            Tambah & Langsung Check-In
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Panel: Camera & Logs -->
        <div class="lg:w-5/12 space-y-6">
            
            <!-- Camera Scanner -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-recept-border">
                <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-recept-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Kamera Webcam
                </h3>
                <div id="reader" class="w-full rounded-xl overflow-hidden bg-slate-900 border border-slate-200 relative"></div>
                <button type="button" id="btn-restart-scan" class="mt-3 w-full px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 text-sm font-semibold hidden transition-colors border border-indigo-100">
                    Mulai Ulang Kamera
                </button>
            </div>

            <!-- Pengaturan Layar Penyambutan -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-recept-border">
                <h3 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Background Layar Ganda
                </h3>
                <div class="grid grid-cols-4 gap-2" id="bg-grid-container">
                    <!-- Default Solid Color -->
                    <div class="bg-selector w-full aspect-square rounded-lg cursor-pointer border-2 border-recept-primary hover:opacity-80 transition-all bg-slate-900 shadow-sm" data-bg="bg-slate-900"></div>
                    
                    <!-- Upload Custom -->
                    <label class="w-full aspect-square rounded-lg cursor-pointer border-2 border-dashed border-slate-300 hover:border-recept-primary hover:bg-slate-50 transition-all flex flex-col items-center justify-center text-slate-400 hover:text-recept-primary shadow-sm relative overflow-hidden group">
                        <input type="file" id="input-custom-bg" class="hidden" accept="image/png, image/jpeg, image/webp">
                        <div id="upload-spinner" class="absolute inset-0 bg-white/80 flex items-center justify-center hidden z-10">
                            <svg class="w-6 h-6 animate-spin text-recept-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </div>
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <span class="text-[10px] font-bold text-center leading-tight uppercase tracking-wider">Upload</span>
                    </label>

                    <!-- Cover Image -->
                    @if(!empty($invitation->cover_img))
                        <div class="bg-selector w-full aspect-square rounded-lg cursor-pointer border-2 border-transparent hover:border-slate-300 transition-all bg-cover bg-center shadow-sm" style="background-image: url('{{ asset('storage/'.$invitation->cover_img) }}');" data-bg="{{ asset('storage/'.$invitation->cover_img) }}"></div>
                    @endif
                    
                    <!-- Gallery Images -->
                    @foreach($invitation->galeris->take(2) as $galeri)
                        @if(!empty($galeri->file_path))
                            <div class="bg-selector w-full aspect-square rounded-lg cursor-pointer border-2 border-transparent hover:border-slate-300 transition-all bg-cover bg-center shadow-sm" style="background-image: url('{{ asset('storage/'.$galeri->file_path) }}');" data-bg="{{ asset('storage/'.$galeri->file_path) }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Recent Check-Ins -->
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-recept-border flex-1">
                <h3 class="font-bold text-slate-800 mb-3">Log Kehadiran</h3>
                <ul id="recent-logs" class="space-y-2">
                    @forelse($recentLogs as $log)
                        <li class="flex items-center gap-3 p-3 bg-indigo-50/50 rounded-xl border border-indigo-100 animate-fade-in">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $log->nama_tamu }}</p>
                                <p class="text-[11px] font-medium text-slate-500">
                                    {{ $log->waktu_hadir->diffForHumans() }}
                                </p>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-400 text-center py-6 border-2 border-dashed border-slate-100 rounded-xl" id="empty-log">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Import Modal -->
<div id="import-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="document.getElementById('import-modal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Import Data Tamu
            </h3>
            <button onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 space-y-6">
            <!-- Download Template Box -->
            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex items-center justify-between gap-4">
                <div>
                    <h4 class="text-sm font-semibold text-indigo-900">Format Import Excel</h4>
                    <p class="text-xs text-indigo-600 mt-1">Unduh format tabel yang kami sediakan.</p>
                </div>
                <a href="{{ route('receptionist.buku-tamu.template-excel') }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-colors flex shrink-0 items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Format
                </a>
            </div>

            <!-- Upload Form -->
            <form id="form-import" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Upload File Excel (Max 2MB)</label>
                    <input type="file" id="excel_file" name="excel_file" accept=".xlsx, .xls, .csv" required
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 file:transition-colors file:cursor-pointer border border-slate-200 rounded-xl">
                </div>
                <button type="submit" class="w-full py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-semibold hover:bg-emerald-700 transition-colors shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Mulai Import Data
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/html5-qrcode.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const INVITATION_ID = {{ $invitation->id }};
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const URL_CHECKIN = "{{ route('receptionist.buku-tamu.check-in', $invitation->id) }}";
        const URL_SEARCH = "{{ route('receptionist.buku-tamu.search', $invitation->id) }}";
        const URL_ADD = "{{ route('receptionist.buku-tamu.add-guest', $invitation->id) }}";
        const URL_UPLOAD_BG = "{{ route('receptionist.buku-tamu.upload-bg', $invitation->id) }}";

        let html5QrcodeScanner = null;
        let isProcessing = false;
        let searchTimer = null;

        const inputUniversal = document.getElementById('universal-input');
        const searchResults = document.getElementById('search-results');
        const btnToggleAdd = document.getElementById('btn-toggle-add');
        const formAddGuest = document.getElementById('form-add-guest');
        const addNamaTamu = document.getElementById('add-nama-tamu');
        const btnRestartScan = document.getElementById('btn-restart-scan');
        const recentLogs = document.getElementById('recent-logs');

        // Autofocus Input
        inputUniversal.focus();

        // --- 1. UNIVERSAL INPUT HANDLING (SCANNER & TYPING) ---
        inputUniversal.addEventListener('keyup', function(e) {
            clearTimeout(searchTimer);
            let val = this.val.trim();

            if (e.key === 'Enter') {
                // Alat Scanner ditembakkan (menekan Enter otomatis)
                e.preventDefault();
                if (val.length > 0) {
                    processCheckIn(val, null); // Coba checkin sebagai kode QR
                    inputUniversal.value = '';
                }
                return;
            }

            // Manual Typing -> Live Search
            if (val.length < 2) {
                searchResults.innerHTML = `
                    <div class="h-full flex flex-col items-center justify-center text-slate-400 p-8 text-center">
                        <svg class="w-12 h-12 mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <p class="font-medium">Ketik minimal 2 huruf...</p>
                    </div>`;
                return;
            }

            searchResults.innerHTML = '<div class="p-8 text-center text-slate-500 font-medium">Mencari...</div>';

            searchTimer = setTimeout(() => {
                fetch(`${URL_SEARCH}?q=${encodeURIComponent(val)}`)
                    .then(res => res.json())
                    .then(res => {
                        if (res.length === 0) {
                            searchResults.innerHTML = `
                                <div class="p-8 text-center text-slate-500 bg-slate-50 rounded-xl m-2 border border-slate-100">
                                    <p class="font-bold text-slate-700 mb-1">Tamu tidak ditemukan.</p>
                                    <p class="text-sm">Gunakan tombol "Tambah Baru" di bawah.</p>
                                </div>`;
                        } else {
                            let html = '';
                            res.forEach(tamu => {
                                let statusHtml = tamu.waktu_hadir 
                                    ? `<span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-md text-xs font-bold border border-emerald-200">Hadir</span>`
                                    : `<button onclick="window.processCheckIn(null, ${tamu.id})" class="px-4 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 shadow-sm transition-colors focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">Check In</button>`;
                                
                                html += `
                                <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition-colors m-2 rounded-xl border border-transparent hover:border-slate-200">
                                    <div>
                                        <p class="font-bold text-slate-800 text-lg">${tamu.nama_tamu}</p>
                                        <p class="text-xs font-medium text-slate-400 mt-0.5">QR: ${tamu.kode_qr || '-'}</p>
                                    </div>
                                    <div>${statusHtml}</div>
                                </div>`;
                            });
                            searchResults.innerHTML = html;
                        }
                    })
                    .catch(err => console.error(err));
            }, 300);
        });

        // Add `val` getter mapping for Vanilla JS event
        Object.defineProperty(inputUniversal, 'val', {
            get: function() { return this.value; }
        });

        // --- 2. ADD GUEST LOGIC ---
        btnToggleAdd.addEventListener('click', function() {
            if (formAddGuest.classList.contains('hidden')) {
                formAddGuest.classList.remove('hidden');
                addNamaTamu.value = inputUniversal.value; // Pindahkan teks pencarian ke form
                addNamaTamu.focus();
            } else {
                formAddGuest.classList.add('hidden');
                inputUniversal.focus();
            }
        });

        formAddGuest.addEventListener('submit', function(e) {
            e.preventDefault();
            if(isProcessing) return;
            isProcessing = true;

            const formData = new URLSearchParams(new FormData(this));
            formData.append('_token', CSRF_TOKEN);

            fetch(URL_ADD, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(res => res.json())
            .then(res => {
                if(res.tamu) {
                    formAddGuest.reset();
                    formAddGuest.classList.add('hidden');
                    handleSuccessCheckIn(res.tamu, 'Ditambahkan & Check In');
                    inputUniversal.value = '';
                    inputUniversal.focus();
                } else {
                    Swal.fire('Error', 'Gagal menambahkan tamu', 'error');
                }
            })
            .catch(err => {
                Swal.fire('Error', 'Gagal memproses data', 'error');
            })
            .finally(() => {
                isProcessing = false;
            });
        });

        // --- 2.5 IMPORT EXCEL LOGIC ---
        const formImport = document.getElementById('form-import');
        if(formImport) {
            formImport.addEventListener('submit', function(e) {
                e.preventDefault();
                const btnSubmit = this.querySelector('button[type="submit"]');
                const originalText = btnSubmit.innerHTML;
                
                btnSubmit.innerHTML = `<svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Mengimpor...`;
                btnSubmit.disabled = true;

                let formData = new FormData(this);
                fetch("{{ route('receptionist.buku-tamu.import-excel', $invitation->id) }}", {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(async res => {
                    const data = await res.json();
                    if(!res.ok) throw data;
                    return data;
                })
                .then(res => {
                    Swal.fire('Berhasil!', 'Data tamu berhasil diimpor.', 'success').then(() => {
                        document.getElementById('import-modal').classList.add('hidden');
                        formImport.reset();
                        // Optional: refresh page or re-focus
                        inputUniversal.focus();
                    });
                })
                .catch(err => {
                    const msg = err.error || err.message || 'Terjadi kesalahan saat impor data';
                    Swal.fire('Error', msg, 'error');
                })
                .finally(() => {
                    btnSubmit.innerHTML = originalText;
                    btnSubmit.disabled = false;
                });
            });
        }

        // --- 3. BACKGROUND SELECTOR ---
        document.querySelectorAll('.bg-selector').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.bg-selector').forEach(b => {
                    b.classList.remove('border-recept-primary');
                    b.classList.add('border-transparent');
                });
                this.classList.remove('border-transparent');
                this.classList.add('border-recept-primary');
                
                const bgVal = this.getAttribute('data-bg');
                localStorage.setItem('welcome_bg_' + INVITATION_ID, bgVal);
                
                Swal.fire({
                    toast: true, position: 'bottom-end', showConfirmButton: false, timer: 2000,
                    icon: 'success', title: 'Background layar diperbarui'
                });
            });
        });

        // --- 3.5 UPLOAD CUSTOM BACKGROUND ---
        const inputCustomBg = document.getElementById('input-custom-bg');
        const uploadSpinner = document.getElementById('upload-spinner');

        if(inputCustomBg) {
            inputCustomBg.addEventListener('change', function(e) {
                if(!this.files || !this.files[0]) return;
                
                const file = this.files[0];
                if(file.size > 5 * 1024 * 1024) {
                    Swal.fire('Error', 'Ukuran gambar maksimal 5MB', 'error');
                    this.value = '';
                    return;
                }

                uploadSpinner.classList.remove('hidden');

                const formData = new FormData();
                formData.append('background', file);
                formData.append('_token', CSRF_TOKEN);

                fetch(URL_UPLOAD_BG, {
                    method: 'POST',
                    body: formData
                })
                .then(async res => {
                    const data = await res.json();
                    if(!res.ok) throw data;
                    return data;
                })
                .then(res => {
                    if(res.success) {
                        // Create new bg box
                        const box = document.createElement('div');
                        box.className = 'bg-selector w-full aspect-square rounded-lg cursor-pointer border-2 border-transparent hover:border-slate-300 transition-all bg-cover bg-center shadow-sm';
                        box.style.backgroundImage = `url('${res.url}')`;
                        box.setAttribute('data-bg', res.url);
                        
                        // Insert after upload button
                        const labelItem = inputCustomBg.closest('label');
                        labelItem.parentNode.insertBefore(box, labelItem.nextSibling);

                        // Attach event
                        box.addEventListener('click', function() {
                            document.querySelectorAll('.bg-selector').forEach(b => {
                                b.classList.remove('border-recept-primary');
                                b.classList.add('border-transparent');
                            });
                            this.classList.remove('border-transparent');
                            this.classList.add('border-recept-primary');
                            
                            localStorage.setItem('welcome_bg_' + INVITATION_ID, res.url);
                            
                            Swal.fire({
                                toast: true, position: 'bottom-end', showConfirmButton: false, timer: 2000,
                                icon: 'success', title: 'Background layar diperbarui'
                            });
                        });

                        // Auto click to apply immediately
                        box.click();
                    } else {
                        throw new Error(res.message || 'Gagal upload');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', err.message || 'Terjadi kesalahan saat upload', 'error');
                })
                .finally(() => {
                    uploadSpinner.classList.add('hidden');
                    inputCustomBg.value = '';
                });
            });
        }

        // --- 4. QR WEBCAM SCANNER LOGIC ---
        function onScanSuccess(decodedText, decodedResult) {
            if(isProcessing) return;
            html5QrcodeScanner.pause();
            processCheckIn(decodedText, null);
        }

        html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: {width: 250, height: 250} }, false);
        html5QrcodeScanner.render(onScanSuccess);

        btnRestartScan.addEventListener('click', function() {
            html5QrcodeScanner.resume();
            this.classList.add('hidden');
            inputUniversal.focus();
        });

        // --- 5. CHECK IN API CALL ---
        window.processCheckIn = function(qrCode, tamuId) {
            if(isProcessing) return;
            isProcessing = true;

            const formData = new URLSearchParams();
            formData.append('_token', CSRF_TOKEN);
            if(qrCode) formData.append('kode_qr', qrCode);
            if(tamuId) formData.append('tamu_id', tamuId);

            fetch(URL_CHECKIN, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            })
            .then(async res => {
                const data = await res.json();
                if(!res.ok) throw data;
                return data;
            })
            .then(res => {
                handleSuccessCheckIn(res.tamu, 'Check In Berhasil');
                
                if(qrCode) {
                    setTimeout(() => { 
                        html5QrcodeScanner.resume(); 
                        isProcessing = false; 
                        inputUniversal.focus();
                    }, 2000);
                } else {
                    isProcessing = false;
                    // Trigger live search refresh if manual
                    if(inputUniversal.value.length >= 2) {
                        inputUniversal.dispatchEvent(new Event('keyup'));
                    }
                    inputUniversal.focus();
                }
            })
            .catch(err => {
                let msg = err.message || 'Terjadi kesalahan sistem';
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: msg,
                    timer: 3000,
                    showConfirmButton: false
                });
                
                if(qrCode) {
                    btnRestartScan.classList.remove('hidden');
                }
                isProcessing = false;
                inputUniversal.focus();
            });
        };

        function handleSuccessCheckIn(tamu, actionText) {
            // Trigger Dual Screen
            localStorage.setItem('welcome_guest_' + INVITATION_ID, JSON.stringify({
                nama: tamu.nama_tamu,
                timestamp: Date.now()
            }));

            // Success Alert
            Swal.fire({
                toast: true, position: 'top', showConfirmButton: false, timer: 2000,
                icon: 'success', title: `${tamu.nama_tamu} berhasil Check-In!`
            });

            // Log
            const emptyLog = document.getElementById('empty-log');
            if(emptyLog) emptyLog.remove();

            const li = document.createElement('li');
            li.className = "flex items-center gap-3 p-3 bg-indigo-50/50 rounded-xl border border-indigo-100 animate-fade-in";
            li.innerHTML = `
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-800 truncate">${tamu.nama_tamu}</p>
                    <p class="text-[11px] font-medium text-slate-500">${actionText} • Baru saja</p>
                </div>
            `;
            
            recentLogs.prepend(li);
            if(recentLogs.children.length > 5) {
                recentLogs.lastElementChild.remove();
            }
        }
    });

    window.initWelcomeScreen = function() {
        localStorage.setItem('welcome_init_' + {{ $invitation->id }}, Date.now());
    }
</script>
<style>
    /* Styling html5-qrcode components to fit tailwind theme */
    #reader { border: none !important; min-height: 250px; }
    #reader video { 
        border-radius: 0.75rem; 
        object-fit: cover; 
        width: 100% !important; 
        height: auto !important;
    }
    #reader__dashboard_section_csr { padding: 1rem 0; text-align: center; }
    #reader__dashboard_section_csr span { color: #fff; font-family: 'Inter', sans-serif; font-size: 13px; }
    #reader__dashboard_section_swaplink { color: #818cf8; text-decoration: none; margin-bottom: 10px; display: inline-block; font-size: 13px; }
    #reader__camera_selection { background: #1e293b; border: 1px solid #334155; color: white; padding: 6px; border-radius: 6px; width: 100%; max-width: 300px; margin: 0 auto 10px auto; font-size: 13px; display: block; }
    #reader__dashboard_section_csr button { background: #4f46e5; color: white; border: none; padding: 8px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 13px; transition: all 0.2s; margin-top: 5px; }
    #reader__dashboard_section_csr button:hover { background: #4338ca; }
    .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
</style>
