@extends('layouts.client')

@section('title', 'Manajemen Tamu - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5 flex justify-between items-center">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Buku Tamu</h3>
            <button onclick="$('#modal-tamu').removeClass('hidden').addClass('flex');" class="bg-brand-dark hover:bg-brand-medium text-white px-5 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Tamu
            </button>
        </div>
        
        <!-- Card Body -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-brand-dark/5 text-brand-dark uppercase text-xs font-semibold tracking-wide border-b border-brand-accent/15">
                        <th class="px-7 py-4">Nama Tamu</th>
                        <th class="px-7 py-4">No. WhatsApp</th>
                        <th class="px-7 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-accent/10 text-sm text-gray-700" id="tamu-list">
                    <!-- Data AJAX will be populated here -->
                    <tr class="hover:bg-brand-accent/5 transition-colors">
                        <td colspan="3" class="px-7 py-8 text-center text-gray-500 italic">Memuat data tamu...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Tamu -->
<div id="modal-tamu" class="fixed inset-0 z-50 hidden bg-brand-dark/40 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
        <div class="px-6 py-4 border-b border-brand-accent/15 bg-brand-bg flex justify-between items-center">
            <h3 class="text-lg font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Tambah Tamu Baru</h3>
            <button onclick="$('#modal-tamu').removeClass('flex').addClass('hidden');" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="form-tambah-tamu" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-brand-dark mb-1">Nama Tamu</label>
                    <input type="text" name="nama_tamu" id="tamu_nama" required class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Masukkan nama tamu">
                </div>
                <div>
                    <label class="block text-sm font-medium text-brand-dark mb-1">No. WhatsApp <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input type="text" name="no_wa" id="tamu_wa" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: 08123456789">
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="$('#modal-tamu').removeClass('flex').addClass('hidden');" class="px-5 py-2.5 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl font-medium transition-colors text-sm">Batal</button>
                <button type="submit" id="btn-save-tamu" class="px-5 py-2.5 bg-brand-dark hover:bg-brand-medium text-white rounded-xl font-medium transition-colors text-sm shadow-sm flex items-center">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Load Data Tamu
        function loadTamu() {
            $.get("{{ route('client.tamu.data') }}", function(data) {
                let html = '';
                if(data.length === 0) {
                    html = '<tr><td colspan="3" class="px-7 py-8 text-center text-gray-500 italic border-b border-brand-accent/10">Belum ada data tamu.</td></tr>';
                } else {
                    data.forEach(function(item) {
                        html += `
                        <tr class="hover:bg-brand-accent/5 transition-colors border-b border-brand-accent/10 last:border-0" id="tamu-${item.id}">
                            <td class="px-7 py-4 text-sm font-medium text-gray-800">${item.nama_tamu}</td>
                            <td class="px-7 py-4 text-sm text-gray-500">${item.no_wa || '-'}</td>
                            <td class="px-7 py-4 text-right text-sm">
                                <button class="text-brand-accent-dark hover:text-brand-dark font-medium mr-4 transition-colors">Kirim WA</button>
                                <button class="text-red-500 hover:text-red-700 font-medium transition-colors btn-delete-tamu" data-id="${item.id}">Hapus</button>
                            </td>
                        </tr>
                        `;
                    });
                }
                $('#tamu-list').html(html);
            });
        }

        loadTamu();

        // Submit Form Tamu
        $('#form-tambah-tamu').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btn-save-tamu');
            var originalText = btn.html();
            btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...').prop('disabled', true);

            $.ajax({
                url: "{{ route('client.tamu.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    btn.html(originalText).prop('disabled', false);
                    $('#form-tambah-tamu')[0].reset();
                    $('#modal-tamu').removeClass('flex').addClass('hidden');
                    loadTamu();
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tamu berhasil ditambahkan!',
                        showConfirmButton: false,
                        timer: 2500,
                        customClass: { popup: 'border-l-4 border-green-500 rounded-lg shadow-lg' }
                    });
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menambah tamu.' });
                }
            });
        });

        // Delete Tamu
        $(document).on('click', '.btn-delete-tamu', function() {
            var id = $(this).data('id');
            
            Swal.fire({
                title: 'Hapus Tamu?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0a2214',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "/client/tamu/" + id,
                        method: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function(response) {
                            $('#tamu-' + id).fadeOut(300, function() { $(this).remove(); });
                            Swal.fire({
                                toast: true, position: 'top-end', icon: 'success', title: 'Tamu dihapus', showConfirmButton: false, timer: 2000
                            });
                        }
                    });
                }
            })
        });
    });
</script>
@endpush
