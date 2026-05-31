@extends('layouts.admin')

@section('title', 'Detail Klien — ' . $client->username)
@section('page-title', 'Detail Klien')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Back + Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-admin-accent-dark transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Daftar Klien
        </a>
        <div class="flex items-center gap-3">
            @if($client->invitation)
            <a href="{{ url('/' . $client->invitation->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                Lihat Undangan
            </a>
            @endif
            <a href="{{ route('admin.clients.impersonate', $client->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-admin-accent-dark hover:bg-admin-accent rounded-xl shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                Login sebagai Klien
            </a>
        </div>
    </div>

    <!-- Client Info Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <div class="flex items-center gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-admin-accent/15 flex items-center justify-center text-admin-accent-dark font-bold text-xl">
                    {{ strtoupper(substr($client->username, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">{{ $client->username }}</h2>
                    <p class="text-sm text-slate-400">{{ $client->email }}</p>
                    <p class="text-xs text-slate-400 mt-1">Terdaftar: {{ $client->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            @if($client->invitation)
            <div class="space-y-4 pt-4 border-t border-slate-100">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Slug</span>
                    <span class="text-sm font-mono text-slate-700 bg-slate-50 px-2 py-0.5 rounded">{{ $client->invitation->slug }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Tema</span>
                    <span class="text-sm font-semibold text-indigo-600">{{ $client->invitation->theme->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-slate-500">Mempelai</span>
                    <span class="text-sm font-semibold text-slate-700">{{ $client->invitation->wanita_nama ?? '—' }} & {{ $client->invitation->pria_nama ?? '—' }}</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Status Control -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-5">Kontrol Undangan</h3>
            @if($client->invitation)
            <form id="status-form" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Undangan</label>
                    <select name="status" id="status-select" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
                        <option value="draft" {{ $client->invitation->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="trial" {{ $client->invitation->status === 'trial' ? 'selected' : '' }}>Trial</option>
                        <option value="aktif" {{ $client->invitation->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $client->invitation->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Ubah Tema</label>
                    <select name="theme_id" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
                        @foreach($themes as $theme)
                            <option value="{{ $theme->id }}" {{ $client->invitation->theme_id == $theme->id ? 'selected' : '' }}>{{ $theme->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if($client->invitation->trial_habis_at)
                <div class="p-3 bg-amber-50 rounded-xl border border-amber-200">
                    <p class="text-xs text-amber-700 font-semibold">⏳ Trial berakhir: {{ $client->invitation->trial_habis_at->format('d M Y H:i') }}</p>
                </div>
                @endif
                <button type="submit" id="status-btn" class="w-full bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold py-2.5 rounded-xl transition-all">Simpan Perubahan</button>
            </form>
            @else
            <p class="text-sm text-slate-400">Klien ini belum memiliki undangan.</p>
            @endif
        </div>

        <!-- Statistik Undangan -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-5">Statistik Undangan</h3>
            @if($client->invitation)
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-sky-100 flex items-center justify-center text-sky-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="text-sm text-slate-600">Tamu</span>
                    </div>
                    <span class="text-lg font-extrabold text-slate-700">{{ $client->invitation->tamus->count() }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <span class="text-sm text-slate-600">Ucapan</span>
                    </div>
                    <span class="text-lg font-extrabold text-slate-700">{{ $client->invitation->ucapans->count() }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center text-pink-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-sm text-slate-600">Galeri</span>
                    </div>
                    <span class="text-lg font-extrabold text-slate-700">{{ $client->invitation->galeris->count() }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-sm text-slate-600">Acara</span>
                    </div>
                    <span class="text-lg font-extrabold text-slate-700">{{ $client->invitation->acaras->count() }}</span>
                </div>
            </div>
            @else
            <p class="text-sm text-slate-400">—</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

$('#status-form').on('submit', function(e) {
    e.preventDefault();
    const btn = $('#status-btn');
    btn.prop('disabled', true).text('Menyimpan...');
    $.ajax({
        url: "{{ route('admin.clients.status', $client->id) }}",
        type: 'PATCH',
        data: $(this).serialize(),
    })
    .done(function(res) {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
    })
    .fail(function(xhr) {
        Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' });
    })
    .always(() => btn.prop('disabled', false).text('Simpan Perubahan'));
});
</script>
@endpush
