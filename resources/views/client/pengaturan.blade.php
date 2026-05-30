@extends('layouts.client')

@section('title', 'Pengaturan Tema - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Pengaturan Tampilan Undangan</h3>
        </div>
        
        <!-- Card Body -->
        <div class="p-7">
            <form id="form-pengaturan" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Kiri: Tema & Status -->
                    <div class="space-y-6">
                        <div class="bg-brand-bg/50 p-5 rounded-2xl border border-brand-accent/20">
                            <h4 class="font-semibold text-brand-dark mb-4 text-md flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                                Tema & Status Publikasi
                            </h4>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium text-brand-dark mb-2 text-sm">Tema Undangan</label>
                                    <div class="w-full bg-gray-100 border-1.5 border-brand-accent/30 rounded-xl px-4 py-2.5 text-sm text-gray-600 font-medium cursor-not-allowed">
                                        {{ $invitation->theme ? $invitation->theme->name . ' (' . $invitation->theme->code . ')' : 'Belum Ada Tema' }}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">*Tema ditentukan oleh Admin / saat pendaftaran.</p>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-brand-dark mb-2 text-sm">Status Undangan</label>
                                    <div class="w-full bg-gray-100 border-1.5 border-brand-accent/30 rounded-xl px-4 py-2.5 text-sm text-gray-600 font-medium cursor-not-allowed uppercase">
                                        {{ $invitation->status }}
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">*Status mutlak hak akses Admin.</p>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-brand-dark mb-2 text-sm">Musik Latar (MP3/WAV)</label>
                                    <div class="flex items-center gap-3 mb-2">
                                        <audio id="audio-preview" controls class="w-full h-10" style="border-radius: 0.75rem;">
                                            <source id="audio-source" src="{{ $invitation->music_url }}" type="audio/mpeg">
                                            Browser Anda tidak mendukung elemen audio.
                                        </audio>
                                    </div>
                                    <input type="file" id="music_file" name="music_file" accept=".mp3,.wav,audio/*" class="w-full bg-white border-1.5 border-brand-accent/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none">
                                    <p class="text-[11px] text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti lagu. (Maks 10MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan: Toggle Fitur -->
                    <div class="space-y-6">
                        <div class="bg-brand-bg/50 p-5 rounded-2xl border border-brand-accent/20 h-full">
                            <h4 class="font-semibold text-brand-dark mb-4 text-md flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                Modul & Fitur
                            </h4>
                            
                            <div class="space-y-4 mt-6">
                                <!-- Toggle Galeri -->
                                <label class="flex items-center justify-between cursor-pointer p-3 hover:bg-brand-accent/5 rounded-xl transition-colors">
                                    <div>
                                        <span class="block font-semibold text-brand-dark text-sm">Galeri Foto</span>
                                        <span class="block text-xs text-gray-500">Tampilkan album foto pre-wedding Anda.</span>
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" name="is_galeri_aktif" class="sr-only" {{ $invitation->is_galeri_aktif ? 'checked' : '' }}>
                                        <div class="block bg-gray-200 w-12 h-7 rounded-full transition-colors duration-300 toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition transform duration-300"></div>
                                    </div>
                                </label>

                                <!-- Toggle Cerita Cinta -->
                                <label class="flex items-center justify-between cursor-pointer p-3 hover:bg-brand-accent/5 rounded-xl transition-colors">
                                    <div>
                                        <span class="block font-semibold text-brand-dark text-sm">Cerita Cinta</span>
                                        <span class="block text-xs text-gray-500">Tampilkan linimasa perjalanan cinta Anda.</span>
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" name="is_cerita_aktif" class="sr-only" {{ $invitation->is_cerita_aktif ? 'checked' : '' }}>
                                        <div class="block bg-gray-200 w-12 h-7 rounded-full transition-colors duration-300 toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition transform duration-300"></div>
                                    </div>
                                </label>

                                <!-- Toggle Kado Digital -->
                                <label class="flex items-center justify-between cursor-pointer p-3 hover:bg-brand-accent/5 rounded-xl transition-colors">
                                    <div>
                                        <span class="block font-semibold text-brand-dark text-sm">Kado Digital</span>
                                        <span class="block text-xs text-gray-500">Aktifkan rekening / e-wallet untuk hadiah.</span>
                                    </div>
                                    <div class="relative">
                                        <input type="checkbox" name="is_kado_aktif" class="sr-only" {{ $invitation->is_kado_aktif ? 'checked' : '' }}>
                                        <div class="block bg-gray-200 w-12 h-7 rounded-full transition-colors duration-300 toggle-bg"></div>
                                        <div class="dot absolute left-1 top-1 bg-white w-5 h-5 rounded-full transition transform duration-300"></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="text-sm w-full md:w-auto break-all">
                        <span class="text-gray-500 block mb-1">Lihat undangan publik: </span>
                        <a href="{{ route('public.invitation', $invitation->slug) }}" target="_blank" class="font-semibold text-brand-accent hover:underline">
                            {{ route('public.invitation', $invitation->slug) }}
                        </a>
                    </div>
                    <button type="submit" id="btn-save-pengaturan" class="w-full md:w-auto bg-gradient-to-br from-brand-accent to-brand-accent-dark hover:from-brand-accent-dark hover:to-[#a28056] text-white font-semibold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(197,168,128,0.3)] hover:shadow-[0_6px_20px_rgba(197,168,128,0.4)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Custom Toggle CSS */
    input:checked ~ .dot {
        transform: translateX(100%);
    }
    input:checked ~ .toggle-bg {
        background-color: #0a2214; /* brand-dark */
    }
</style>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#form-pengaturan').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btn-save-pengaturan');
            var originalText = btn.html();
            
            btn.html('<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...').prop('disabled', true);
            
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('client.pengaturan.update') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    btn.html(originalText).prop('disabled', false);
                    
                    if(response.slug) {
                        $('#preview-link').html('Lihat undangan publik: <a href="/' + response.slug + '" target="_blank" class="text-brand-dark font-bold hover:underline">' + window.location.origin + '/' + response.slug + '</a>');
                    }

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Pengaturan berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            popup: 'border-l-4 border-green-500 rounded-lg shadow-lg'
                        }
                    });
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    let errorMsg = 'Gagal menyimpan pengaturan.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let firstError = Object.values(errors)[0][0];
                        errorMsg = firstError;
                        if (firstError.includes('max')) {
                            errorMsg = 'Ukuran file lagu terlalu besar (Maks 10MB).';
                        } else if (firstError.includes('mimes')) {
                            errorMsg = 'Format lagu tidak didukung. Harap unggah MP3 atau WAV.';
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMsg
                    });
                }
            });
        });

        // Audio preview updater
        $('#music_file').on('change', function(e) {
            if (this.files && this.files[0]) {
                var file = this.files[0];
                var objectUrl = URL.createObjectURL(file);
                
                var audioPreview = document.getElementById('audio-preview');
                var audioSource = document.getElementById('audio-source');
                
                // Stop current audio if playing
                audioPreview.pause();
                
                // Update source and load
                audioSource.src = objectUrl;
                audioPreview.load(); // Reload the new source
            }
        });
    });
</script>
@endpush
