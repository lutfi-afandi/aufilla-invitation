@extends('layouts.receptionist')

@section('title', 'Dashboard Resepsionis')
@section('header_title', 'Daftar Undangan Aktif')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Search Bar -->
    <div class="bg-white p-3 rounded-2xl shadow-sm border border-slate-200/60 max-w-3xl">
        <form action="{{ route('receptionist.dashboard') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="w-full pl-11 pr-4 py-3 bg-slate-50/50 border border-transparent hover:bg-slate-50 focus:bg-white rounded-xl focus:ring-2 focus:ring-recept-primary/20 focus:border-recept-primary text-slate-800 placeholder-slate-400 transition-all font-medium" placeholder="Cari nama pengantin atau slug...">
            </div>
            <button type="submit" class="px-6 py-3 bg-recept-dark text-white rounded-xl font-semibold hover:bg-slate-800 transition-colors shadow-sm whitespace-nowrap">
                Cari Undangan
            </button>
            @if(request('search'))
                <a href="{{ route('receptionist.dashboard') }}" class="px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-medium hover:bg-slate-200 transition-colors flex items-center justify-center" title="Reset Pencarian">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </form>
    </div>

    <!-- Invitations Grid -->
    @if($invitations->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($invitations as $inv)
                <div class="bg-white rounded-[1.25rem] shadow-sm border border-slate-200/60 overflow-hidden flex flex-col group hover:shadow-xl hover:-translate-y-1 hover:border-recept-primary/30 transition-all duration-300 ease-out">
                    <!-- Card Header / Image -->
                    <div class="h-36 relative bg-slate-900 overflow-hidden">
                        @if($inv->cover_img)
                            <img src="{{ asset('storage/'.$inv->cover_img) }}" class="w-full h-full object-cover opacity-50 group-hover:opacity-70 group-hover:scale-105 transition-all duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-tr from-slate-800 to-slate-900 group-hover:scale-105 transition-transform duration-700"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                        
                        <div class="absolute bottom-4 left-5 right-5">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 mb-2 backdrop-blur-md">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Aktif
                            </span>
                            <h3 class="text-xl md:text-2xl font-bold text-white leading-tight drop-shadow-md truncate">
                                {{ $inv->pria_nama ?? 'Pria' }} &amp; {{ $inv->wanita_nama ?? 'Wanita' }}
                            </h3>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1 flex flex-col justify-between gap-6">
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm border-b border-slate-100 pb-3">
                                <span class="text-slate-500 font-medium">Klien / Akun</span>
                                <span class="font-bold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md">{{ $inv->user->username ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500 font-medium">Domain Path</span>
                                <span class="font-bold text-recept-primary truncate ml-4">/{{ $inv->slug }}</span>
                            </div>
                        </div>

                        <a href="{{ route('receptionist.buku-tamu', $inv->id) }}" class="w-full flex items-center justify-center gap-2 py-3 bg-recept-primary text-white rounded-xl font-semibold hover:bg-recept-primary-hover hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-300 active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                            Buka Buku Tamu
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $invitations->links() }}
        </div>
    @else
        <div class="bg-white p-12 rounded-2xl shadow-sm border border-slate-100 text-center">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Belum Ada Undangan Aktif</h3>
            <p class="text-slate-500">Tidak ada undangan pernikahan yang aktif atau cocok dengan kata kunci pencarian Anda.</p>
        </div>
    @endif
</div>
@endsection
