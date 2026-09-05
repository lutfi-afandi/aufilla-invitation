<script>
    let searchCatTimeout = null;

    // Slug generator helper
    function slugifyCat(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '_')
            .replace(/[^\w\_]+/g, '')
            .replace(/\_\_+/g, '_')
            .replace(/^_+/, '')
            .replace(/_+$/, '');
    }

    $('#create-nama-input').on('input', function() {
        if (!$('#create-slug-input').data('manual')) {
            $('#create-slug-input').val(slugifyCat($(this).val()));
        }
    });

    $('#create-slug-input').on('input', function() {
        $(this).data('manual', true);
    });

    // Modal Controls
    function openCreateCategory() {
        $('#create-category-form')[0].reset();
        $('#create-slug-input').data('manual', false);
        hideCreateErrors();
        $('#create-category-modal').removeClass('hidden').css('display', 'flex');
    }

    function closeCreateModal() {
        $('#create-category-modal').addClass('hidden').css('display', 'none');
        $('#create-category-form')[0].reset();
        hideCreateErrors();
    }

    function openEditCategory(category) {
        $('#edit-modal-title').text('Edit Kategori: ' + category.nama);
        $('#edit-category-id').val(category.id);
        $('#edit-category-nama').val(category.nama);
        $('#edit-category-slug').val(category.slug);
        $('#edit-category-urutan').val(category.urutan);
        $('#edit-category-status').val(category.is_active ? '1' : '0');

        hideEditErrors();
        $('#edit-category-modal').removeClass('hidden').css('display', 'flex');
    }

    function closeEditModal() {
        $('#edit-category-modal').addClass('hidden').css('display', 'none');
        $('#edit-category-form')[0].reset();
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

    // Refresh Table via AJAX
    function refreshCategoryTable(url = null) {
        let fetchUrl = url || "{{ route('admin.theme-categories.index') }}";
        let search = $('#search-category').val();

        $('#category-grid-loader').removeClass('hidden').css('display', 'flex');

        $.ajax({
            url: fetchUrl,
            type: 'GET',
            data: {
                search: search
            },
            success: function(response) {
                if (response.html) {
                    $('#category-table-container').html(response.html);
                }
            },
            error: function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal memuat data kategori.',
                        confirmButtonColor: '#4f46e5'
                    });
                }
            },
            complete: function() {
                $('#category-grid-loader').addClass('hidden').css('display', 'none');
            }
        });
    }

    // Live Search
    $('#search-category').on('input', function() {
        clearTimeout(searchCatTimeout);
        searchCatTimeout = setTimeout(function() {
            refreshCategoryTable();
        }, 350);
    });

    // Pagination AJAX Interception
    $(document).on('click', '#category-table-wrapper .pagination a', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (url) {
            refreshCategoryTable(url);
        }
    });

    // Submit Create Form via AJAX
    $('#create-category-form').on('submit', function(e) {
        e.preventDefault();
        hideCreateErrors();
        let btn = $('#btnSubmitCreate');
        let originalText = btn.html();
        btn.prop('disabled', true).html(
            '<svg class="animate-spin h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...'
            );

        $.ajax({
            url: "{{ route('admin.theme-categories.store') }}",
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    closeCreateModal();
                    if (response.html) {
                        $('#category-table-container').html(response.html);
                    } else {
                        refreshCategoryTable();
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1800,
                            showConfirmButton: false
                        });
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    showCreateErrors(xhr.responseJSON.errors);
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan sistem.',
                            confirmButtonColor: '#4f46e5'
                        });
                    }
                }
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Submit Edit Form via AJAX
    $('#edit-category-form').on('submit', function(e) {
        e.preventDefault();
        hideEditErrors();
        let id = $('#edit-category-id').val();
        let btn = $('#btnSubmitEdit');
        let originalText = btn.html();
        btn.prop('disabled', true).html(
            '<svg class="animate-spin h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...'
            );

        $.ajax({
            url: "/admin/theme-categories/" + id,
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    closeEditModal();
                    if (response.html) {
                        $('#category-table-container').html(response.html);
                    } else {
                        refreshCategoryTable();
                    }
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1800,
                            showConfirmButton: false
                        });
                    }
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    showEditErrors(xhr.responseJSON.errors);
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan sistem.',
                            confirmButtonColor: '#4f46e5'
                        });
                    }
                }
            },
            complete: function() {
                btn.prop('disabled', false).html(originalText);
            }
        });
    });

    // Toggle Active via AJAX
    function toggleCategory(id) {
        $.ajax({
            url: "/admin/theme-categories/" + id + "/toggle",
            type: 'PATCH',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    if (response.html) {
                        $('#category-table-container').html(response.html);
                    } else {
                        refreshCategoryTable();
                    }
                }
            },
            error: function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengubah status kategori.',
                        confirmButtonColor: '#4f46e5'
                    });
                }
            }
        });
    }

    // Delete Category via AJAX with SweetAlert Confirmation
    function deleteCategory(id, count) {
        if (count > 0) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tidak Dapat Dihapus',
                    text: 'Kategori ini masih memiliki ' + count +
                        ' tema terkait. Pindahkan tema terlebih dahulu.',
                    confirmButtonColor: '#4f46e5'
                });
            } else {
                alert('Kategori ini masih memiliki ' + count + ' tema terkait.');
            }
            return;
        }

        let executeDelete = function() {
            $.ajax({
                url: "/admin/theme-categories/" + id,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        if (response.html) {
                            $('#category-table-container').html(response.html);
                        } else {
                            refreshCategoryTable();
                        }
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                timer: 1800,
                                showConfirmButton: false
                            });
                        }
                    }
                },
                error: function(xhr) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menghapus.',
                            confirmButtonColor: '#4f46e5'
                        });
                    }
                }
            });
        };

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Kategori?',
                text: "Kategori yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    executeDelete();
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                executeDelete();
            }
        }
    }
</script>
