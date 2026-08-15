@extends('layouts.admin')

@section('title', 'Manajemen Klien')
@section('page-title', 'Manajemen Klien')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Klien</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar pengguna dan status undangan aktif / kedaluwarsa.</p>
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Klien
        </button>
    </div>

    <!-- Table with DataTables -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-4 overflow-hidden" id="clients-table-container">
        <table id="clients-table" class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Username</th>
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Link Slug</th>
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Paket</th>
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Tema</th>
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Status</th>
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Terdaftar</th>
                    <th class="text-left px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Expired</th>
                    <th class="text-center px-6 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($clients as $client)
                    @include('admin.clients.partials.row', ['client' => $client])
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Create Client Modal -->
<div id="create-modal" class="fixed inset-0 z-[99999] bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-xl text-slate-800">Tambah Klien Baru</h3>
            <button onclick="closeModal('create-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="create-form" class="p-6 space-y-4">
            @csrf
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Tema Undangan <span class="text-red-500">*</span></label>
                <input type="hidden" name="theme_id" id="create-theme-id" required>
                <button type="button" onclick="openThemePicker('create')" class="w-full flex items-center justify-between p-3 bg-white border-2 border-slate-200 rounded-xl hover:border-admin-accent transition-all text-left group shadow-sm">
                    <div class="flex items-center gap-3">
                        <div id="create-theme-icon" class="w-12 h-16 bg-slate-50 rounded-lg border border-slate-100 flex items-center justify-center shrink-0 overflow-hidden">
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span id="create-theme-name" class="block font-bold text-slate-700 text-sm mb-0.5">Belum memilih tema</span>
                            <span class="block text-xs text-slate-500">Klik untuk memilih dari katalog</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 group-hover:bg-admin-accent group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" id="create-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Username login">
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">URL Slug Undangan <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="create-slug" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Slug URL (misal: romeo-juliet)">
                </div>
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="contoh@email.com">
            </div>

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Paket Undangan <span class="text-red-500">*</span></label>
                <select name="package_id" id="create-package" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Minimal 6 karakter">
            </div>
            
            <div class="pt-2">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent-dark transition duration-150 shadow-sm">
                    Buat Akun Klien
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Client Modal -->
<div id="edit-modal" class="fixed inset-0 z-[99999] bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-xl text-slate-800">Edit Klien</h3>
            <button onclick="closeModal('edit-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="edit-form" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id">
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Tema Undangan <span class="text-red-500">*</span></label>
                <input type="hidden" name="theme_id" id="edit-theme-id" required>
                <button type="button" onclick="openThemePicker('edit')" class="w-full flex items-center justify-between p-3 bg-white border-2 border-slate-200 rounded-xl hover:border-admin-accent transition-all text-left group shadow-sm">
                    <div class="flex items-center gap-3">
                        <div id="edit-theme-icon" class="w-12 h-16 bg-slate-50 rounded-lg border border-slate-100 flex items-center justify-center shrink-0 overflow-hidden">
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span id="edit-theme-name" class="block font-bold text-slate-700 text-sm mb-0.5">Belum memilih tema</span>
                            <span class="block text-xs text-slate-500">Klik untuk mengubah tema</span>
                        </div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center shrink-0 group-hover:bg-admin-accent group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </button>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="username" id="edit-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">URL Slug Undangan <span class="text-red-500">*</span></label>
                    <input type="text" name="slug" id="edit-slug" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                </div>
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" id="edit-email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700" placeholder="contoh@email.com">
            </div>

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Paket Undangan <span class="text-red-500">*</span></label>
                <select name="package_id" id="edit-package" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="edit-status" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                        <option value="aktif">Aktif</option>
                        <option value="kedaluwarsa">Kedaluwarsa</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-1">Password Baru <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                    <input type="password" name="password" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Biarkan kosong">
                </div>
            </div>
            
            <div class="pt-2">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent-dark transition duration-150 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Detail Client Modal -->
<div id="detail-modal" class="fixed inset-0 z-[99999] bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-xl overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
            <h3 class="font-bold text-xl text-slate-800">Detail Klien</h3>
            <button onclick="closeModal('detail-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="p-6">
            <div id="detail-loader" class="py-12 text-center flex flex-col items-center justify-center text-slate-400">
                <svg class="w-8 h-8 animate-spin mb-3 text-admin-accent" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <p>Memuat data...</p>
            </div>
            <div id="detail-content" style="display:none;" class="space-y-4">
                <!-- Data will be injected here via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Theme Picker Modal -->
