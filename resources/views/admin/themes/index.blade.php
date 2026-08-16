@extends('layouts.admin')

@section('title', 'Manajemen Tema')
@section('page-title', 'Manajemen Tema')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Header & Search Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 mb-3">Kelola tema undangan yang tersedia untuk klien.</p>
            <!-- Search -->
            <div class="relative max-w-sm w-full">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="search-theme" placeholder="Cari nama / kode tema..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all bg-white shadow-2xs">
            </div>
        </div>
        <button type="button" onclick="openCreateTheme()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-xs hover:shadow-md transition-all sm:self-end">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Tema
        </button>
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
