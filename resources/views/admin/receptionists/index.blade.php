@extends('layouts.admin')

@section('title', 'Manajemen Resepsionis')
@section('page-title', 'Manajemen Resepsionis')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="relative max-w-sm w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="search-receptionist" placeholder="Cari username / email..." value="{{ request('search') }}" 
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all bg-white">
        </div>
        <button onclick="openCreateReceptionist()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Resepsionis
        </button>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" id="receptionists-table-container">
        <div class="overflow-x-auto" id="table-content-wrapper">
            @include('admin.receptionists.partials.table-content', ['receptionists' => $receptionists])
        </div>
    </div>
</div>

<!-- Create Receptionist Modal -->
<div id="create-r-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-admin-dark p-5 text-white flex justify-between items-center">
            <h3 class="font-bold text-lg">Tambah Resepsionis</h3>
            <button onclick="$('#create-r-modal').hide()" class="text-white/60 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="create-r-form" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
                <input type="text" name="username" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
                <input type="password" name="password" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
            </div>
            <button type="submit" class="w-full bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold py-2.5 rounded-xl transition-all">Buat Resepsionis</button>
        </form>
    </div>
</div>

<!-- Edit Receptionist Modal -->
<div id="edit-r-modal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm items-center justify-center p-4" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-admin-dark p-5 text-white flex justify-between items-center">
            <h3 class="font-bold text-lg">Edit Resepsionis</h3>
            <button onclick="$('#edit-r-modal').hide()" class="text-white/60 hover:text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="edit-r-form" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-r-id">
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
                <input type="text" name="username" id="edit-r-username" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" id="edit-r-email" required class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
            </div>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5">Password Baru <span class="text-slate-400 font-normal">(opsional)</span></label>
                <input type="password" name="password" class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent">
            </div>
            <button type="submit" class="w-full bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold py-2.5 rounded-xl transition-all">Simpan</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function openCreateReceptionist() { $('#create-r-modal').css('display', 'flex'); }
function openEditReceptionist(r) {
    $('#edit-r-id').val(r.id);
    $('#edit-r-username').val(r.username);
    $('#edit-r-email').val(r.email);
    $('#edit-r-modal').css('display', 'flex');
}

$('#create-r-form').on('submit', function(e) {
    e.preventDefault();
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.post("{{ route('admin.receptionists.store') }}", $(this).serialize())
        .done(function(res) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            $('#create-r-modal').hide();
            $('#create-r-form')[0].reset();
            
            const tbody = $('#table-content-wrapper tbody');
            if(tbody.find('tr').length === 1 && tbody.find('tr td').attr('colspan') === '4') {
                tbody.empty();
            }
            if(res.html) tbody.prepend(res.html);
        })
        .fail(function(xhr) {
            const errors = xhr.responseJSON?.errors;
            let msg = xhr.responseJSON?.message || 'Terjadi kesalahan.';
            if (errors) msg = Object.values(errors).flat().join('\n');
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
        })
        .always(() => btn.prop('disabled', false).text('Buat Resepsionis'));
});

$('#edit-r-form').on('submit', function(e) {
    e.preventDefault();
    const id = $('#edit-r-id').val();
    const btn = $(this).find('button[type=submit]');
    btn.prop('disabled', true).text('Memproses...');
    $.ajax({ url: "/admin/receptionists/" + id, type: 'PUT', data: $(this).serialize() })
        .done(function(res) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 1500, showConfirmButton: false });
            $('#edit-r-modal').hide();
            
            if(res.html && id) {
                $('#receptionist-row-' + id).replaceWith(res.html);
            }
        })
        .fail(function(xhr) { Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' }); })
        .always(() => btn.prop('disabled', false).text('Simpan'));
});

// Fetch receptionists via AJAX
function fetchReceptionists(page_url) {
    const search = $('#search-receptionist').val();
    const url = page_url || "{{ route('admin.receptionists.index') }}";
    
    $('#table-content-wrapper').css('opacity', '0.5');

    $.ajax({
        url: url,
        data: { search: search },
        success: function(res) {
            $('#table-content-wrapper').html(res.html).css('opacity', '1');
            
            if (history.pushState) {
                const newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=' + encodeURIComponent(search);
                window.history.pushState({path:newurl}, '', newurl);
            }
        }
    });
}

// Live Search
let searchTimeout;
$('#search-receptionist').on('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        fetchReceptionists();
    }, 600);
});

// Auto-focus search input
$(document).ready(function() {
    const searchInput = $('#search-receptionist');
    if (searchInput.val()) {
        const len = searchInput.val().length;
        searchInput.focus();
        searchInput[0].setSelectionRange(len, len);
    }
});

// Pagination Clicks
$(document).on('click', '.pagination-container a', function(e) {
    e.preventDefault();
    fetchReceptionists($(this).attr('href'));
});

function deleteReceptionist(id) {
    Swal.fire({
        title: 'Hapus Resepsionis?',
        text: 'Akun ini akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({ 
                url: "/admin/receptionists/" + id, 
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            })
                .done(function(res) {
                    $('#receptionist-row-' + id).fadeOut(400, function() { $(this).remove(); });
                    Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 2000 });
                });
        }
    });
}
</script>
@endpush
