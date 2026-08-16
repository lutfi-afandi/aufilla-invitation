<script>
    function openModalCreate() {
        $('#modalTitle').text('Tambah Paket Baru');
        $('#paketForm').attr('action', "{{ route('admin.pakets.store') }}");
        $('#methodField').empty();
        $('#paketForm')[0].reset();

        // Default values
        $('#paket_price').val(0);
        $('#paket_active_days').val(30);
        $('#paket_max_wa_send').val(99999);
        $('#paket_max_gallery_photos').val(10);

        hideErrors();
        $('#paketModal').removeClass('hidden');
    }

    function openModalEdit(paket) {
        $('#modalTitle').text('Edit Paket: ' + paket.name);
        $('#paketForm').attr('action', '/admin/pakets/' + paket.id);
        $('#methodField').html('<input type="hidden" name="_method" value="PUT">');

        $('#paket_name').val(paket.name);
        $('#paket_price').val(paket.price);
        $('#paket_active_days').val(paket.active_days);
        $('#paket_max_wa_send').val(paket.max_wa_send || 99999);
        $('#paket_max_gallery_photos').val(paket.max_gallery_photos);
        $('#paket_has_love_story').prop('checked', !!paket.has_love_story);
        $('#paket_can_custom_music').prop('checked', !!paket.can_custom_music);
        $('#paket_is_priority_support').prop('checked', !!paket.is_priority_support);
        $('#paket_description').val(paket.description || '');

        hideErrors();
        $('#paketModal').removeClass('hidden');
    }

    function closeModal() {
        $('#paketModal').addClass('hidden');
        $('#paketForm')[0].reset();
        hideErrors();
    }

    function hideErrors() {
        $('#formErrors').addClass('hidden').find('ul').empty();
    }

    function showErrors(errors) {
        let ul = $('#formErrors').removeClass('hidden').find('ul').empty();
        $.each(errors, function(key, messages) {
            $.each(messages, function(index, message) {
                ul.append('<li>' + message + '</li>');
            });
        });
    }

    function refreshList() {
        $.ajax({
            url: "{{ route('admin.pakets.index') }}",
            type: "GET",
            dataType: "json",
            success: function(res) {
                if (res.html) {
                    $('#paket-list-grid').replaceWith(res.html);
                }
            }
        });
    }

    // Submit form via AJAX
    $('#paketForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = form.serialize();
        let btn = $('#btnSubmitPaket');

        btn.prop('disabled', true).html('Menyimpan... <i class="fas fa-spinner fa-spin"></i>');
        hideErrors();

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                btn.prop('disabled', false).html('Simpan');
                if (response.success) {
                    closeModal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    refreshList();
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('Simpan');
                if (xhr.status === 422) {
                    let res = xhr.responseJSON;
                    if (res.errors) {
                        showErrors(res.errors);
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

    // Delete Paket via AJAX
    function deletePaket(id) {
        Swal.fire({
            title: 'Hapus Paket?',
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
                    url: '/admin/pakets/' + id,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            refreshList();
                        }
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Gagal menghapus paket.'
                        });
                    }
                });
            }
        });
    }
</script>
