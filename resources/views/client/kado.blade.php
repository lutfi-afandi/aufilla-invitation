@extends('layouts.client')

@section('title', 'Kado Digital & Rekening - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full space-y-6">
    
    @include('client.partials.tab_navigation')

    <!-- Bagian 1: Alamat Pengiriman Kado Fisik -->
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark flex items-center gap-2" style="font-family: 'Playfair Display', serif;">
                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                Alamat Kado Fisik
            </h3>
        </div>
        
        <div class="p-7">
            <form id="form-alamat" class="flex flex-col md:flex-row gap-4 items-end">
                @csrf
                <div class="w-full">
                    <label class="block font-medium text-brand-dark mb-2 text-sm">Alamat Lengkap Pengiriman</label>
                    <textarea name="alamat_kado" rows="2" class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Isi alamat lengkap beserta kode pos...">{{ $invitation->alamat_kado }}</textarea>
                </div>
                <button type="button" id="btn-save-alamat" onclick="simpanAlamat()" class="px-5 py-2.5 h-[42px] whitespace-nowrap text-sm font-medium text-white bg-brand-dark rounded-xl hover:bg-black shadow-sm transition-colors">
                    Simpan Alamat
                </button>
            </form>
        </div>
    </div>

    <!-- Bagian 2: Daftar Rekening -->
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5 flex justify-between items-center">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark flex items-center gap-2" style="font-family: 'Playfair Display', serif;">
                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Rekening / E-Wallet
            </h3>
            <button onclick="$('#add-rekening-modal').removeClass('hidden')" class="bg-brand-accent hover:bg-brand-accent-dark text-white text-sm font-semibold py-1.5 px-4 rounded-xl shadow-sm transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Rekening
            </button>
        </div>
        
        <div class="p-7">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="rekening-grid">
                @forelse($kados as $kado)
                    <div class="relative bg-white border border-brand-accent/20 rounded-2xl p-5 hover:shadow-md transition-shadow group" id="rekening-{{ $kado->id }}">
                        <button onclick="hapusRekening({{ $kado->id }})" class="absolute top-4 right-4 text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        
                        <div class="text-sm font-bold tracking-widest text-brand-accent uppercase mb-1">{{ $kado->nama_bank }}</div>
                        <div class="text-xl font-bold text-gray-800 tracking-wider mb-2 font-mono">{{ $kado->no_rekening }}</div>
                        <div class="text-sm text-gray-500 font-medium">a.n {{ $kado->nama_pemilik }}</div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center" id="empty-state">
                        <svg class="w-16 h-16 text-brand-accent/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        <p class="text-brand-dark/50 text-sm">Belum ada rekening yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Rekening -->
<div id="add-rekening-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm" onclick="$('#add-rekening-modal').addClass('hidden')"></div>

        <div class="relative inline-block w-full max-w-md overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="bg-white px-6 py-5">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-semibold text-brand-dark flex items-center gap-2" style="font-family: 'Playfair Display', serif;">
                        <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Tambah Rekening Baru
                    </h3>
                    <button onclick="$('#add-rekening-modal').addClass('hidden')" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="form-add-rekening">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Nama Bank / E-Wallet <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_bank" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: BCA, Mandiri, DANA, GoPay">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Nomor Rekening / No. HP <span class="text-red-500">*</span></label>
                            <input type="text" name="no_rekening" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: 1234567890">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Nama Pemilik Rekening <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pemilik" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: John Doe">
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                <button type="button" onclick="$('#add-rekening-modal').addClass('hidden')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
                <button type="button" id="btn-save-rekening" onclick="simpanRekening()" class="px-5 py-2 text-sm font-medium text-white bg-brand-accent rounded-xl hover:bg-brand-accent-dark shadow-sm transition-colors flex items-center gap-2">
                    Simpan Rekening
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function simpanAlamat() {
        var btn = $('#btn-save-alamat');
        var originalText = btn.html();
        btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>').prop('disabled', true);

        $.ajax({
            url: "{{ route('client.kado.alamat.update') }}",
            type: "POST",
            data: $('#form-alamat').serialize(),
            success: function(response) {
                btn.html(originalText).prop('disabled', false);
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Alamat Kado disimpan', showConfirmButton: false, timer: 2000 });
            },
            error: function(xhr) {
                btn.html(originalText).prop('disabled', false);
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menyimpan alamat kado.' });
            }
        });
    }

    function simpanRekening() {
        if(!$('#form-add-rekening')[0].checkValidity()) {
            $('#form-add-rekening')[0].reportValidity();
            return;
        }

        var btn = $('#btn-save-rekening');
        var originalText = btn.html();
        btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>').prop('disabled', true);

        $.ajax({
            url: "{{ route('client.kado.store') }}",
            type: "POST",
            data: $('#form-add-rekening').serialize(),
            success: function(response) {
                btn.html(originalText).prop('disabled', false);
                $('#add-rekening-modal').addClass('hidden');
                $('#form-add-rekening')[0].reset();
                $('#empty-state').remove();

                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Rekening ditambahkan', showConfirmButton: false, timer: 2000 });

                var html = `
                    <div class="relative bg-white border border-brand-accent/20 rounded-2xl p-5 hover:shadow-md transition-shadow group" id="rekening-${response.kado.id}">
                        <button onclick="hapusRekening(${response.kado.id})" class="absolute top-4 right-4 text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        
                        <div class="text-sm font-bold tracking-widest text-brand-accent uppercase mb-1">${response.kado.nama_bank}</div>
                        <div class="text-xl font-bold text-gray-800 tracking-wider mb-2 font-mono">${response.kado.no_rekening}</div>
                        <div class="text-sm text-gray-500 font-medium">a.n ${response.kado.nama_pemilik}</div>
                    </div>
                `;
                $('#rekening-grid').append(html);
            },
            error: function(xhr) {
                btn.html(originalText).prop('disabled', false);
                let errMsg = 'Gagal menyimpan rekening.';
                if(xhr.responseJSON && xhr.responseJSON.errors) errMsg = Object.values(xhr.responseJSON.errors)[0][0];
                Swal.fire({ icon: 'error', title: 'Oops...', text: errMsg });
            }
        });
    }

    function hapusRekening(id) {
        Swal.fire({
            title: 'Hapus rekening ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#a0aec0',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/client/kado/" + id,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response) {
                        $('#rekening-' + id).fadeOut(300, function() { $(this).remove(); });
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Rekening dihapus', showConfirmButton: false, timer: 2000 });
                    }
                });
            }
        });
    }
</script>
@endpush
