@extends('layouts.client')

@section('title', 'Overview - Aufilla Invitation')

@section('content')
<div class="w-full">
    <!-- Welcome Panel (Luxury Edition) -->
    <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#0d2a1a] via-[#0a2214] to-[#04120a] text-white p-8 sm:p-12 mb-10 border border-[#c5a880]/20 shadow-[0_20px_50px_rgba(10,34,20,0.4)]">
        
        <!-- Luxury Texture Overlay -->
        <div class="absolute inset-0 opacity-[0.06] mix-blend-overlay pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%23c5a880\' fill-rule=\'evenodd\'/%3E%3C/svg%3E');"></div>
        
        <!-- Deep Glow Orbs -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[radial-gradient(circle_at_center,rgba(197,168,128,0.12)_0%,transparent_60%)] -translate-y-1/3 translate-x-1/3 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[radial-gradient(circle_at_center,rgba(88,139,139,0.1)_0%,transparent_60%)] translate-y-1/3 -translate-x-1/4 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-end justify-between gap-10">
            <!-- Left Text Content -->
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-[#c5a880]/10 border border-[#c5a880]/20 text-[#c5a880] text-[10px] font-bold tracking-[0.2em] uppercase mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#c5a880] animate-pulse"></span>
                    Aufilla Members
                </div>
                
                <h2 class="text-4xl sm:text-5xl font-bold text-white mb-5 leading-tight tracking-tight" style="font-family: 'Playfair Display', serif;">
                    Selamat Datang, <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#e8d5b5] to-[#c5a880]">Calon Mempelai.</span>
                </h2>
                
                <p class="text-white/60 text-[15px] sm:text-base leading-relaxed font-light max-w-xl">
                    @if($invitation->status === 'kedaluwarsa' || $invitation->isExpired())
                        Masa aktif undangan Anda telah habis. Beberapa fitur premium kini terkunci. Silakan hubungi Admin untuk aktivasi perpanjangan.
                    @elseif($invitation->paket)
                        Paket <strong class="text-[#e8d5b5] font-semibold">{{ $invitation->paket->name }}</strong> Anda aktif hingga <strong class="text-[#e8d5b5] font-semibold">{{ $invitation->paket->active_days > 10000 ? 'selamanya' : ($invitation->expired_at ? $invitation->expired_at->format('d M Y') : '-') }}</strong>.
                        @if($invitation->paket->name === 'Trial')
                            Anda sedang dalam masa uji coba (Trial). Hubungi Admin untuk upgrade ke paket permanen.
                        @elseif($invitation->paket->name === 'Basic')
                            Tingkatkan ke Premium atau VIP untuk membuka lebih banyak fitur eksklusif.
                        @elseif($invitation->paket->name === 'Premium')
                            Tingkatkan ke VIP untuk mendapatkan kapasitas foto galeri tanpa batas.
                        @else
                            Nikmati seluruh fitur eksklusif VIP tanpa batas untuk hari bahagia Anda.
                        @endif
                    @else
                        Status undangan Anda saat ini adalah {{ $invitation->status }}.
                    @endif
                </p>
            </div>

            <!-- Right Icon Actions -->
            <div class="flex items-center gap-6 sm:gap-8 shrink-0 pb-2">
                
                <!-- Action 1: Lihat Undangan -->
                <div class="flex flex-col items-center gap-3 group">
                    <a href="{{ route('public.invitation', $invitation->slug) }}" target="_blank" class="w-16 h-16 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-[#c5a880] to-[#e8d5b5] text-[#0a2214] flex items-center justify-center shadow-[0_0_30px_rgba(197,168,128,0.2)] group-hover:shadow-[0_0_40px_rgba(197,168,128,0.5)] transition-all duration-500 transform group-hover:-translate-y-2 relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="w-7 h-7 sm:w-6 sm:h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </a>
                    <span class="text-[10px] sm:text-[11px] uppercase tracking-[0.15em] font-semibold text-[#c5a880] group-hover:-translate-y-1 transition-transform duration-500">Undangan</span>
                </div>

                <!-- Action 2: Pengaturan Tema -->
                <div class="flex flex-col items-center gap-3 group">
                    <a href="{{ route('client.pengaturan') }}" class="w-16 h-16 sm:w-14 sm:h-14 rounded-full bg-white/5 border border-white/10 group-hover:border-[#c5a880]/50 group-hover:bg-[#c5a880]/10 text-white flex items-center justify-center backdrop-blur-md transition-all duration-500 transform group-hover:-translate-y-2 relative">
                        <svg class="w-7 h-7 sm:w-6 sm:h-6 group-hover:text-[#c5a880] group-hover:rotate-45 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                    <span class="text-[10px] sm:text-[11px] uppercase tracking-[0.15em] font-medium text-white/50 group-hover:text-white/90 group-hover:-translate-y-1 transition-all duration-500">Tema</span>
                </div>

                <!-- Action 3: Bantuan / WA -->
                <div class="flex flex-col items-center gap-3 group">
                    <a href="https://wa.me/{{ config('app.activation_wa') }}?text={{ urlencode('Halo Admin Aufilla, saya butuh bantuan terkait undangan dengan username: ' . Auth::user()->username) }}" target="_blank" class="w-16 h-16 sm:w-14 sm:h-14 rounded-full bg-white/5 border border-white/10 group-hover:border-green-400/50 group-hover:bg-green-400/10 text-white flex items-center justify-center backdrop-blur-md transition-all duration-500 transform group-hover:-translate-y-2 relative">
                        <svg class="w-7 h-7 sm:w-6 sm:h-6 group-hover:text-green-400 transition-colors duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </a>
                    <span class="text-[10px] sm:text-[11px] uppercase tracking-[0.15em] font-medium text-white/50 group-hover:text-white/90 group-hover:-translate-y-1 transition-all duration-500">Bantuan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Tamu -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(10,34,20,0.08)] hover:border-brand-accent/30 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#588b8b]/10 text-[#588b8b]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-brand-dark leading-tight">{{ $invitation->tamus()->count() }}</h3>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mt-1">Total Tamu</p>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-[radial-gradient(circle,rgba(197,168,128,0.06)_0%,transparent_70%)] rounded-full"></div>
        </div>

        <!-- Reservasi -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(10,34,20,0.08)] hover:border-brand-accent/30 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-brand-dark/5 text-brand-dark">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-brand-dark leading-tight">{{ $invitation->ucapans()->where('kehadiran', 'hadir')->count() ?? 0 }}</h3>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mt-1">Hadir</p>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-[radial-gradient(circle,rgba(197,168,128,0.06)_0%,transparent_70%)] rounded-full"></div>
        </div>
        
        <!-- Ucapan -->
        <div class="bg-white rounded-2xl p-6 border border-brand-accent/10 shadow-[0_10px_30px_rgba(10,34,20,0.03)] hover:-translate-y-1 hover:shadow-[0_12px_30px_rgba(10,34,20,0.08)] hover:border-brand-accent/30 transition-all duration-300 relative overflow-hidden group">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-brand-accent/15 text-brand-accent-dark">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-brand-dark leading-tight">{{ $invitation->ucapans()->count() ?? 0 }}</h3>
                    <p class="text-gray-500 font-medium text-xs uppercase tracking-wider mt-1">Ucapan</p>
                </div>
            </div>
            <div class="absolute bottom-0 right-0 w-20 h-20 bg-[radial-gradient(circle,rgba(197,168,128,0.06)_0%,transparent_70%)] rounded-full"></div>
        </div>

        <!-- Panduan -->
        <a href="{{ route('client.tutorial') }}" class="bg-gradient-to-br from-[#c5a880] to-[#a3865c] rounded-2xl p-6 border border-[#c5a880]/20 shadow-[0_10px_30px_rgba(197,168,128,0.2)] hover:-translate-y-1 hover:shadow-[0_15px_35px_rgba(197,168,128,0.4)] transition-all duration-300 relative overflow-hidden group block">
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-white/20 text-white backdrop-blur-sm border border-white/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white leading-tight mb-1">Panduan</h3>
                    <p class="text-white/80 font-medium text-xs tracking-wider uppercase">Pelajari Sistem</p>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -translate-y-1/2 translate-x-1/3 group-hover:scale-150 transition-transform duration-700"></div>
        </a>
    </div>

    <!-- Ucapan Terbaru -->
    <div class="bg-white rounded-[2rem] border border-brand-accent/20 shadow-sm p-6 lg:p-8 relative overflow-hidden group">
        <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-5">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                Ucapan & Doa Terbaru
            </h3>
            <span class="text-xs text-brand-dark bg-brand-dark/5 px-3 py-1 rounded-full font-bold ring-1 ring-brand-dark/10">{{ $invitation->ucapans()->count() }} Pesan</span>
        </div>
        
        <div class="pt-2">
            @if(isset($recentUcapans) && $recentUcapans->isEmpty())
                <div class="h-40 flex flex-col items-center justify-center text-gray-400">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <p class="text-sm font-medium">Belum ada ucapan yang masuk dari tamu undangan Anda.</p>
                </div>
            @else
                <div class="space-y-4 max-h-[400px] overflow-y-auto custom-scrollbar pr-2">
                    @foreach($recentUcapans as $ucapan)
                    <div class="flex gap-4 p-5 rounded-2xl bg-gray-50/50 border border-gray-100 hover:bg-white hover:border-brand-accent/30 hover:shadow-md transition-all duration-300">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-accent/10 to-brand-accent/30 flex items-center justify-center text-brand-dark font-extrabold text-lg flex-shrink-0 shadow-sm">
                            {{ strtoupper(substr($ucapan->nama ?? '?', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="text-base font-bold text-gray-800 truncate">{{ $ucapan->nama }}</span>
                                <span class="text-[11px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-lg flex-shrink-0">{{ $ucapan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed mb-2">"{{ $ucapan->ucapan ?? $ucapan->pesan ?? '-' }}"</p>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded-md {{ $ucapan->kehadiran === 'hadir' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($ucapan->kehadiran === 'tidak_hadir' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-amber-50 text-amber-600 border border-amber-100') }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $ucapan->kehadiran === 'hadir' ? 'bg-emerald-500' : ($ucapan->kehadiran === 'tidak_hadir' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                                    {{ $ucapan->kehadiran }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
