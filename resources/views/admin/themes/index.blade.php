@extends('layouts.admin')

@section('title', 'Manajemen Tema')
@section('page-title', 'Manajemen Tema')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 mb-3">Kelola tema undangan yang tersedia untuk klien.</p>
            <!-- Search -->
            <div class="relative max-w-sm w-full">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" id="search-theme" placeholder="Cari nama / kode tema..." 
                       class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all bg-white">
            </div>
        </div>
        <button onclick="openCreateTheme()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all sm:self-end">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Tema
        </button>
    </div>

    <!-- Theme Grid Container -->
    <div class="relative min-h-[300px]">
        <div id="themes-grid-container">
            @include('admin.themes.partials.grid')
        </div>
        <!-- Loader Overlay -->
        <div id="grid-loader" class="absolute inset-0 z-10 bg-white/50 backdrop-blur-sm flex flex-col items-center justify-center rounded-2xl hidden">
            <svg class="animate-spin h-8 w-8 text-admin-accent mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-sm font-semibold text-slate-600">Memuat data...</p>
        </div>
    </div>


</div>

<!-- Create Theme Modal -->
<div id="create-theme-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-admin-dark p-5 text-white flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah Tema Baru</h3>
            <button onclick="$('#create-theme-modal').hide()" class="text-white/60 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="create-theme-form" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Tema</label>
                <input type="text" name="name" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent" placeholder="Aufilla Green">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kode Tema <span class="text-slate-400 font-normal">(slug folder)</span></label>
                <input type="text" name="code" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent font-mono" placeholder="aufilla-green">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Thumbnail</label>
                <input type="file" name="thumbnail" id="create-thumbnail-input" accept="image/*" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-admin-accent-dark hover:file:bg-indigo-100">
                <div id="create-preview-container" class="mt-3 hidden rounded-xl overflow-hidden border border-slate-200 h-32 bg-slate-50 relative">
                    <img id="create-thumbnail-preview" src="" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>
            <button type="submit" class="w-full bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold py-2.5 rounded-xl transition-all">Tambah Tema</button>
        </form>
    </div>
</div>

<!-- Edit Theme Modal -->
<div id="edit-theme-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-admin-dark p-5 text-white flex justify-between items-center">
            <h3 class="font-bold text-lg">Edit Tema</h3>
            <button onclick="$('#edit-theme-modal').hide()" class="text-white/60 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="edit-theme-form" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <input type="hidden" id="edit-theme-id">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Tema</label>
                <input type="text" name="name" id="edit-theme-name" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent bg-white">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Tema</label>
                <select name="is_active" id="edit-theme-status" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent bg-white">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Thumbnail Baru <span class="text-slate-400 font-normal">(opsional)</span></label>
                <input type="file" name="thumbnail" id="edit-thumbnail-input" accept="image/*" class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-admin-accent-dark hover:file:bg-indigo-100">
                <div id="edit-preview-container" class="mt-3 hidden rounded-xl overflow-hidden border border-slate-200 h-32 bg-slate-50 relative">
                    <img id="edit-thumbnail-preview" src="" alt="Preview" class="w-full h-full object-cover">
                </div>
            </div>
            <button type="submit" class="w-full bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold py-2.5 rounded-xl transition-all">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function openCreateTheme() { 
    $('#create-preview-container').hide();
    $('#create-thumbnail-input').val('');
    $('#create-theme-modal').css('display', 'flex'); 
}
function openEditTheme(theme) {
    $('#edit-theme-id').val(theme.id);
    $('#edit-theme-name').val(theme.name);
    $('#edit-theme-status').val(theme.is_active ? '1' : '0');
    $('#edit-thumbnail-input').val('');
    
    if (theme.thumbnail) {
        $('#edit-thumbnail-preview').attr('src', '/storage/' + theme.thumbnail);
        $('#edit-preview-container').show();
    } else {
        $('#edit-thumbnail-preview').attr('src', '/assets/img/thumbnail-tema/demo1.png');
        $('#edit-preview-container').show();
    }
    
    $('#edit-theme-modal').css('display', 'flex');
}

// Image Preview Logic
function handleImagePreview(input, previewContainer, previewImage) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $(previewImage).attr('src', e.target.result);
            $(previewContainer).show();
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('#create-thumbnail-input').change(function() {
    handleImagePreview(this, '#create-preview-container', '#create-thumbnail-preview');
});

