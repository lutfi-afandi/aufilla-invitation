<script>
    let searchTimer;

    function fetchUsers(url) {
        let fetchUrl = url || "{{ route('admin.users.index') }}";
        $.ajax({
            url: fetchUrl,
            type: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(res) {
                if (res.html) {
                    $('#table-content-wrapper').html(res.html);
                }
            }
        });
    }

    $('#search-user').on('keyup', function() {
        clearTimeout(searchTimer);
        let val = $(this).val();
        searchTimer = setTimeout(function() {
            fetchUsers(`{{ route('admin.users.index') }}?search=${val}`);
        }, 300);
    });

    $(document).on('click', '#users-table-container .pagination a', function(e) {
        e.preventDefault();
        fetchUsers($(this).attr('href'));
    });

    function openCreateModal() {
        $('#create-form')[0].reset();
        hideCreateErrors();
        $('#create-modal').removeClass('hidden').css('display', 'flex');
    }

    function openEditModal(id) {
        hideEditErrors();
        $.get(`/admin/users/${id}`, function(res) {
            $('#edit-id').val(res.id);
            $('#edit-username').val(res.username);
            $('#edit-email').val(res.email);
            $('#edit-form').find('input[name="password"]').val('');
            
            $('#edit-modal').removeClass('hidden').css('display', 'flex');
        });
    }

    function closeModal(id) {
        $('#' + id).addClass('hidden').css('display', 'none');
        hideCreateErrors();
        hideEditErrors();
    }

    function hideCreateErrors() {
        $('#create-form-errors').addClass('hidden').find('ul').empty();
    }

    function showCreateErrors(errors) {
        let ul = $('#create-form-errors').removeClass('hidden').find('ul').empty();
        $.each(errors, function (key, messages) {
            $.each(messages, function (index, message) {
                ul.append('<li>' + message + '</li>');
            });
        });
    }

    function hideEditErrors() {
        $('#edit-form-errors').addClass('hidden').find('ul').empty();
    }

    function showEditErrors(errors) {
        let ul = $('#edit-form-errors').removeClass('hidden').find('ul').empty();
        $.each(errors, function (key, messages) {
            $.each(messages, function (index, message) {
                ul.append('<li>' + message + '</li>');
            });
        });
    }

    // Submit Create Admin Form
    $('#create-form').submit(function(e) {
        e.preventDefault();
        let btn = $('#btnSubmitCreateUser');
        btn.prop('disabled', true).html('Menyimpan... <i class="fas fa-spinner fa-spin"></i>');
        hideCreateErrors();
        
        $.ajax({
            url: `{{ route('admin.users.store') }}`,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan Admin');
                if (res.success || res.message) {
                    closeModal('create-modal');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message || 'Admin berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    fetchUsers();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Simpan Admin');
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    if (res.errors) {
                        showCreateErrors(res.errors);
                    } else if (res.message) {
                        showCreateErrors({ general: [res.message] });
                    }
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Mohon periksa kembali form isian!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                    Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                }
            }
        });
    });

    // Submit Edit Admin Form
    $('#edit-form').submit(function(e) {
        e.preventDefault();
        let id = $('#edit-id').val();
        let btn = $('#btnSubmitEditUser');
        btn.prop('disabled', true).html('Menyimpan... <i class="fas fa-spinner fa-spin"></i>');
        hideEditErrors();
        
        $.ajax({
            url: `/admin/users/${id}`,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan Perubahan');
                if (res.success || res.message) {
                    closeModal('edit-modal');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: res.message || 'Data admin berhasil diperbarui',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    fetchUsers();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Simpan Perubahan');
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    if (res.errors) {
                        showEditErrors(res.errors);
                    } else if (res.message) {
                        showEditErrors({ general: [res.message] });
                    }
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'warning',
                        title: 'Mohon periksa kembali form isian!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                } else {
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan sistem.';
                    Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                }
            }
        });
    });

    // Delete Admin
    function deleteUser(id) {
        Swal.fire({
            title: 'Hapus Admin?',
            text: "Data akun admin akan dihapus secara permanen!",
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
                    dataType: 'json',
                    success: function(res) {
                        if (res.success || res.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            fetchUsers();
                        }
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        let msg = (res && res.message) ? res.message : 'Terjadi kesalahan saat menghapus.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    }
                });
            }
        });
    }
</script>
