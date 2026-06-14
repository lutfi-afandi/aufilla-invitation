@extends('layouts.admin')

@section('title', 'Manajemen Klien')
@section('page-title', 'Manajemen Klien')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- Search -->
        <div class="relative max-w-sm w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="search-client" placeholder="Cari username / email..." value="{{ request('search') }}" 
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all bg-white">
        </div>
        <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Klien
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" id="clients-table-container">
        <div class="overflow-x-auto" id="table-content-wrapper">
            @include('admin.clients.partials.table-content', ['clients' => $clients])
        </div>
    </div>

<!-- Create Client Modal -->
<div id="create-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-xl text-slate-800">Tambah Klien Baru</h3>
            <button onclick="closeModal('create-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="create-form" class="p-6 space-y-5">
            @csrf
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Tema Undangan <span class="text-red-500">*</span></label>
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

            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Username / Link Undangan <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="create-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Masukkan username klien">
                <div id="create-url-preview-container" class="mt-3 hidden transition-all duration-300">
                    <div class="flex flex-col gap-1.5 p-3.5 bg-slate-50 border border-slate-200 rounded-lg shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
                        <div class="flex items-center gap-2 text-[12px] font-medium">
                            <div class="w-5 h-5 rounded-full bg-admin-accent/10 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <span class="text-slate-500">Akses URL:</span>
                            <span class="text-slate-800 font-bold truncate">{{ request()->getSchemeAndHttpHost() }}/<span id="create-username-value" class="text-admin-accent underline decoration-admin-accent/30 underline-offset-2"></span></span>
                        </div>
                        <div id="create-username-feedback" class="text-[12px] font-medium pl-7"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="contoh@email.com">
            </div>

            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Paket Undangan <span class="text-red-500">*</span></label>
                <select name="package_id" id="create-package" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Minimal 6 karakter">
            </div>
            
            <div class="pt-4 mt-6">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent-dark focus:outline-none focus:ring-2 focus:ring-admin-accent focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    Buat Akun Klien
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Client Modal -->
<div id="edit-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-xl text-slate-800">Edit Klien</h3>
            <button onclick="closeModal('edit-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="edit-form" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id">
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Tema Undangan <span class="text-red-500">*</span></label>
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

            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Username / Link Undangan <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="edit-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700" placeholder="Username klien">
                <div id="edit-url-preview-container" class="mt-3 hidden transition-all duration-300">
                    <div class="flex flex-col gap-1.5 p-3.5 bg-slate-50 border border-slate-200 rounded-lg shadow-[inset_0_1px_2px_rgba(0,0,0,0.02)]">
                        <div class="flex items-center gap-2 text-[12px] font-medium">
                            <div class="w-5 h-5 rounded-full bg-admin-accent/10 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </div>
                            <span class="text-slate-500">Akses URL:</span>
                            <span class="text-slate-800 font-bold truncate">{{ request()->getSchemeAndHttpHost() }}/<span id="edit-username-value" class="text-admin-accent underline decoration-admin-accent/30 underline-offset-2"></span></span>
                        </div>
                        <div id="edit-username-feedback" class="text-[12px] font-medium pl-7"></div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" id="edit-email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700" placeholder="contoh@email.com">
            </div>

            <div class="mt-4">
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Paket Undangan <span class="text-red-500">*</span></label>
                <select name="package_id" id="edit-package" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                    <option value="">-- Pilih Paket --</option>
                    @foreach($packages as $pkg)
                        <option value="{{ $pkg->id }}">{{ $pkg->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" id="edit-status" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
                        <option value="trial">Trial</option>
                        <option value="active">Aktif</option>
                        <option value="expired">Nonaktif/Expired</option>
                    </select>
                </div>
                <div>
                    <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Password Baru <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                    <input type="password" name="password" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Biarkan kosong">
                </div>
            </div>
            
            <div class="pt-4 mt-6">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent-dark focus:outline-none focus:ring-2 focus:ring-admin-accent focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<!-- Detail Client Modal -->
<div id="detail-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
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
<div id="theme-picker-modal" class="fixed inset-0 z-[60] bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
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

// Fetch clients via AJAX
function fetchClients(page_url) {
    const search = $('#search-client').val();
    const url = page_url || "{{ route('admin.clients.index') }}";
    
    $('#table-content-wrapper').css('opacity', '0.5');

    $.ajax({
        url: url,
        data: { search: search },
        success: function(res) {
            $('#table-content-wrapper').html(res.html).css('opacity', '1');
            
            // Push state so URL matches
            if (history.pushState) {
                const newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(search);
                window.history.pushState({path:newurl}, '', newurl);
            }
        }
    });
}

// Live Search
let searchTimeout;
$('#search-client').on('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        fetchClients();
    }, 400);
});