<div id="theme-picker-modal" class="fixed inset-0 z-[100000] bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col max-h-[85vh]">
        <div class="bg-admin-dark p-5 text-white flex justify-between items-center shrink-0">
            <h3 class="font-bold text-lg">Pilih Tema Undangan</h3>
            <button onclick="closeThemePicker()" class="text-white/60 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <div class="p-4 border-b border-slate-100 bg-slate-50 shrink-0">
            <div class="relative max-w-md w-full mx-auto">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" id="search-theme-picker" placeholder="Cari nama tema..." onkeyup="filterThemes()" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all bg-white">
            </div>
        </div>
        <div class="p-6 overflow-y-auto">
            @include('admin.clients.partials.theme-picker-grid')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

let clientsTable;

$(document).ready(function() {
    clientsTable = $('#clients-table').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Cari username, slug, email, paket...",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ klien",
            infoEmpty: "Menampilkan 0 data",
            zeroRecords: "Tidak ada data klien yang cocok",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "→",
                previous: "←"
            }
        },
        pageLength: 10,
        order: [[5, 'desc']],
        columnDefs: [
            { orderable: false, targets: 7 }
        ]
    });

    // Auto-fill slug from username on create
    $('#create-username').on('input', function() {
        $('#create-slug').val($(this).val());
    });
});

let currentPickerTarget = 'create';

