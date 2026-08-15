@extends('layouts.admin')

@section('title', 'Manajemen Paket')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Paket</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola harga, masa aktif (durasi), dan kustomisasi limit fitur paket undangan.</p>
        </div>
        <button onclick="openModalCreate()" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-admin-accent hover:bg-admin-accent/90 text-white rounded-xl font-medium text-sm transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Paket
        </button>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-sm font-medium">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 bg-rose-50 text-rose-700 border border-rose-200 rounded-xl text-sm font-medium">
        {{ session('error') }}
    </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($pakets as $paket)
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between relative overflow-hidden">
            @if($paket->name === 'Trial')
            <span class="absolute top-3 right-3 px-2.5 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full uppercase tracking-wider">Default Trial</span>
            @endif

            <div>
                <h3 class="text-lg font-bold text-slate-800">{{ $paket->name }}</h3>
                <div class="mt-3 flex items-baseline gap-1">
                    <span class="text-3xl font-black text-slate-900">Rp {{ number_format($paket->price, 0, ',', '.') }}</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Durasi: <span class="font-bold text-slate-700">{{ $paket->active_days }} Hari</span></p>

                <div class="my-4 border-t border-slate-100"></div>

                <ul class="space-y-2.5 text-xs text-slate-600">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Limit Kirim WA: <span class="font-bold text-slate-800">{{ $paket->max_wa_send > 10000 ? 'Unlimited' : $paket->max_wa_send . ' Kirim' }}</span>
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Maksimal {{ $paket->max_gallery_photos }} Foto Galeri
                    </li>
                    <li class="flex items-center gap-2">
                        @if($paket->has_love_story)
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium text-slate-700">Fitur Cerita Cinta</span>
                        @else
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="text-slate-400">Tanpa Cerita Cinta</span>
                        @endif
                    </li>
                    <li class="flex items-center gap-2">
                        @if($paket->can_custom_music)
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-medium text-slate-700">Kustom Musik Latar</span>
                        @else
                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        <span class="text-slate-400">Musik Default</span>
                        @endif
                    </li>
                </ul>

                @if($paket->description)
                <p class="text-xs text-slate-400 mt-4 italic bg-slate-50 p-2.5 rounded-lg border border-slate-100">{{ $paket->description }}</p>
                @endif
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400 font-medium">{{ $paket->undangans_count }} Pengguna</span>
                <div class="flex items-center gap-2">
                    <button onclick="openModalEdit({{ json_encode($paket) }})" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit Paket">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>

                    @if($paket->name !== 'Trial')
                    <form action="{{ route('admin.pakets.destroy', $paket->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Paket">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Form -->
<div id="paketModal" class="fixed inset-0 z-[99999] hidden bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl space-y-4">
        <h3 id="modalTitle" class="text-lg font-bold text-slate-800">Tambah Paket Baru</h3>

        <form id="paketForm" method="POST" action="{{ route('admin.pakets.store') }}" class="space-y-4">
            @csrf
            <div id="methodField"></div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Paket</label>
                <input type="text" name="name" id="paket_name" required class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga (Rp)</label>
                    <input type="number" name="price" id="paket_price" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Masa Aktif (Hari)</label>
                    <input type="number" name="active_days" id="paket_active_days" required min="1" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Maks Kirim WA</label>
                    <input type="number" name="max_wa_send" id="paket_max_wa_send" required min="1" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Maks Foto Galeri</label>
                    <input type="number" name="max_gallery_photos" id="paket_max_gallery_photos" required min="0" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none">
                </div>
            </div>

            <div class="space-y-2 pt-2 border-t border-slate-100">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="has_love_story" id="paket_has_love_story" class="rounded border-slate-300 text-admin-accent focus:ring-admin-accent">
                    <span class="text-xs font-semibold text-slate-700">Dukungan Fitur Cerita Cinta</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="can_custom_music" id="paket_can_custom_music" class="rounded border-slate-300 text-admin-accent focus:ring-admin-accent">
                    <span class="text-xs font-semibold text-slate-700">Dukungan Kustom Musik Latar</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_priority_support" id="paket_is_priority_support" class="rounded border-slate-300 text-admin-accent focus:ring-admin-accent">
                    <span class="text-xs font-semibold text-slate-700">Priority Support</span>
                </label>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                <textarea name="description" id="paket_description" rows="2" class="w-full px-3.5 py-2 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-admin-accent focus:outline-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">Batal</button>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-admin-accent hover:bg-admin-accent/90 rounded-xl shadow-sm transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalCreate() {
        document.getElementById('modalTitle').innerText = 'Tambah Paket Baru';
        document.getElementById('paketForm').action = "{{ route('admin.pakets.store') }}";
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('paket_name').value = '';
        document.getElementById('paket_price').value = 0;
        document.getElementById('paket_active_days').value = 30;
        document.getElementById('paket_max_wa_send').value = 99999;
        document.getElementById('paket_max_gallery_photos').value = 10;
        document.getElementById('paket_has_love_story').checked = false;
        document.getElementById('paket_can_custom_music').checked = false;
        document.getElementById('paket_is_priority_support').checked = false;
        document.getElementById('paket_description').value = '';
        document.getElementById('paketModal').classList.remove('hidden');
    }

    function openModalEdit(paket) {
        document.getElementById('modalTitle').innerText = 'Edit Paket: ' + paket.name;
        document.getElementById('paketForm').action = "/admin/pakets/" + paket.id;
        document.getElementById('methodField').innerHTML = '@method("PUT")';
        document.getElementById('paket_name').value = paket.name;
        document.getElementById('paket_price').value = paket.price;
        document.getElementById('paket_active_days').value = paket.active_days;
        document.getElementById('paket_max_wa_send').value = paket.max_wa_send || 99999;
        document.getElementById('paket_max_gallery_photos').value = paket.max_gallery_photos;
        document.getElementById('paket_has_love_story').checked = !!paket.has_love_story;
        document.getElementById('paket_can_custom_music').checked = !!paket.can_custom_music;
        document.getElementById('paket_is_priority_support').checked = !!paket.is_priority_support;
        document.getElementById('paket_description').value = paket.description || '';
        document.getElementById('paketModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('paketModal').classList.add('hidden');
    }
</script>
@endsection
