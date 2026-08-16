@extends('layouts.admin')

@section('title', 'Manajemen Paket')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Manajemen Paket</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola harga, masa aktif (durasi), dan kustomisasi limit fitur paket
                    undangan.</p>
            </div>
            <button onclick="openModalCreate()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-admin-accent hover:bg-admin-accent/90 text-white rounded-xl font-medium text-sm transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Paket
            </button>
        </div>

        <!-- Cards Grid -->
        @include('admin.pakets.partials.list', ['pakets' => $pakets])
    </div>

    <!-- Modal Form -->
    @include('admin.pakets.partials.modals')

@endsection

@push('scripts')
    @include('admin.pakets.partials.scripts')
@endpush