function openCreateModal() { 
    $('#create-form')[0].reset();
    $('#create-theme-id').val('');
    $('#create-theme-name').text('Belum memilih tema').removeClass('text-slate-800').addClass('text-slate-600');
    $('#create-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
    $('#create-form').find('button[type=submit]').prop('disabled', false);
    $('#create-modal').css('display', 'flex'); 
}

function closeModal(id) { $('#' + id).css('display', 'none'); }

function openEditModal(client) {
    $('#edit-form')[0].reset();
    $('#edit-id').val(client.id);
    $('#edit-username').val(client.username);
    $('#edit-email').val(client.email);
    
    const und = client.undangans ? client.undangans[0] : null;

    if (und) {
        $('#edit-slug').val(und.slug);
        $('#edit-status').val(und.status);
        $('#edit-package').val(und.paket_id || '');
        if (und.tema) {
            $('#edit-theme-id').val(und.tema_id);
            $('#edit-theme-name').text(und.tema.name).removeClass('text-slate-600').addClass('text-slate-800 font-bold');
            if (und.tema.thumbnail) {
                $('#edit-theme-icon').html(`<img src="/storage/${und.tema.thumbnail}" class="w-full h-full object-cover">`);
            } else {
                $('#edit-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
            }
        } else {
            $('#edit-theme-id').val('');
            $('#edit-theme-name').text('Belum memilih tema').removeClass('text-slate-800 font-bold').addClass('text-slate-600');
            $('#edit-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
        }
    } else {
        $('#edit-slug').val(client.username);
        $('#edit-status').val('aktif');
        $('#edit-package').val('');
        $('#edit-theme-id').val('');
        $('#edit-theme-name').text('Belum memilih tema').removeClass('text-slate-800 font-bold').addClass('text-slate-600');
        $('#edit-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
    }
    
    $('#edit-form').find('button[type=submit]').prop('disabled', false);
    $('#edit-modal').css('display', 'flex');
}

function openDetailModal(id) {
    $('#detail-content').hide();
    $('#detail-loader').show();
    $('#detail-modal').css('display', 'flex');

    $.get("/admin/clients/" + id)
        .done(function(res) {
            const client = res.client;
            const inv = res.undangan;
            
            let statusBadge = '<span class="text-xs bg-slate-100 text-slate-500 px-2 py-1 rounded">Belum ada</span>';
            let themeName = '-';
            let packageName = '-';
            let trialHabis = '-';
            let slugLink = '-';
            
            if (inv) {
                const s = inv.status;
                const colors = { aktif: 'bg-emerald-100 text-emerald-700', kedaluwarsa: 'bg-red-100 text-red-600' };
                statusBadge = `<span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full ${colors[s] || 'bg-slate-100 text-slate-500'}">${s}</span>`;
                
                if (inv.tema) themeName = inv.tema.name;
                if (inv.paket) packageName = inv.paket.name;
                if (inv.slug) slugLink = `/${inv.slug}`;
                
                if (inv.expired_at) {
                    trialHabis = new Date(inv.expired_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
                }
            }

            const html = `
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-50 to-admin-accent/20 flex items-center justify-center text-admin-accent-dark font-bold text-2xl shadow-sm border border-admin-accent/10">
                        ${client.username.substring(0,2).toUpperCase()}
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-800">${client.username}</h4>
                        <p class="text-slate-500 text-sm flex items-center gap-1.5 mt-1">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            ${client.email || 'Tanpa Email'}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">URL Slug Undangan</span>
                        <p class="font-bold text-admin-accent">${slugLink}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">Status Undangan</span>
                        ${statusBadge}
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">Paket Terpilih</span>
                        <p class="font-bold text-slate-700">${packageName}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">Tema Terpilih</span>
                        <p class="font-bold text-slate-700">${themeName}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">Terdaftar Pada</span>
                        <p class="font-bold text-slate-700">${new Date(client.created_at).toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'})}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">Masa Aktif Berakhir</span>
                        <p class="font-bold text-slate-700">${trialHabis}</p>
                    </div>
                </div>
                ${inv ? `<div class="mt-6 pt-2"><a href="/${inv.slug}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-admin-accent to-indigo-600 hover:from-admin-accent-dark hover:to-indigo-700 text-white py-3.5 rounded-2xl font-semibold shadow-lg shadow-indigo-500/20 transition-all hover:shadow-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>Buka Halaman Undangan (/${inv.slug})</a></div>` : ''}
            `;
            $('#detail-content').html(html).show();
            $('#detail-loader').hide();
        })
        .fail(function() {
            $('#detail-loader').html('<p class="text-red-500">Gagal memuat data.</p>');
        });
}

function openThemePicker(target) {
    currentPickerTarget = target;
    const currentThemeId = $('#' + target + '-theme-id').val();
    
    $('.theme-card').removeClass('border-admin-accent ring-2 ring-admin-accent/20');
    $('.selected-overlay').removeClass('opacity-100').addClass('opacity-0');
    
    if (currentThemeId) {
        const card = $(`.theme-card[data-id="${currentThemeId}"]`);
        card.addClass('border-admin-accent ring-2 ring-admin-accent/20');
        card.find('.selected-overlay').removeClass('opacity-0').addClass('opacity-100');
    }
    
    $('#theme-picker-modal').css('display', 'flex');
}

function closeThemePicker() {
    $('#theme-picker-modal').css('display', 'none');
}

function selectTheme(id, name, thumbnail, element) {
    $('#' + currentPickerTarget + '-theme-id').val(id);
    $('#' + currentPickerTarget + '-theme-name').text(name).removeClass('text-slate-600').addClass('text-slate-800 font-bold');
    
    let iconHtml = thumbnail 
        ? `<img src="${thumbnail}" class="w-full h-full object-cover">`
        : `<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`;
        
    $('#' + currentPickerTarget + '-theme-icon').html(iconHtml);
    
    closeThemePicker();
}

function filterThemes() {
    const term = $('#search-theme-picker').val().toLowerCase();
    $('.theme-card').each(function() {
        const name = $(this).data('name').toLowerCase();
        if (name.includes(term)) $(this).show();
        else $(this).hide();
    });
}

$('#create-form').on('submit', function(e) {
    e.preventDefault();
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.post("{{ route('admin.clients.store') }}", $(this).serialize())
        .done(function(res) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            closeModal('create-modal');
            window.location.reload();
        })
        .fail(function(xhr) {
            const errors = xhr.responseJSON?.errors;
            let msg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
            if (errors) {
                msg = '<div class="text-left text-sm text-slate-600 mb-2">Silakan periksa input berikut:</div><ul class="text-left list-disc pl-5 space-y-1 text-sm text-red-600">';
                Object.values(errors).flat().forEach(e => {
                    msg += `<li>${e}</li>`;
                });
                msg += '</ul>';
                Swal.fire({ icon: 'error', title: 'Validasi Gagal', html: msg });
            } else {
                Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
            }
        })
        .always(() => btn.prop('disabled', false).text('Buat Akun Klien'));
});

$('#edit-form').on('submit', function(e) {
    e.preventDefault();
    const id = $('#edit-id').val();
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.ajax({
        url: "/admin/clients/" + id,
        type: 'PUT',
        data: $(this).serialize(),
    })
    .done(function(res) {
        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
        closeModal('edit-modal');
        window.location.reload();
    })
    .fail(function(xhr) {
        const errors = xhr.responseJSON?.errors;
        let msg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
        if (errors) {
            msg = '<div class="text-left text-sm text-slate-600 mb-2">Silakan periksa input berikut:</div><ul class="text-left list-disc pl-5 space-y-1 text-sm text-red-600">';
            Object.values(errors).flat().forEach(e => {
                msg += `<li>${e}</li>`;
            });
            msg += '</ul>';
            Swal.fire({ icon: 'error', title: 'Validasi Gagal', html: msg });
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
        }
    })
    .always(() => btn.prop('disabled', false).text('Simpan Perubahan'));
});

function deleteClient(id) {
    Swal.fire({
        title: 'Hapus Klien?',
        text: 'Semua data undangan klien ini akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({ 
                url: "/admin/clients/" + id, 
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') }
            })
                .done(function(res) {
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 1500 });
                    setTimeout(() => window.location.reload(), 1000);
                })
                .fail(function() { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menghapus klien.' }); });
        }
    });
}
</script>
@endpush
