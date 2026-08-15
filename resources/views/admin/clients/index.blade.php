@extends('layouts.admin')

@section('title', 'Manajemen Klien')
@section('page-title', 'Manajemen Klien')

@section('content')
    <div class="max-w-7xl mx-auto w-full space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Daftar Klien Undangan</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola akun pengguna, paket, status aktif, dan tema undangan.</p>
            </div>
            <button type="button" onclick="openCreateModal()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-admin-accent-dark hover:bg-admin-accent text-white font-semibold text-sm rounded-xl shadow-sm hover:shadow-md transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                    </path>
                </svg>
                Tambah Klien
            </button>
        </div>

        <!-- Table Container -->
        <div class="w-full" id="clients-table-container">
            <table id="clients-table" class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Username
                        </th>
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Link Slug
                        </th>
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Paket</th>
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Tema</th>
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Status
                        </th>
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Terdaftar
                        </th>
                        <th class="text-left px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Expired
                        </th>
                        <th class="text-center px-5 py-4 font-bold text-xs uppercase tracking-wider text-slate-500">Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($clients as $client)
                        @include('admin.clients.partials.row', ['client' => $client])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modals Partial -->
    @include('admin.clients.partials.modals')
@endsection

@push('scripts')
    <script>
        let clientsTable;
        let currentPickerTarget = 'create';

        $(document).ready(function() {
            clientsTable = $('#clients-table').DataTable({
                dom: "<'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4'l f>" +
                    "<'bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-x-auto w-full't>" +
                    "<'flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4 px-2'i p>",
                autoWidth: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari username, slug, email, paket...",
                    lengthMenu: "_MENU_ data",
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
                order: [
                    [5, 'desc']
                ],
                columnDefs: [{
                    orderable: false,
                    targets: 7
                }]
            });

            // Auto-fill slug from username on create
            $('#create-username').on('input', function() {
                let val = $(this).val().toLowerCase().replace(/[^a-z0-9-_]/g, '-').replace(/-+/g, '-');
                $('#create-slug').val(val);
            });
        });

        function openCreateModal() {
            $('#create-form')[0].reset();
            $('#create-theme-id').val('');
            $('#create-theme-name').text('Belum memilih tema').removeClass('text-slate-800').addClass('text-slate-600');
            $('#create-theme-icon').html(
                `<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`
            );
            $('#create-submit-btn').prop('disabled', false).text('Buat Akun Klien');
            $('#create-modal').css('display', 'flex');
        }

        function closeModal(id) {
            $('#' + id).css('display', 'none');
        }

        function openEditModal(id) {
            Swal.fire({
                title: 'Memuat data...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            $.get('/admin/clients/' + id)
                .done(function(res) {
                    Swal.close();
                    const client = res.client;
                    const und = res.undangan;
                    $('#edit-form')[0].reset();
                    $('#edit-id').val(client.id);
                    $('#edit-username').val(client.username);
                    $('#edit-email').val(client.email || '');

                    if (und) {
                        $('#edit-slug').val(und.slug);
                        $('#edit-status').val(und.status);
                        $('#edit-package').val(und.paket_id || '');
                        if (und.tema) {
                            $('#edit-theme-id').val(und.tema_id);
                            $('#edit-theme-name').text(und.tema.name).removeClass('text-slate-600').addClass(
                                'text-slate-800 font-bold');
                            if (und.tema.thumbnail) {
                                $('#edit-theme-icon').html(
                                    `<img src="/storage/${und.tema.thumbnail}" class="w-full h-full object-cover">`);
                            }
                        }
                    }
                    $('#edit-modal').css('display', 'flex');
                })
                .fail(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Tidak dapat memuat data klien.'
                    });
                });
        }

        function openDetailModal(id) {
            $('#detail-content').hide();
            $('#detail-loader').show();
            $('#detail-modal').css('display', 'flex');

            $.get('/admin/clients/' + id)
                .done(function(res) {
                    $('#detail-content').html(res.html).show();
                    $('#detail-loader').hide();
                })
                .fail(function() {
                    $('#detail-loader').html(
                        '<p class="text-red-500 text-sm font-semibold">Gagal memuat detail klien.</p>');
                });
        }

        function openThemePicker(target) {
            currentPickerTarget = target;
            const currentThemeId = $('#' + target + '-theme-id').val();
            $('.theme-card').removeClass('border-admin-accent ring-2 ring-admin-accent/20');
            if (currentThemeId) {
                const card = $(`.theme-card[data-id="${currentThemeId}"]`);
                card.addClass('border-admin-accent ring-2 ring-admin-accent/20');
            }
            $('#theme-picker-modal').css('display', 'flex');
        }

        function closeThemePicker() {
            $('#theme-picker-modal').css('display', 'none');
        }

        function selectTheme(id, name, thumbnail, element) {
            $('#' + currentPickerTarget + '-theme-id').val(id);
            $('#' + currentPickerTarget + '-theme-name').text(name).removeClass('text-slate-600').addClass(
                'text-slate-800 font-bold');
            let iconHtml = thumbnail ?
                `<img src="${thumbnail}" class="w-full h-full object-cover">` :
                `<svg class="w-6 h-6 text-slate-400 group-hover:text-admin-accent transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>`;
            $('#' + currentPickerTarget + '-theme-icon').html(iconHtml);
            closeThemePicker();
        }

        function filterThemes() {
            const term = $('#search-theme-picker').val().toLowerCase();
            $('.theme-card').each(function() {
                const name = $(this).data('name').toLowerCase();
                $(this).toggle(name.includes(term));
            });
        }

        // Create Client Form Submit
        $('#create-form').on('submit', function(e) {
            e.preventDefault();
            const btn = $('#create-submit-btn');
            btn.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                    url: "{{ route('admin.clients.store') }}",
                    type: 'POST',
                    data: $(this).serialize()
                })
                .done(function(res) {
                    closeModal('create-modal');
                    Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        })
                        .then(() => window.location.reload());
                })
                .fail(handleAjaxError)
                .always(() => btn.prop('disabled', false).text('Buat Akun Klien'));
        });

        // Edit Client Form Submit
        $('#edit-form').on('submit', function(e) {
            e.preventDefault();
            const id = $('#edit-id').val();
            const btn = $('#edit-submit-btn');
            btn.prop('disabled', true).text('Menyimpan...');

            $.ajax({
                    url: "/admin/clients/" + id,
                    type: 'POST',
                    data: $(this).serialize()
                })
                .done(function(res) {
                    closeModal('edit-modal');
                    Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        })
                        .then(() => window.location.reload());
                })
                .fail(handleAjaxError)
                .always(() => btn.prop('disabled', false).text('Simpan Perubahan'));
        });

        // Delete Client
        function deleteClient(id, username) {
            Swal.fire({
                title: 'Hapus Klien?',
                html: `Apakah Anda yakin menghapus akun <b>${username || ''}</b>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                            url: "/admin/clients/" + id,
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                        .done(function(res) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                })
                                .then(() => window.location.reload());
                        })
                        .fail(handleAjaxError);
                }
            });
        }

        // Standard Error Handler
        function handleAjaxError(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON?.errors;
                let html = '<ul class="text-left list-disc pl-5 text-sm text-red-600 space-y-1">';
                if (errors) {
                    Object.values(errors).flat().forEach(err => {
                        html += `<li>${err}</li>`;
                    });
                } else {
                    html += `<li>${xhr.responseJSON?.message || 'Validasi gagal.'}</li>`;
                }
                html += '</ul>';
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: html
                });
            } else if (xhr.status === 419) {
                Swal.fire({
                        icon: 'warning',
                        title: 'Sesi Berakhir',
                        text: 'Silakan muat ulang halaman.'
                    })
                    .then(() => window.location.reload());
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan pada server.'
                });
            }
        }
    </script>
@endpush
