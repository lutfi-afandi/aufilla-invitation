@extends('layouts.client')

@section('title', 'Galeri Foto - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    
    @include('client.partials.tab_navigation')

    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5 flex justify-between items-center">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Galeri Pre-Wedding</h3>
            <span id="photo-counter" class="text-xs bg-brand-light/20 text-brand-dark px-3 py-1 rounded-full font-medium">{{ $galeris->count() }} / {{ \App\Helpers\PackageHelper::getMaxGalleryPhotos(Auth::user()->invitation) }} Foto</span>
        </div>
        
        <!-- Card Body -->
        <div class="p-7">
            
            <!-- Upload Area -->
            <!-- Upload Area -->
            <div id="upload-wrapper" class="{{ \App\Helpers\PackageHelper::canAddGalleryPhoto(Auth::user()->invitation) ? '' : 'hidden' }}">
                <div class="mb-8 bg-brand-bg/30 border-2 border-dashed border-brand-accent/40 rounded-2xl p-8 text-center transition-all hover:border-brand-accent/70 hover:bg-brand-bg/60" id="drop-zone">
                    <form id="form-upload-galeri" enctype="multipart/form-data">
                        @csrf
                        <input type="file" id="file-upload" name="image" class="hidden" accept="image/jpeg, image/png, image/jpg">
                        
                        <div class="cursor-pointer" onclick="document.getElementById('file-upload').click()">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm text-brand-accent">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="font-semibold text-brand-dark text-lg mb-1">Unggah Foto Baru</h4>
                            <p class="text-sm text-gray-500 mb-4">Klik area ini untuk memilih foto. (Maks 6MB, Format: JPG, PNG)</p>
                        </div>
                    </form>

                    <!-- Loading State -->
                    <div id="upload-loading" class="hidden flex-col items-center justify-center py-4">
                        <svg class="animate-spin h-8 w-8 text-brand-accent mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <p class="text-sm font-medium text-brand-dark">Mengunggah Foto...</p>
                    </div>
                </div>
            </div>

            <div id="limit-wrapper" class="{{ \App\Helpers\PackageHelper::canAddGalleryPhoto(Auth::user()->invitation) ? 'hidden' : '' }}">
                <div class="mb-8 bg-red-50 border border-red-200 rounded-2xl p-6 text-center shadow-sm">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3 text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h4 class="font-semibold text-red-800 text-lg mb-1">Kuota Galeri Penuh</h4>
                    <p class="text-sm text-red-600 mb-4">Anda telah mencapai batas maksimal <strong>{{ \App\Helpers\PackageHelper::getMaxGalleryPhotos(Auth::user()->invitation) }} foto</strong> untuk paket Anda saat ini.</p>
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin%2C%20saya%20ingin%20upgrade%20paket%20undangan%20saya." target="_blank" class="inline-flex items-center gap-2 bg-red-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-red-700 transition-colors shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        Upgrade Paket Sekarang
                    </a>
                </div>
            </div>

            <!-- Grid Foto -->
            <h4 class="font-semibold text-brand-dark mb-4 text-md flex items-center gap-2">
                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Album Galeri
            </h4>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="gallery-grid">
                @forelse($galeris as $galeri)
                    <div class="relative group rounded-xl overflow-hidden aspect-square bg-gray-100 shadow-sm border border-brand-accent/10" id="galeri-{{ $galeri->id }}">
                        <img src="{{ asset('storage/' . $galeri->image_path) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Galeri">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <button onclick="hapusFoto({{ $galeri->id }})" class="w-full bg-white/20 hover:bg-red-500/90 text-white backdrop-blur-md rounded-lg py-2 text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center" id="empty-state">
                        <svg class="w-16 h-16 text-brand-accent/30 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-brand-dark/50 text-sm">Belum ada foto di galeri. Mulai unggah foto terbaik Anda!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#file-upload').on('change', function() {
        if(this.files.length > 0) {
            uploadFoto();
        }
    });

    function uploadFoto() {
        var formData = new FormData($('#form-upload-galeri')[0]);
        
        $('#form-upload-galeri > div').addClass('hidden');
        $('#upload-loading').removeClass('hidden').addClass('flex');

        $.ajax({
            url: "{{ route('client.galeri.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#file-upload').val('');
                $('#upload-loading').addClass('hidden').removeClass('flex');
                $('#form-upload-galeri > div').removeClass('hidden');

                Swal.fire({
                    toast: true, position: 'top-end', icon: 'success', title: 'Foto berhasil diunggah', showConfirmButton: false, timer: 2000
                });

                $('#empty-state').remove();

                var newCard = `
                    <div class="relative group rounded-xl overflow-hidden aspect-square bg-gray-100 shadow-sm border border-brand-accent/10" id="galeri-${response.galeri.id}">
                        <img src="/storage/${response.galeri.image_path}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="Galeri">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <button onclick="hapusFoto(${response.galeri.id})" class="w-full bg-white/20 hover:bg-red-500/90 text-white backdrop-blur-md rounded-lg py-2 text-sm font-semibold transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                `;
                $('#gallery-grid').prepend(newCard);
                
                checkPhotoLimit();
            },
            error: function(xhr) {
                $('#file-upload').val('');
                $('#upload-loading').addClass('hidden').removeClass('flex');
                $('#form-upload-galeri > div').removeClass('hidden');
                
                let errMsg = 'Gagal mengunggah foto.';
                if(xhr.responseJSON) {
                    if (xhr.responseJSON.error) {
                        errMsg = xhr.responseJSON.error;
                    } else if (xhr.responseJSON.errors) {
                        errMsg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                }
                Swal.fire({ icon: 'error', title: 'Oops...', text: errMsg });
            }
        });
    }

    function hapusFoto(id) {
        Swal.fire({
            title: 'Hapus foto ini?',
            text: "Foto akan dihapus secara permanen dari server.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#a0aec0',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/client/galeri/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#galeri-' + id).fadeOut(300, function() { 
                            $(this).remove(); 
                            checkPhotoLimit();
                        });
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Foto dihapus', showConfirmButton: false, timer: 2000 });
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menghapus foto' });
                    }
                });
            }
        });
    }

    function checkPhotoLimit() {
        const maxPhotos = {{ \App\Helpers\PackageHelper::getMaxGalleryPhotos(Auth::user()->invitation) }};
        const currentCount = $('#gallery-grid > div.relative').length;
        
        $('#photo-counter').text(currentCount + ' / ' + maxPhotos + ' Foto');

        if (currentCount >= maxPhotos) {
            $('#upload-wrapper').addClass('hidden');
            $('#limit-wrapper').removeClass('hidden');
        } else {
            $('#limit-wrapper').addClass('hidden');
            $('#upload-wrapper').removeClass('hidden');
        }
    }
</script>
@endpush
