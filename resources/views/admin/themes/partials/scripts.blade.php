<script>
    let searchTimeout = null;

    // Modal Control Functions
    function openCreateTheme() {
        $('#create-theme-form')[0].reset();
        $('#create-preview-container').addClass('hidden');
        $('#create-thumbnail-preview').attr('src', '');
        hideCreateErrors();
        $('#create-theme-modal').removeClass('hidden').css('display', 'flex');
    }

    function closeCreateModal() {
        $('#create-theme-modal').addClass('hidden').css('display', 'none');
        $('#create-theme-form')[0].reset();
        hideCreateErrors();
    }

    function openEditTheme(theme) {
        $('#edit-modal-title').text('Edit Tema: ' + theme.name);
        $('#edit-theme-id').val(theme.id);
        $('#edit-theme-name').val(theme.name);
        $('#edit-theme-category').val(theme.category || 'minimalis');
        $('#edit-theme-tingkatan').val(theme.tingkatan || 'standar');
        $('#edit-theme-harga-tambahan').val(theme.harga_tambahan || 0);
        $('#edit-theme-is-privat').val(theme.is_privat ? '1' : '0');
        $('#edit-theme-status').val(theme.is_active ? '1' : '0');

        if (theme.thumbnail) {
            $('#edit-thumbnail-preview').attr('src', '/storage/' + theme.thumbnail);
            $('#edit-preview-container').removeClass('hidden');
        } else {
            $('#edit-thumbnail-preview').attr('src', '/assets/img/thumbnail-tema/demo1.png');
            $('#edit-preview-container').removeClass('hidden');
        }

        hideEditErrors();
        $('#edit-theme-modal').removeClass('hidden').css('display', 'flex');
    }

    function closeEditModal() {
        $('#edit-theme-modal').addClass('hidden').css('display', 'none');
        $('#edit-theme-form')[0].reset();
        hideEditErrors();
    }

    function hideCreateErrors() {
        $('#create-form-errors').addClass('hidden').find('ul').empty();
    }

    function showCreateErrors(errors) {
        let ul = $('#create-form-errors').removeClass('hidden').find('ul').empty();
        $.each(errors, function(key, messages) {
            $.each(messages, function(index, message) {
                ul.append('<li>' + message + '</li>');
            });
        });
    }

    function hideEditErrors() {
        $('#edit-form-errors').addClass('hidden').find('ul').empty();
    }

    function showEditErrors(errors) {
        let ul = $('#edit-form-errors').removeClass('hidden').find('ul').empty();
        $.each(errors, function(key, messages) {
            $.each(messages, function(index, message) {
                ul.append('<li>' + message + '</li>');
            });
        });
    }

    // Thumbnail Preview Handlers
    $('#create-thumbnail-input').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#create-thumbnail-preview').attr('src', e.target.result);
                $('#create-preview-container').removeClass('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            $('#create-preview-container').addClass('hidden');
        }
    });

    $('#edit-thumbnail-input').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#edit-thumbnail-preview').attr('src', e.target.result);
                $('#edit-preview-container').removeClass('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    // Refresh Table via AJAX
    function refreshTable(url = null) {
        let fetchUrl = url || "{{ route('admin.themes.index') }}";
        let search = $('#search-theme').val();
        let category = $('#filter-category').val();
        let tingkatan = $('#filter-tingkatan').val();
        let status = $('#filter-status').val();

        $('#grid-loader').removeClass('hidden').addClass('flex');

        $.ajax({
            url: fetchUrl,
            type: "GET",
            data: {
                search: search,
                category: category,
                tingkatan: tingkatan,
                status: status
            },
            dataType: "json",
            success: function(res) {
                $('#grid-loader').removeClass('flex').addClass('hidden');
                if (res.html) {
                    $('#themes-table-container').html(res.html);
                }
            },
            error: function() {
                $('#grid-loader').removeClass('flex').addClass('hidden');
            }
        });
    }

    // Live Search & Filter Events
    $('#search-theme').on('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            refreshTable();
        }, 300);
    });

    $('#filter-category, #filter-tingkatan, #filter-status').on('change', function() {
        refreshTable();
    });

    $('#btn-reset-filters').on('click', function() {
        $('#search-theme').val('');
        $('#filter-category').val('');
        $('#filter-tingkatan').val('');
        $('#filter-status').val('');
        refreshTable();
    });

    // Pagination Click Handler (Fix: intercept native nav a / pagination a)
    $(document).on('click', '#themes-table-container nav a, #themes-table-container .pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url) {
            refreshTable(url);
        }
    });

    // Submit Create Theme
    $('#create-theme-form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btn = $('#btnSubmitCreate');

        btn.prop('disabled', true).html('Menyimpan... <i class="fas fa-spinner fa-spin"></i>');
        hideCreateErrors();

        $.ajax({
            url: "{{ route('admin.themes.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                btn.prop('disabled', false).html('Tambah Tema');
                if (response.success || response.message) {
                    closeCreateModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    refreshTable();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Tambah Tema');
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    if (res.errors) {
                        showCreateErrors(res.errors);
                    } else if (res.message) {
                        showCreateErrors({
                            general: [res.message]
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.'
                    });
                }
            }
        });
    });

    // Submit Edit Theme
    $('#edit-theme-form').on('submit', function(e) {
        e.preventDefault();

        let themeId = $('#edit-theme-id').val();
        let formData = new FormData(this);
        formData.append('_method', 'PUT');

        let btn = $('#btnSubmitEdit');
        btn.prop('disabled', true).html('Menyimpan... <i class="fas fa-spinner fa-spin"></i>');
        hideEditErrors();

        $.ajax({
            url: '/admin/themes/' + themeId,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                btn.prop('disabled', false).html('Simpan Perubahan');
                if (response.success || response.message) {
                    closeEditModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    refreshTable();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Simpan Perubahan');
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    if (res.errors) {
                        showEditErrors(res.errors);
                    } else if (res.message) {
                        showEditErrors({
                            general: [res.message]
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem.'
                    });
                }
            }
        });
    });

    // Toggle Theme Status
    function toggleTheme(id) {
        $.ajax({
            url: '/admin/themes/' + id + '/toggle',
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                const badge = $('#theme-badge-' + id);
                if (response.is_active) {
                    badge.removeClass('bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200')
                        .addClass('bg-emerald-100 text-emerald-700 border-emerald-200 hover:bg-emerald-200')
                        .text('AKTIF');
                } else {
                    badge.removeClass(
                            'bg-emerald-100 text-emerald-700 border-emerald-200 hover:bg-emerald-200')
                        .addClass('bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200')
                        .text('NONAKTIF');
                }

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengubah status tema.'
                });
            }
        });
    }

    // Delete Theme
    function deleteTheme(id) {
        Swal.fire({
            title: 'Hapus Tema?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/themes/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        refreshTable();
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Gagal menghapus tema.'
                        });
                    }
                });
            }
        });
    }
</script>
