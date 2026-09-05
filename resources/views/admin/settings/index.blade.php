@extends('layouts.admin')

@section('title', 'Pengaturan Website & Aplikasi')
@section('page-title', 'Pengaturan Website')

@section('content')
<div class="max-w-5xl mx-auto w-full space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                <span class="text-slate-800 font-semibold">Pengaturan Website</span>
            </div>
            <p class="text-sm text-slate-500">Kelola identitas brand aplikasi, kontak layanan, SEO meta tags, dan daftar FAQ landing page.</p>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-slate-100/80 p-1.5 rounded-2xl border border-slate-200/60 inline-flex flex-wrap gap-1 w-full sm:w-auto">
        <button type="button" onclick="switchSettingTab('general')" id="tab-btn-general"
                class="setting-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-bold bg-white text-indigo-600 shadow-2xs transition-all cursor-pointer">
            Identitas & Brand
        </button>
        <button type="button" onclick="switchSettingTab('contact')" id="tab-btn-contact"
                class="setting-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-medium text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
            Kontak & Sosmed
        </button>
        <button type="button" onclick="switchSettingTab('seo')" id="tab-btn-seo"
                class="setting-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-medium text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
            SEO & Meta Share
        </button>
        <button type="button" onclick="switchSettingTab('faq')" id="tab-btn-faq"
                class="setting-tab-btn px-4 py-2 rounded-xl text-xs sm:text-sm font-medium text-slate-600 hover:text-slate-900 transition-all cursor-pointer">
            Daftar FAQ
        </button>
    </div>

    <!-- Tab Contents Container -->
    <div class="space-y-6">
        @include('admin.settings.partials.tab-general')
        @include('admin.settings.partials.tab-contact')
        @include('admin.settings.partials.tab-seo')
        @include('admin.settings.partials.tab-faq')
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/Sortable.min.js') }}"></script>
@include('admin.settings.partials.scripts')
@endpush
