@extends('layouts.admin')

@section('title', 'Manajemen Tema')
@section('page-title', 'Manajemen Tema')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Breadcrumb & Header Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <span class="text-slate-800 font-semibold">Manajemen Tema</span>
            </div>
            <p class="text-sm text-slate-500">Kelola katalog desain tema undangan, kategori, harga tambahan, dan status ketersediaan.</p>
        </div>
        <div class="flex items-center gap-2.5 sm:self-end">
            <a href="{{ route('admin.theme-categories.index') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl border border-slate-200 shadow-2xs transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Kategori Tema
            </a>
            <button type="button" onclick="openCreateTheme()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-xs hover:shadow-md transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Tema
            </button>
        </div>
    </div>

    <!-- Live Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-2xs">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-center">
            <!-- Search Input -->
            <div class="lg:col-span-2 relative">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="search-theme" placeholder="Cari nama / kode tema..." 
                       class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all bg-slate-50/50 hover:bg-white focus:bg-white shadow-2xs">
            </div>

            <!-- Filter Kategori -->
            <div>
                <select id="filter-category" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all bg-slate-50/50 hover:bg-white focus:bg-white shadow-2xs font-medium text-slate-700">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}">{{ $cat->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Tingkatan -->
            <div>
                <select id="filter-tingkatan" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all bg-slate-50/50 hover:bg-white focus:bg-white shadow-2xs font-medium text-slate-700">
                    <option value="">Semua Tingkatan</option>
                    <option value="standar">Standar</option>
                    <option value="premium">Premium</option>
                    <option value="eksklusif">Eksklusif VIP</option>
                </select>
            </div>

            <!-- Filter Status & Reset -->
            <div class="flex items-center gap-2">
                <select id="filter-status" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-xs sm:text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all bg-slate-50/50 hover:bg-white focus:bg-white shadow-2xs font-medium text-slate-700">
                    <option value="">Semua Status</option>
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
                <button type="button" id="btn-reset-filters" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors border border-slate-200" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Themes Table Container -->
    <div class="relative min-h-[300px]">
        <div id="themes-table-container">
            @include('admin.themes.partials.table', ['themes' => $themes])
        </div>

        <!-- Loader Overlay -->
        <div id="grid-loader" class="absolute inset-0 z-10 bg-white/60 backdrop-blur-xs flex-col items-center justify-center rounded-2xl hidden">
            <svg class="animate-spin h-8 w-8 text-indigo-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-xs font-semibold text-slate-600">Memuat data tema...</p>
        </div>
    </div>
</div>

<!-- Modal Form -->
@include('admin.themes.partials.modals')

@endsection

@push('scripts')
@include('admin.themes.partials.scripts')
@endpush
