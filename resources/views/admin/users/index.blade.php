@extends('layouts.admin')

@section('title', 'Manajemen Admin')
@section('page-title', 'Manajemen Admin')

@section('content')
<div class="w-full space-y-6">
    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <!-- Search -->
        <div class="relative max-w-sm w-full">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="search-user" placeholder="Cari username / email..." value="{{ request('search') }}" 
                   class="w-full pl-10 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all bg-white">
        </div>
        
        <div class="flex items-center gap-3">
            <button onclick="openCreateModal()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Admin
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden" id="users-table-container">
        <div class="overflow-x-auto" id="table-content-wrapper">
            @include('admin.users.partials.table-content', ['users' => $users])
        </div>
    </div>

<!-- Create User Modal -->
<div id="create-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-xl text-slate-800">Tambah Admin Baru</h3>
            <button onclick="closeModal('create-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="create-form" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="create-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Masukkan username">
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="contoh@email.com">
            </div>

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Password <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="password" name="password" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 pr-10 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Minimal 6 karakter">
                    <button type="button" onclick="const input = this.previousElementSibling; const isPass = input.type === 'password'; input.type = isPass ? 'text' : 'password'; this.innerHTML = isPass ? '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21\'></path></svg>' : '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'></path><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\'></path></svg>'" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-admin-accent focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
                </div>
            </div>
            
            <div class="pt-4 mt-6">
                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-admin-accent border border-transparent rounded-xl font-bold text-sm text-white tracking-wider uppercase hover:bg-admin-accent-dark focus:outline-none focus:ring-2 focus:ring-admin-accent focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    Simpan Admin
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="edit-modal" class="fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-md items-center justify-center p-4 transition-all" style="display:none;">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden transform transition-all">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-xl text-slate-800">Edit Admin</h3>
            <button onclick="closeModal('edit-modal')" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 hover:text-slate-700 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
        </div>
        <form id="edit-form" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-id">

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" id="edit-username" required class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
            </div>
            
            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Email <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <input type="email" name="email" id="edit-email" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all text-slate-700">
            </div>

            <div>
                <label class="block font-bold text-xs tracking-wider text-slate-600 uppercase mb-2">Password Baru <span class="text-slate-400 font-normal normal-case">(opsional)</span></label>
                <div class="relative">
                    <input type="password" name="password" class="block w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 pr-10 text-sm focus:bg-white focus:ring-2 focus:ring-admin-accent/30 focus:border-admin-accent transition-all placeholder-slate-400" placeholder="Biarkan kosong jika tidak ingin ubah">
                    <button type="button" onclick="const input = this.previousElementSibling; const isPass = input.type === 'password'; input.type = isPass ? 'text' : 'password'; this.innerHTML = isPass ? '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21\'></path></svg>' : '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'></path><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\'></path></svg>'" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-admin-accent focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </button>
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

</div>
@endsection

@push('scripts')
<script>
    let searchTimer;

    function fetchUsers(url) {
        $.ajax({
            url: url,
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                $('#table-content-wrapper').html(res.html);
            }
        });
    }

    $('#search-user').on('keyup', function() {
        clearTimeout(searchTimer);
        let val = $(this).val();
        searchTimer = setTimeout(function() {
            fetchUsers(`{{ route('admin.users.index') }}?search=${val}`);
        }, 500);
    });

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        fetchUsers($(this).attr('href'));
    });

    function openCreateModal() {
        $('#create-form')[0].reset();
        $('#create-modal').css('display', 'flex').hide().fadeIn(200);
    }

    function closeModal(id) {
        $('#' + id).fadeOut(200);
    }

    function openEditModal(id) {
        $.get(`/admin/users/${id}`, function(res) {
            $('#edit-id').val(res.id);
            $('#edit-username').val(res.username);
            $('#edit-email').val(res.email);
            
            $('#edit-modal').css('display', 'flex').hide().fadeIn(200);
        });
    }

    $('#create-form').submit(function(e) {
        e.preventDefault();
        let btn = $(this).find('button[type=submit]');
        let originalText = btn.html();
        btn.html('<svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...').prop('disabled', true);
        
        $.ajax({
            url: `{{ route('admin.users.store') }}`,
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if(res.success) {
                    Swal.fire({icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false});
                    closeModal('create-modal');
                    fetchUsers(window.location.href);
                }
            },
            error: function(err) {
                let msg = err.responseJSON.message || 'Terjadi kesalahan';
                Swal.fire({icon: 'error', title: 'Oops...', text: msg});
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    $('#edit-form').submit(function(e) {
        e.preventDefault();
        let id = $('#edit-id').val();
        let btn = $(this).find('button[type=submit]');
        let originalText = btn.html();
        btn.html('<svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...').prop('disabled', true);
        
        $.ajax({
            url: `/admin/users/${id}`,
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if(res.success) {
                    Swal.fire({icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false});
                    closeModal('edit-modal');
                    fetchUsers(window.location.href);
                }
            },
            error: function(err) {
                let msg = err.responseJSON.message || 'Terjadi kesalahan';
                Swal.fire({icon: 'error', title: 'Oops...', text: msg});
            },
            complete: function() {
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    function deleteUser(id) {
        Swal.fire({
            title: 'Hapus Admin?',
            text: "Data admin akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/admin/users/${id}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res) {
                        if(res.success) {
                            Swal.fire({icon: 'success', title: 'Terhapus!', text: res.message, timer: 1500, showConfirmButton: false});
                            fetchUsers(window.location.href);
                        }
                    },
                    error: function(err) {
                        let msg = err.responseJSON.message || 'Terjadi kesalahan saat menghapus.';
                        Swal.fire({icon: 'error', title: 'Gagal', text: msg});
                    }
                });
            }
        });
    }
</script>
@endpush
