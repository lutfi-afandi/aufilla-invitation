@extends('layouts.client')

@section('title', 'Overview - Aufilla Invitation')

@section('content')
<div class="w-full">
    <!-- Welcome Panel (Luxury Edition) -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0d2a1a] via-[#0a2214] to-[#04120a] text-white p-6 sm:p-10 mb-8 border border-[#c5a880]/20 shadow-[0_20px_50px_rgba(10,34,20,0.4)]">
        
        <!-- Luxury Texture Overlay -->
        <div class="absolute inset-0 opacity-[0.06] mix-blend-overlay pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%23c5a880\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
        
        <!-- Deep Glow Orbs -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[radial-gradient(circle_at_center,rgba(197,168,128,0.12)_0%,transparent_60%)] -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[radial-gradient(circle_at_center,rgba(88,139,139,0.1)_0%,transparent_60%)] translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">
            <!-- Left Text Content -->
            <div class="max-w-2xl">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#c5a880]/15 border border-[#c5a880]/30 text-[#c5a880] text-[10px] font-bold tracking-[0.15em] uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#c5a880] animate-pulse"></span>
                        Aufilla Member
                    </span>

                    @if($isReadyToShare)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-[10px] font-bold tracking-wider uppercase shadow-[0_0_12px_rgba(16,185,129,0.3)]">
                            <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Siap Disebar
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-400/40 text-amber-300 text-[10px] font-bold tracking-wider uppercase">
                            <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Lengkapi Data Utama
                        </span>
                    @endif
                </div>
                
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight tracking-tight" style="font-family: 'Playfair Display', serif;">
                    Selamat Datang, <br class="hidden sm:inline"/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#e8d5b5] to-[#c5a880]">{{ $invitation->pria_nama && $invitation->pria_nama !== 'Pria' ? $invitation->pria_nama . ' & ' . $invitation->wanita_nama : 'Calon Mempelai' }}</span>
                </h2>
                
                <p class="text-white/70 text-xs sm:text-sm leading-relaxed font-light max-w-xl">
                    @if($invitation->status === 'kedaluwarsa' || $invitation->isExpired())
                        Masa aktif undangan Anda telah habis. Silakan hubungi Admin untuk perpanjangan.
                    @elseif($invitation->paket)
                        Paket <strong class="text-[#e8d5b5] font-semibold">{{ $invitation->paket->name }}</strong> aktif hingga <strong class="text-[#e8d5b5] font-semibold">{{ $invitation->paket->active_days > 3000 ? '10 Tahun' : ($invitation->expired_at ? $invitation->expired_at->format('d M Y') : '-') }}</strong>.
                    @endif
                    Status kesiapan undangan Anda saat ini: <strong class="text-[#e8d5b5] font-semibold">{{ $completedChecklist }} dari {{ $totalChecklist }} langkah selesai</strong>.
                </p>
            </div>

            <!-- Right Icon Quick Actions -->
            <div class="grid grid-cols-2 sm:flex sm:items-center gap-3 sm:gap-4 shrink-0">
                <!-- Action 1: Lihat Undangan -->
                <a href="{{ route('public.invitation', $invitation->slug) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-gradient-to-r from-[#c5a880] to-[#e8d5b5] text-[#0a2214] font-bold text-xs shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Lihat Undangan
                </a>

                <!-- Action 2: Salin Link -->
                <button type="button" onclick="copyInvitationLink('{{ url('/' . $invitation->slug) }}')" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-xs backdrop-blur-md transition-all">
                    <svg class="w-4 h-4 text-[#c5a880]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Salin Link
                </button>

                <!-- Action 3: Buku Tamu -->
                <a href="{{ route('client.tamu') }}" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-xs backdrop-blur-md transition-all">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Buku Tamu
                </a>

                <!-- Action 4: Bantuan WA -->
                <a href="https://wa.me/{{ config('app.activation_wa') }}?text={{ urlencode('Halo Admin Aufilla, saya butuh bantuan terkait undangan dengan username: ' . Auth::user()->username) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-semibold text-xs backdrop-blur-md transition-all">
                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    Bantuan
                </a>
            </div>
        </div>
    </div>

    <!-- Section: Status Kelayakan Sebar Undangan (Readiness Widget) -->
    <div class="bg-white rounded-[2rem] border border-brand-accent/20 shadow-sm p-6 sm:p-8 mb-8 relative overflow-hidden">
        <!-- Top Bar Progress Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-lg font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">
                        Status Kesiapan Sebar Undangan
                    </h3>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-extrabold {{ $readinessPercentage === 100 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                        {{ $readinessPercentage }}% Selesai
                    </span>
                </div>
                <p class="text-xs text-gray-500">
                    @if($isReadyToShare)
                        <span class="text-emerald-600 font-semibold">✓ Data utama sudah lengkap!</span> Undangan Anda telah siap dan layak dibagikan ke seluruh calon tamu.
                    @else
                        Lengkapi langkah-langkah berindikator <span class="text-amber-600 font-semibold">"Perlu Diisi"</span> di bawah ini agar undangan Anda layak disebar.
                    @endif
                </p>
            </div>

            <!-- Global Progress Bar -->
            <div class="w-full sm:w-56 shrink-0">
                <div class="flex items-center justify-between text-xs font-semibold text-gray-600 mb-1.5">
                    <span>Progres Kelengkapan</span>
                    <span class="text-brand-dark font-bold">{{ $completedChecklist }}/{{ $totalChecklist }} Langkah</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden p-0.5 border border-gray-200">
                    <div class="bg-gradient-to-r from-amber-500 to-emerald-500 h-full rounded-full transition-all duration-700 ease-out" style="width: {{ $readinessPercentage }}%;"></div>
                </div>
            </div>
        </div>

        <!-- Interactive Checklist Cards Grid (Mobile-First Intuitive Layout) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-6">
            @foreach($checklistItems as $key => $item)
            <div class="rounded-2xl p-5 border transition-all duration-300 flex flex-col justify-between {{ $item['is_completed'] ? 'bg-emerald-50/30 border-emerald-200/80 hover:border-emerald-300' : 'bg-amber-50/30 border-amber-200/80 hover:border-amber-300 shadow-sm' }}">
                <div>
                    <!-- Card Top Header Badge -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item['is_completed'] ? 'bg-emerald-100 text-emerald-800 border border-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-200' }}">
                            @if($item['is_completed'])
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Sudah Lengkap
                            @else
                                <svg class="w-3.5 h-3.5 text-amber-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Perlu Diisi
                            @endif
                        </span>
                        
                        @if($key === 'pengantin' || $key === 'acara')
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider bg-white/80 px-2 py-0.5 rounded border border-gray-100">Wajib</span>
                        @else
                            <span class="text-[10px] font-medium text-gray-400 uppercase tracking-wider">Pendukung</span>
                        @endif
                    </div>

                    <!-- Card Body -->
                    <h4 class="text-base font-bold text-brand-dark mb-1">{{ $item['title'] }}</h4>
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">{{ $item['desc'] }}</p>
                </div>

                <!-- CTA Button Link -->
                <a href="{{ $item['route'] }}" class="w-full inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold transition-all {{ $item['is_completed'] ? 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' : 'bg-gradient-to-r from-brand-accent to-brand-accent-dark text-white shadow-md hover:shadow-lg' }}">
                    <span>{{ $item['button_text'] }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <!-- Tamu -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#588b8b]/10 text-[#588b8b]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-brand-dark leading-tight">{{ $invitation->tamus()->count() }}</h3>
                    <p class="text-gray-500 font-medium text-[11px] uppercase tracking-wider">Total Tamu</p>
                </div>
            </div>
        </div>

        <!-- Reservasi -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-emerald-50 text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-brand-dark leading-tight">{{ $invitation->ucapans()->where('kehadiran', 'hadir')->count() ?? 0 }}</h3>
                    <p class="text-gray-500 font-medium text-[11px] uppercase tracking-wider">Hadir</p>
                </div>
            </div>
        </div>
        
        <!-- Ucapan -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-brand-accent/15 text-brand-accent-dark">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-brand-dark leading-tight">{{ $invitation->ucapans()->count() ?? 0 }}</h3>
                    <p class="text-gray-500 font-medium text-[11px] uppercase tracking-wider">Ucapan</p>
                </div>
            </div>
        </div>

        <!-- Panduan -->
        <a href="{{ route('client.tutorial') }}" class="bg-gradient-to-br from-[#c5a880] to-[#a3865c] rounded-2xl p-6 border border-[#c5a880]/20 shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group block">
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-white/20 text-white backdrop-blur-sm border border-white/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white leading-tight">Panduan</h3>
                    <p class="text-white/80 font-medium text-[11px] tracking-wider uppercase">Pelajari Sistem</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Ucapan Terbaru -->
    <div class="bg-white rounded-[2rem] border border-brand-accent/20 shadow-sm p-6 lg:p-8 relative overflow-hidden">
        <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-5">
            <h3 class="text-xs font-bold uppercase tracking-widest text-gray-400 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Ucapan & Doa Terbaru
            </h3>
            <span class="text-xs text-brand-dark bg-brand-dark/5 px-3 py-1 rounded-full font-bold ring-1 ring-brand-dark/10">{{ $invitation->ucapans()->count() }} Pesan</span>
        </div>
        
        <div class="pt-2">
            @if(isset($recentUcapans) && $recentUcapans->isEmpty())
                <div class="h-32 flex flex-col items-center justify-center text-gray-400">
                    <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <p class="text-xs font-medium">Belum ada ucapan yang masuk dari tamu undangan Anda.</p>
                </div>
            @else
                <div class="space-y-3 max-h-[350px] overflow-y-auto custom-scrollbar pr-2">
                    @foreach($recentUcapans as $ucapan)
                    <div class="flex gap-4 p-4 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:border-brand-accent/30 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-accent/10 to-brand-accent/30 flex items-center justify-center text-brand-dark font-extrabold text-sm flex-shrink-0">
                            {{ strtoupper(substr($ucapan->nama ?? '?', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-sm font-bold text-gray-800 truncate">{{ $ucapan->nama }}</span>
                                <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded flex-shrink-0">{{ $ucapan->created_at ? $ucapan->created_at->diffForHumans() : 'baru saja' }}</span>
                            </div>
                            <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed mb-1.5">"{{ $ucapan->ucapan ?? $ucapan->pesan ?? '-' }}"</p>
                            <span class="inline-flex items-center gap-1 text-[9px] font-bold uppercase tracking-widest px-2 py-0.5 rounded {{ $ucapan->kehadiran === 'hadir' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($ucapan->kehadiran === 'tidak_hadir' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-amber-50 text-amber-600 border border-amber-100') }}">
                                {{ $ucapan->kehadiran }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyInvitationLink(url) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(showCopySuccess).catch(fallbackCopy);
    } else {
        fallbackCopy(url);
    }

    function fallbackCopy(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showCopySuccess();
        } catch (err) {
            Swal.fire({ icon: 'error', title: 'Gagal Salin', text: 'Silakan salin manual: ' + text });
        }
        document.body.removeChild(textArea);
    }

    function showCopySuccess() {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Link undangan berhasil disalin!',
            showConfirmButton: false,
            timer: 2500,
            customClass: {
                popup: 'border-l-4 border-emerald-500 rounded-lg shadow-lg'
            }
        });
    }
}
</script>
@endpush
