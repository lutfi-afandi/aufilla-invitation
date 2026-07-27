@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@push('styles')
<style>
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}
.delay-100 { animation-delay: 100ms; }
.delay-200 { animation-delay: 200ms; }
.delay-300 { animation-delay: 300ms; }
.delay-400 { animation-delay: 400ms; }
</style>
@endpush

@section('content')
<div class="w-full space-y-8">
    <!-- Welcome Banner -->
    <div class="animate-fade-in-up relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-admin-dark via-admin-medium to-admin-light text-white p-8 sm:p-10 border border-white/10 shadow-2xl shadow-admin-dark/20 group">
        <div class="relative z-10 transition-transform duration-500 group-hover:translate-x-2">
            <h2 class="text-2xl sm:text-4xl font-extrabold text-white mb-3 tracking-tight">Selamat Datang, {{ Auth::user()->username }}! 👋</h2>
            <p class="text-slate-300 max-w-2xl text-base sm:text-lg leading-relaxed font-medium">
                Kelola seluruh undangan, klien, tema, dan pantau aktivitas dengan mudah dari satu pusat kendali.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-72 h-72 bg-admin-accent opacity-20 rounded-full blur-3xl pointer-events-none transition-transform duration-700 group-hover:scale-125"></div>
        <div class="absolute top-5 right-20 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl pointer-events-none transition-transform duration-700 group-hover:-translate-y-5"></div>
        <!-- Decorative Grid -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9InJnYmEoMjU1LDI1NSwyNTUsMC4wNSkiLz48L3N2Zz4=')] opacity-50 mask-image:linear-gradient(to_bottom,transparent,black)]"></div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Klien -->
        <div class="animate-fade-in-up delay-100 bg-white rounded-[2rem] p-6 border border-slate-200/60 shadow-sm hover:-translate-y-1.5 hover:shadow-xl hover:shadow-indigo-500/10 hover:border-indigo-200/60 transition-all duration-300 group cursor-default relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-[100px] -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-100 to-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-100/50 px-3 py-1.5 rounded-full ring-1 ring-indigo-200/50">Klien</span>
                </div>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ $totalClients }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Total Terdaftar</p>
            </div>
        </div>

        <!-- Undangan Aktif -->
        <div class="animate-fade-in-up delay-200 bg-white rounded-[2rem] p-6 border border-slate-200/60 shadow-sm hover:-translate-y-1.5 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-200/60 transition-all duration-300 group cursor-default relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-[100px] -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-100/50 px-3 py-1.5 rounded-full ring-1 ring-emerald-200/50">Aktif</span>
                </div>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ $activeInvitations }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Undangan Aktif</p>
            </div>
        </div>

        <!-- Undangan Trial -->
        <div class="animate-fade-in-up delay-300 bg-white rounded-[2rem] p-6 border border-slate-200/60 shadow-sm hover:-translate-y-1.5 hover:shadow-xl hover:shadow-amber-500/10 hover:border-amber-200/60 transition-all duration-300 group cursor-default relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-50 rounded-bl-[100px] -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-50 flex items-center justify-center text-amber-600 shadow-inner group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-100/50 px-3 py-1.5 rounded-full ring-1 ring-amber-200/50">Trial</span>
                </div>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ $trialInvitations }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Masa Uji Coba</p>
            </div>
        </div>

        <!-- Total Tamu -->
        <div class="animate-fade-in-up delay-400 bg-white rounded-[2rem] p-6 border border-slate-200/60 shadow-sm hover:-translate-y-1.5 hover:shadow-xl hover:shadow-sky-500/10 hover:border-sky-200/60 transition-all duration-300 group cursor-default relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-sky-50 rounded-bl-[100px] -mr-10 -mt-10 transition-transform duration-500 group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-100 to-sky-50 flex items-center justify-center text-sky-600 shadow-inner group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-sky-600 bg-sky-100/50 px-3 py-1.5 rounded-full ring-1 ring-sky-200/50">Global</span>
                </div>
                <h3 class="text-4xl font-extrabold text-slate-800">{{ $totalGuests }}</h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Tamu Undangan</p>
            </div>
        </div>
    </div>

    <!-- Bottom Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Visual Progress Bar Status Undangan -->
        <div class="animate-fade-in-up delay-300 bg-white rounded-[2rem] border border-slate-200/80 shadow-sm p-8 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-400 via-amber-400 to-red-400"></div>
            
            <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-8 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                Komposisi Status
            </h3>
            
            <div class="space-y-6">
                <!-- Aktif -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700 flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Aktif</span>
                        <span class="text-sm font-extrabold text-emerald-600">{{ $activeInvitations }} <span class="text-xs text-slate-400 font-medium ml-1">({{ $pctActive }}%)</span></span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 shadow-inner overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-400 to-emerald-500 h-2.5 rounded-full relative" style="width: {{ $pctActive }}%">
                            <div class="absolute inset-0 bg-white/20 w-full animate-[pulse_2s_ease-in-out_infinite]"></div>
                        </div>
                    </div>
                </div>

                <!-- Trial -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700 flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>Trial</span>
                        <span class="text-sm font-extrabold text-amber-500">{{ $trialInvitations }} <span class="text-xs text-slate-400 font-medium ml-1">({{ $pctTrial }}%)</span></span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 shadow-inner overflow-hidden">
                        <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-2.5 rounded-full" style="width: {{ $pctTrial }}%"></div>
                    </div>
                </div>

                <!-- Nonaktif/Expired -->
                <div>
                    <div class="flex justify-between items-end mb-2">
                        <span class="text-sm font-bold text-slate-700 flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Expired</span>
                        <span class="text-sm font-extrabold text-red-500">{{ $expiredInvitations }} <span class="text-xs text-slate-400 font-medium ml-1">({{ $pctExpired }}%)</span></span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2.5 shadow-inner overflow-hidden">
                        <div class="bg-gradient-to-r from-red-400 to-red-500 h-2.5 rounded-full" style="width: {{ $pctExpired }}%"></div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-slate-100 flex items-center justify-between bg-slate-50 -mx-8 -mb-8 px-8 py-5">
                <span class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Keseluruhan</span>
                <span class="text-xl font-extrabold text-admin-dark bg-white px-4 py-1.5 rounded-xl border border-slate-200 shadow-sm">{{ $totalInvitations }}</span>
            </div>
        </div>

        <!-- Ucapan Terbaru -->
        <div class="animate-fade-in-up delay-400 lg:col-span-2 bg-white rounded-[2rem] border border-slate-200/80 shadow-sm hover:shadow-lg transition-shadow duration-300 flex flex-col overflow-hidden">
            <div class="p-8 pb-5 flex items-center justify-between border-b border-slate-100">
                <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    Live: Ucapan Terbaru
                </h3>
                <span class="text-xs text-admin-accent bg-indigo-50 px-3 py-1 rounded-full font-bold ring-1 ring-indigo-200/50">{{ $totalUcapan }} Respon Global</span>
            </div>
            
            <div class="flex-1 p-8 pt-4">
                @if($recentUcapans->isEmpty())
                    <div class="h-full flex flex-col items-center justify-center text-slate-400 animate-pulse">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Belum ada ucapan yang masuk.</p>
                    </div>
                @else
                    <div class="space-y-4 max-h-[320px] overflow-y-auto custom-scrollbar pr-2">
                        @foreach($recentUcapans as $ucapan)
                        <div class="flex gap-4 p-5 rounded-2xl bg-slate-50/50 border border-slate-100 hover:bg-white hover:border-indigo-100 hover:shadow-md transition-all duration-300 group">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-50 to-admin-accent/10 flex items-center justify-center text-admin-accent-dark font-extrabold text-lg flex-shrink-0 group-hover:scale-110 group-hover:-rotate-6 transition-transform shadow-sm">
                                {{ strtoupper(substr($ucapan->nama ?? '?', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2 mb-1.5">
                                    <span class="text-base font-bold text-slate-800 truncate">{{ $ucapan->nama }}</span>
                                    <span class="text-[11px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-lg flex-shrink-0">{{ $ucapan->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-2">"{{ $ucapan->pesan ?? '-' }}"</p>
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold uppercase tracking-widest px-2 py-1 rounded-md {{ $ucapan->kehadiran === 'hadir' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($ucapan->kehadiran === 'tidak' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-amber-50 text-amber-600 border border-amber-100') }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $ucapan->kehadiran === 'hadir' ? 'bg-emerald-500' : ($ucapan->kehadiran === 'tidak' ? 'bg-red-500' : 'bg-amber-500') }}"></span>
                                        {{ $ucapan->kehadiran }}
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">via {{ $ucapan->invitation->slug ?? 'Unknown' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