$('#edit-thumbnail-input').change(function() {
    handleImagePreview(this, '#edit-preview-container', '#edit-thumbnail-preview');
});

// AJAX Loading function
function fetchThemes(url) {
    $('#themes-grid-container').addClass('opacity-50 pointer-events-none');
    $('#grid-loader').removeClass('hidden').addClass('flex');
    $.ajax({
        url: url,
        type: 'GET'
    }).done(function(data) {
        $('#themes-grid-container').html(data);
        $('#themes-grid-container').removeClass('opacity-50 pointer-events-none');
        $('#grid-loader').removeClass('flex').addClass('hidden');
    }).fail(function() {
        Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memuat tema.' });
        $('#themes-grid-container').removeClass('opacity-50 pointer-events-none');
        $('#grid-loader').removeClass('flex').addClass('hidden');
    });
}

// Live Search with Debounce
let searchTimeout;
$('#search-theme').on('input', function() {
    clearTimeout(searchTimeout);
    let query = $(this).val();
    searchTimeout = setTimeout(function() {
        fetchThemes("{{ route('admin.themes.index') }}?search=" + encodeURIComponent(query));
    }, 500); // 500ms debounce
});

// AJAX Pagination (intercept click on Laravel pagination links)
$(document).on('click', '#themes-grid-container nav[role="navigation"] a', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');
    let query = $('#search-theme').val();
    if (query) {
        url += (url.indexOf('?') > -1 ? '&' : '?') + "search=" + encodeURIComponent(query);
    }
    fetchThemes(url);
});

$('#create-theme-form').on('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.ajax({ url: "{{ route('admin.themes.store') }}", type: 'POST', data: fd, processData: false, contentType: false })
        .done(function(res) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            $('#create-theme-modal').hide();
            $('#create-theme-form')[0].reset();
            fetchThemes("{{ route('admin.themes.index') }}"); // Reload grid seamlessly
        })
        .fail(function(xhr) {
            const errors = xhr.responseJSON?.errors;
            let msg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
            if (errors) msg = Object.values(errors).flat().join('\n');
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
        })
        .always(() => btn.prop('disabled', false).text('Tambah Tema'));
});

$('#edit-theme-form').on('submit', function(e) {
    e.preventDefault();
    const id = $('#edit-theme-id').val();
    const fd = new FormData(this);
    fd.append('_method', 'PUT');
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.ajax({ url: "/admin/themes/" + id, type: 'POST', data: fd, processData: false, contentType: false })
        .done(function(res) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            $('#edit-theme-modal').hide();
            $('#edit-theme-form')[0].reset();
            let query = $('#search-theme').val();
            fetchThemes("{{ route('admin.themes.index') }}?search=" + encodeURIComponent(query));
        })
        .fail(function(xhr) { Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' }); })
        .always(() => btn.prop('disabled', false).text('Simpan'));
});

function toggleTheme(id) {
    $.ajax({ 
        url: "/admin/themes/" + id + "/toggle", 
        type: 'PATCH',
        data: { _token: $('meta[name="csrf-token"]').attr('content') }
    })
        .done(function(res) {
            // Kita bisa juga mereplace full grid via fetchThemes, atau update DOM langsung:
            const badge = $('#theme-badge-' + id);
            if (res.is_active) {
                badge.text('Aktif').removeClass('bg-red-100 text-red-600 hover:bg-red-200').addClass('bg-emerald-100 text-emerald-700 hover:bg-emerald-200');
            } else {
                badge.text('Nonaktif').removeClass('bg-emerald-100 text-emerald-700 hover:bg-emerald-200').addClass('bg-red-100 text-red-600 hover:bg-red-200');
            }
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
        })
        .fail(function(xhr) {
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: 'Gagal mengubah status', showConfirmButton: false, timer: 2000 });
        });
}

function deleteTheme(id) {
    Swal.fire({
        title: 'Hapus Tema?',
        text: 'Aksi ini tidak dapat dibatalkan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({ 
                url: "/admin/themes/" + id, 
                type: 'DELETE',
                data: { _token: $('meta[name="csrf-token"]').attr('content') }
            })
                .done(function(res) {
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
                    let query = $('#search-theme').val();
                    fetchThemes("{{ route('admin.themes.index') }}?search=" + encodeURIComponent(query));
                })
                .fail(function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' });
                });
        }
    });
}
</script>
@endpush