// Pagination Clicks
$(document).on('click', '.pagination-container a', function(e) {
    e.preventDefault();
    fetchClients($(this).attr('href'));
});

let currentPickerTarget = 'create'; // 'create' or 'edit'

function openCreateModal() { 
    $('#create-form')[0].reset();
    $('#create-theme-id').val('');
    $('#create-theme-name').text('Belum memilih tema').removeClass('text-slate-800').addClass('text-slate-600');
    $('#create-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
    $('#create-url-preview-container').addClass('hidden');
    $('#create-form').find('button[type=submit]').prop('disabled', false);
    $('#create-modal').css('display', 'flex'); 
}

function closeModal(id) { $('#' + id).css('display', 'none'); }

function openEditModal(client) {
    $('#edit-form')[0].reset();
    $('#edit-id').val(client.id);
    $('#edit-username').val(client.username);
    $('#edit-email').val(client.email);
    
    if (client.invitation) {
        $('#edit-status').val(client.invitation.status);
        $('#edit-package').val(client.invitation.package_id || '');
        if (client.invitation.theme) {
            $('#edit-theme-id').val(client.invitation.theme_id);
            $('#edit-theme-name').text(client.invitation.theme.name).removeClass('text-slate-600').addClass('text-slate-800 font-bold');
            if (client.invitation.theme.thumbnail) {
                $('#edit-theme-icon').html(`<img src="/storage/${client.invitation.theme.thumbnail}" class="w-full h-full object-cover">`);
            } else {
                $('#edit-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
            }
        } else {
            $('#edit-theme-id').val('');
            $('#edit-theme-name').text('Belum memilih tema').removeClass('text-slate-800 font-bold').addClass('text-slate-600');
            $('#edit-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
        }
    } else {
        $('#edit-status').val('trial');
        $('#edit-package').val('');
        $('#edit-theme-id').val('');
        $('#edit-theme-name').text('Belum memilih tema').removeClass('text-slate-800 font-bold').addClass('text-slate-600');
        $('#edit-theme-icon').html(`<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`);
    }
    
    // Trigger preview for edit
    $('#edit-username').trigger('keyup');
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
            const inv = res.invitation;
            
            let statusBadge = '<span class="text-xs bg-slate-100 text-slate-500 px-2 py-1 rounded">Belum ada</span>';
            let themeName = '-';
            let packageName = '-';
            let trialHabis = '-';
            
            if (inv) {
                const s = inv.status;
                const colors = { active: 'bg-emerald-100 text-emerald-700', trial: 'bg-amber-100 text-amber-700', expired: 'bg-red-100 text-red-600' };
                statusBadge = `<span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full ${colors[s] || 'bg-slate-100 text-slate-500'}">${s}</span>`;
                
                if (inv.theme) themeName = inv.theme.name;
                if (inv.package) packageName = inv.package.name;
                
                if (s === 'trial' && inv.trial_habis_at) {
                    trialHabis = new Date(inv.trial_habis_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute:'2-digit'});
                } else if (s === 'active' && inv.package) {
                    if (inv.package.active_days > 10000) {
                        trialHabis = '<span class="text-emerald-600 font-semibold">Aktif Permanen</span>';
                    } else {
                        const expDate = new Date(client.created_at);
                        expDate.setDate(expDate.getDate() + inv.package.active_days);
                        trialHabis = expDate.toLocaleDateString('id-ID', {day: '2-digit', month: 'short', year: 'numeric'});
                    }
                } else if (s === 'active') {
                    // Fallback jika tidak ada paket
                    trialHabis = '<span class="text-emerald-600 font-semibold">Aktif</span>';
                } else if (s === 'expired') {
                    trialHabis = '<span class="text-red-600 font-semibold">Kadaluarsa</span>';
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
                    <div class="col-span-2 bg-slate-50 rounded-2xl p-4 border border-slate-100/60">
                        <span class="block text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1.5">Batas Masa Aktif / Trial</span>
                        <p class="font-bold text-slate-700">${trialHabis}</p>
                    </div>
                </div>
                ${inv ? `<div class="mt-6 pt-2"><a href="/${inv.slug}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-admin-accent to-indigo-600 hover:from-admin-accent-dark hover:to-indigo-700 text-white py-3.5 rounded-2xl font-semibold shadow-lg shadow-indigo-500/20 transition-all hover:shadow-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>Buka Halaman Undangan</a></div>` : ''}
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
    
    // Highlight selected theme
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

// URL Preview Logic
let checkTimeout;

function bindUsernameCheck(inputId, containerId, valueId, feedbackId, formId, excludeIdInputId = null) {
    const input = document.getElementById(inputId);
    if (!input) return;

    input.addEventListener('keyup', function() {
        let val = this.value.toLowerCase().replace(/[^a-z0-9-]+/g, '-');
        if (this.value !== val) {
            this.value = val;
        }

        const previewContainer = document.getElementById(containerId);
        const previewValue = document.getElementById(valueId);
        const feedback = document.getElementById(feedbackId);
        const submitBtn = document.getElementById(formId).querySelector('button[type=submit]');
        const excludeId = excludeIdInputId ? document.getElementById(excludeIdInputId).value : '';

        if (val.length > 0) {
            previewValue.textContent = val;
            previewContainer.classList.remove('hidden');
        } else {
            previewContainer.classList.add('hidden');
        }

        clearTimeout(checkTimeout);
        checkTimeout = setTimeout(() => {
            if (val.length > 0) {
                checkAdminUsername(val, feedback, submitBtn, excludeId);
            } else {
                feedback.innerHTML = '';
                if (submitBtn) submitBtn.disabled = true;
            }
        }, 500);
    });
}

function checkAdminUsername(username, feedbackEl, submitBtn, excludeId = '') {
    if (username.length < 3) {
        feedbackEl.className = 'text-[12px] font-medium text-amber-600 pl-7';
        feedbackEl.innerHTML = 'URL terlalu pendek (minimal 3 karakter)';
        if (submitBtn) submitBtn.disabled = true;
        return;
    }

    feedbackEl.className = 'text-[12px] font-medium text-slate-500 pl-7';
    feedbackEl.innerHTML = 'Mengecek ketersediaan...';

    let apiUrl = `/api/check-username?username=${encodeURIComponent(username)}`;
    if (excludeId) apiUrl += `&exclude_id=${excludeId}`;

    fetch(apiUrl)
        .then(res => res.json())
        .then(data => {
            if (data.available) {
                feedbackEl.className = 'text-[12px] font-medium text-emerald-600 pl-7';
                feedbackEl.innerHTML = `<svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> ${data.message}`;
                if (submitBtn) submitBtn.disabled = false;
            } else {
                feedbackEl.className = 'text-[12px] font-medium text-red-500 pl-7';
                feedbackEl.innerHTML = `<svg class="inline w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> ${data.message}`;
                if (submitBtn) submitBtn.disabled = true;
            }
        })
        .catch(err => {
            feedbackEl.className = 'text-[12px] font-medium text-slate-500 pl-7';
            feedbackEl.innerHTML = 'Gagal mengecek URL.';
        });
}

$(document).ready(function() {
    bindUsernameCheck('create-username', 'create-url-preview-container', 'create-username-value', 'create-username-feedback', 'create-form');
    bindUsernameCheck('edit-username', 'edit-url-preview-container', 'edit-username-value', 'edit-username-feedback', 'edit-form', 'edit-id');
});

$('#create-form').on('submit', function(e) {
    e.preventDefault();
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.post("{{ route('admin.clients.store') }}", $(this).serialize())
        .done(function(res) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            closeModal('create-modal');
            
            // Remove empty state if it exists
            const tbody = $('#clients-table-container tbody');
            if(tbody.find('tr').length === 1 && tbody.find('tr td').attr('colspan') === '7') {
                tbody.empty();
            }
            
            // Inject new row at the top
            if(res.html) {
                tbody.prepend(res.html);
            }
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
        .always(() => btn.prop('disabled', false).text('Buat Klien'));
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
        
        // Replace existing row
        if(res.html && id) {
            $('#client-row-' + id).replaceWith(res.html);
        }
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
                    $('#client-row-' + id).fadeOut(400, function() { $(this).remove(); });
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
                })
                .fail(function() { Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menghapus klien.' }); });
        }
    });
}
</script>
@endpush
