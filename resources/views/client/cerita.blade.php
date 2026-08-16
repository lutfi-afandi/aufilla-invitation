@extends('layouts.client')

@section('title', 'Cerita Cinta - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    
    @include('client.partials.tab_navigation')

    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5 flex justify-between items-center">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Linimasa Cerita Cinta</h3>
            @if(\App\Helpers\PackageHelper::canAccessLoveStory(Auth::user()->invitation))
            <button onclick="$('#add-cerita-modal').removeClass('hidden')" class="bg-brand-accent hover:bg-brand-accent-dark text-white text-sm font-semibold py-1.5 px-4 rounded-xl shadow-sm transition-colors flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Cerita
            </button>
            @else
            <span class="text-xs bg-red-100 text-red-600 px-3 py-1.5 rounded-lg font-semibold flex items-center gap-1 border border-red-200">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Fitur Terkunci
            </span>
            @endif
        </div>
        
        <!-- Card Body -->
        <div class="p-7">
            
            <div class="relative border-l-2 border-brand-accent/30 ml-4 md:ml-6" id="cerita-timeline">
                @forelse($ceritas as $cerita)
                    <div class="mb-8 relative pl-8 md:pl-10 group" id="cerita-{{ $cerita->id }}">
                        <!-- Dot -->
                        <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-brand-accent ring-4 ring-white shadow-sm"></div>
                        
                        <!-- Content Card -->
                        <div class="bg-brand-bg/30 border border-brand-accent/20 rounded-2xl p-5 hover:border-brand-accent/50 transition-colors relative">
                            <!-- Action Buttons (Visible on hover) -->
                            <div class="absolute top-4 right-4 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <button onclick="editCerita({{ $cerita->id }})" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="hapusCerita({{ $cerita->id }})" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            
                            <span class="inline-block text-xs font-bold tracking-wider text-brand-accent uppercase mb-2 bg-brand-accent/10 px-3 py-1 rounded-full">{{ $cerita->tanggal }}</span>
                            <h4 class="text-lg font-bold text-brand-dark mb-2" style="font-family: 'Playfair Display', serif;">{{ $cerita->judul }}</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">{{ $cerita->isi ?? $cerita->isi_cerita }}</p>
                        </div>
                    </div>
                @empty
                    <div class="py-12 pl-8 text-center" id="empty-state">
                        <svg class="w-16 h-16 text-brand-accent/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        <p class="text-brand-dark/50 text-sm">Belum ada linimasa cerita. Mulai bagikan awal mula perjalanan cinta Anda!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<!-- Modal Tambah Cerita -->
<div id="add-cerita-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm" onclick="$('#add-cerita-modal').addClass('hidden')"></div>

        <div class="relative inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="bg-white px-6 py-5">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-semibold text-brand-dark flex items-center gap-2" style="font-family: 'Playfair Display', serif;">
                        <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Tambah Linimasa Baru
                    </h3>
                    <button onclick="tutupModal('add')" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="form-add-cerita">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Tanggal/Waktu Momen <span class="text-red-500">*</span></label>
                            <input type="text" name="tanggal" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: 14 Februari 2023 atau Tahun 2021">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Judul Cerita <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: Awal Bertemu">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Isi Cerita <span class="text-red-500">*</span></label>
                            <textarea name="isi_cerita" required rows="4" class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Ceritakan bagaimana momen ini terjadi..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                <button type="button" onclick="tutupModal('add')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
                <button type="button" id="btn-save" onclick="simpanCerita()" class="px-5 py-2 text-sm font-medium text-white bg-brand-accent rounded-xl hover:bg-brand-accent-dark shadow-sm transition-colors flex items-center gap-2">
                    Simpan Cerita
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Cerita -->
<div id="edit-cerita-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/40 backdrop-blur-sm" onclick="tutupModal('edit')"></div>

        <div class="relative inline-block w-full max-w-lg overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
            <div class="bg-white px-6 py-5">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-semibold text-brand-dark flex items-center gap-2" style="font-family: 'Playfair Display', serif;">
                        <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Linimasa
                    </h3>
                    <button onclick="tutupModal('edit')" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="form-edit-cerita">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_id" id="edit-id">
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Tanggal/Waktu Momen <span class="text-red-500">*</span></label>
                            <input type="text" name="tanggal" id="edit-tanggal" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: 14 Februari 2023 atau Tahun 2021">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Judul Cerita <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="edit-judul" required class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: Awal Bertemu">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-1.5 text-sm">Isi Cerita <span class="text-red-500">*</span></label>
                            <textarea name="isi_cerita" id="edit-isi" required rows="4" class="w-full bg-white border-1.5 border-brand-light/40 rounded-xl px-4 py-2 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Ceritakan bagaimana momen ini terjadi..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                <button type="button" onclick="tutupModal('edit')" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
                <button type="button" id="btn-edit-save" onclick="updateCerita()" class="px-5 py-2 text-sm font-medium text-white bg-brand-accent rounded-xl hover:bg-brand-accent-dark shadow-sm transition-colors flex items-center gap-2">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function tutupModal(type) {
        if (type === 'add') {
            $('#add-cerita-modal').addClass('hidden');
        } else {
            $('#edit-cerita-modal').addClass('hidden');
        }
    }

    function simpanCerita() {
        if(!$('#form-add-cerita')[0].checkValidity()) {
            $('#form-add-cerita')[0].reportValidity();
            return;
        }

        var btn = $('#btn-save');
        var originalText = btn.html();
        btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>').prop('disabled', true);

        $.ajax({
            url: "{{ route('client.cerita.store') }}",
            type: "POST",
            data: $('#form-add-cerita').serialize(),
            success: function(response) {
                btn.html(originalText).prop('disabled', false);
                tutupModal('add');
                $('#form-add-cerita')[0].reset();
                $('#empty-state').remove();

                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Cerita ditambahkan!', showConfirmButton: false, timer: 2000 });

                var html = buatCardCerita(response.cerita);
                $('#cerita-timeline').append(html);
            },
            error: function(xhr) {
                btn.html(originalText).prop('disabled', false);
                let errMsg = 'Gagal menyimpan cerita.';
                if(xhr.responseJSON && xhr.responseJSON.errors) errMsg = Object.values(xhr.responseJSON.errors)[0][0];
                Swal.fire({ icon: 'error', title: 'Oops...', text: errMsg });
            }
        });
    }

    function buatCardCerita(data) {
        var id = data.id;
        var tanggal = data.tanggal || '';
        var judul = data.judul || '';
        var isi = data.isi || data.isi_cerita || '';
        return `
            <div class="mb-8 relative pl-8 md:pl-10 group" id="cerita-${id}">
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-brand-accent ring-4 ring-white shadow-sm"></div>
                <div class="bg-brand-bg/30 border border-brand-accent/20 rounded-2xl p-5 hover:border-brand-accent/50 transition-colors relative">
                    <div class="absolute top-4 right-4 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <button onclick="editCerita(${id})" class="text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button onclick="hapusCerita(${id})" class="text-red-400 hover:text-red-600 bg-red-50 hover:bg-red-100 p-1.5 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                    <span class="inline-block text-xs font-bold tracking-wider text-brand-accent uppercase mb-2 bg-brand-accent/10 px-3 py-1 rounded-full">${tanggal}</span>
                    <h4 class="text-lg font-bold text-brand-dark mb-2" style="font-family: 'Playfair Display', serif;">${judul}</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">${isi}</p>
                </div>
            </div>
        `;
    }

    function editCerita(id) {
        var card = $('#cerita-' + id);
        var tanggal = card.find('.inline-block').text().trim();
        var judul = card.find('h4').text().trim();
        var isi = card.find('p').text().trim();

        $('#edit-id').val(id);
        $('#edit-tanggal').val(tanggal);
        $('#edit-judul').val(judul);
        $('#edit-isi').val(isi);
        $('#edit-cerita-modal').removeClass('hidden');
    }

    function updateCerita() {
        if(!$('#form-edit-cerita')[0].checkValidity()) {
            $('#form-edit-cerita')[0].reportValidity();
            return;
        }

        var id = $('#edit-id').val();
        var btn = $('#btn-edit-save');
        var originalText = btn.html();
        btn.html('<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>').prop('disabled', true);

        $.ajax({
            url: '/client/cerita/' + id,
            type: 'POST',
            data: $('#form-edit-cerita').serialize() + '&_method=PUT',
            success: function(response) {
                btn.html(originalText).prop('disabled', false);
                tutupModal('edit');

                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Cerita diperbarui!', showConfirmButton: false, timer: 2000 });

                var newCard = buatCardCerita(response.cerita);
                $('#cerita-' + id).replaceWith(newCard);
            },
            error: function(xhr) {
                btn.html(originalText).prop('disabled', false);
                let errMsg = 'Gagal memperbarui cerita.';
                if(xhr.responseJSON && xhr.responseJSON.errors) errMsg = Object.values(xhr.responseJSON.errors)[0][0];
                Swal.fire({ icon: 'error', title: 'Oops...', text: errMsg });
            }
        });
    }

    function hapusCerita(id) {
        Swal.fire({
            title: 'Hapus cerita ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#a0aec0',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/client/cerita/" + id,
                    type: "DELETE",
                    data: { _token: "{{ csrf_token() }}" },
                    success: function(response) {
                        $('#cerita-' + id).slideUp(300, function() { $(this).remove(); });
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Cerita dihapus', showConfirmButton: false, timer: 2000 });
                    }
                });
            }
        });
    }
</script>
@endpush
