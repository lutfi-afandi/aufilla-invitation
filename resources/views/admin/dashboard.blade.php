@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-admin-dark via-admin-medium to-admin-light text-white p-8 sm:p-10 border border-white/10 shadow-xl">
        <div class="relative z-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mb-2">Selamat Datang, {{ Auth::user()->username }}!</h2>
            <p class="text-slate-300 max-w-2xl text-base leading-relaxed">
                Kelola seluruh undangan, klien, tema, dan resepsionis dari satu tempat.
            </p>
        </div>
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-admin-accent opacity-10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-5 right-20 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Klien -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-admin-accent-dark">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider text-admin-accent bg-indigo-50 px-2.5 py-1 rounded-full">Klien</span>
            </div>
            <h3 class="text-3xl font-extrabold text-admin-dark">{{ $totalClients }}</h3>
            <p class="text-sm text-slate-400 mt-1">Total Klien Terdaftar</p>
        </div>

        <!-- Undangan Aktif -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full">Aktif</span>
            </div>
            <h3 class="text-3xl font-extrabold text-admin-dark">{{ $activeInvitations }}</h3>
            <p class="text-sm text-slate-400 mt-1">Undangan Aktif</p>
        </div>

        <!-- Undangan Trial -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Trial</span>
            </div>
            <h3 class="text-3xl font-extrabold text-admin-dark">{{ $trialInvitations }}</h3>
            <p class="text-sm text-slate-400 mt-1">Undangan Trial</p>
        </div>

        <!-- Total Tamu -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm hover:-translate-y-1 hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-600 bg-sky-50 px-2.5 py-1 rounded-full">Tamu</span>
            </div>
            <h3 class="text-3xl font-extrabold text-admin-dark">{{ $totalGuests }}</h3>
            <p class="text-sm text-slate-400 mt-1">Total Tamu Global</p>
        </div>
    </div>

    <!-- Bottom Grid: Draft + Recent Ucapan -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Statistik Undangan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-5">Status Undangan</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="text-sm text-slate-600">Aktif</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $activeInvitations }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                        <span class="text-sm text-slate-600">Trial</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $trialInvitations }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-slate-400"></div>
                        <span class="text-sm text-slate-600">Draft</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $draftInvitations }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <span class="text-sm text-slate-600">Nonaktif</span>
                    </div>
                    <span class="text-sm font-bold text-slate-700">{{ $nonaktifInvitations }}</span>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-semibold text-slate-600">Total</span>
                    <span class="text-sm font-extrabold text-admin-dark">{{ $activeInvitations + $trialInvitations + $draftInvitations + $nonaktifInvitations }}</span>
                </div>
            </div>
        </div>

        <!-- Ucapan Terbaru -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400">Ucapan Terbaru</h3>
                <span class="text-xs text-admin-accent font-semibold">{{ $totalUcapan }} total</span>
            </div>
            @if($recentUcapans->isEmpty())
                <div class="text-center py-10 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    <p class="text-sm">Belum ada ucapan masuk.</p>
                </div>
            @else
                <div class="space-y-4 max-h-72 overflow-y-auto custom-scrollbar pr-2">
                    @foreach($recentUcapans as $ucapan)
                    <div class="flex gap-4 p-4 rounded-xl bg-slate-50/80 border border-slate-100 hover:bg-slate-50 transition-colors">
                        <div class="w-9 h-9 rounded-full bg-admin-accent/15 flex items-center justify-center text-admin-accent-dark font-bold text-xs flex-shrink-0">
                            {{ strtoupper(substr($ucapan->nama ?? '?', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <span class="text-sm font-bold text-slate-700 truncate">{{ $ucapan->nama }}</span>
                                <span class="text-[10px] text-slate-400 flex-shrink-0">{{ $ucapan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-500 line-clamp-2">{{ $ucapan->pesan ?? '-' }}</p>
                            <span class="inline-block mt-1.5 text-[10px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $ucapan->kehadiran === 'hadir' ? 'bg-emerald-100 text-emerald-700' : ($ucapan->kehadiran === 'tidak' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-700') }}">{{ $ucapan->kehadiran }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
