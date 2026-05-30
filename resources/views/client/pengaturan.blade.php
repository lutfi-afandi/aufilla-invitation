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
            <form id="form-pengaturan">
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
                                    <select name="status" class="w-full bg-white border-1.5 border-brand-accent/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none">
                                        <option value="draft" {{ $invitation->status == 'draft' ? 'selected' : '' }}>Draft (Hanya Anda)</option>
                                        <option value="trial" {{ $invitation->status == 'trial' ? 'selected' : '' }}>Trial (Bisa diakses publik)</option>
                                        <option value="aktif" {{ $invitation->status == 'aktif' ? 'selected' : '' }}>Aktif Premium</option>
                                        <option value="nonaktif" {{ $invitation->status == 'nonaktif' ? 'selected' : '' }}>Nonaktifkan</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block font-medium text-brand-dark mb-2 text-sm">URL Musik Latar (MP3)</label>
                                    <input type="url" name="music_file" value="{{ $invitation->music_file }}" class="w-full bg-white border-1.5 border-brand-accent/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="https://example.com/song.mp3">
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
                
                <div class="mt-8 flex justify-between items-center pt-5 border-t border-brand-accent/10">
                    <div id="preview-link" class="text-sm">
                        @if($invitation->slug)
                            Lihat undangan publik: <a href="{{ url('/' . $invitation->slug) }}" target="_blank" class="text-brand-dark font-bold hover:underline">{{ url('/' . $invitation->slug) }}</a>
                        @endif
                    </div>
                    <button type="submit" id="btn-save-pengaturan" class="bg-gradient-to-br from-brand-accent to-brand-accent-dark hover:from-brand-accent-dark hover:to-[#a28056] text-white font-semibold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(197,168,128,0.3)] hover:shadow-[0_6px_20px_rgba(197,168,128,0.4)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
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
            
            $.ajax({
                url: "{{ route('client.pengaturan.update') }}",
                method: "POST",
                data: $(this).serialize(),
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
                    let errMsg = 'Gagal menyimpan data.';
                    if(xhr.responseJSON && xhr.responseJSON.errors) {
                        errMsg = Object.values(xhr.responseJSON.errors)[0][0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errMsg
                    });
                }
            });
        });
    });
</script>
@endpush
