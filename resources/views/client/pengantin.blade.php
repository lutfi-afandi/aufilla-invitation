@extends('layouts.client')

@section('title', 'Data Pengantin - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    
    @include('client.partials.tab_navigation')

    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden relative">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Data Mempelai</h3>
        </div>
        
        <!-- Card Body -->
        <div class="p-7">
            <form id="form-pengantin" enctype="multipart/form-data">
                @csrf
                
                <!-- Hero / Cover Image Section -->
                <div class="mb-10">
                    <h4 class="font-semibold text-brand-dark border-b border-gray-100 pb-3 text-lg mb-5" style="font-family: 'Playfair Display', serif;">Foto Utama (Hero Cover)</h4>
                    <div class="flex flex-col md:flex-row items-start gap-6">
                        <div class="w-full md:w-1/3 aspect-[4/3] rounded-xl overflow-hidden bg-gray-100 border-2 border-dashed border-brand-accent/30 relative group">
                            <img id="preview_cover" src="{{ $invitation->cover_img ? asset('storage/' . $invitation->cover_img) : asset('themes/aufilla-green/images/bg-hero.svg') }}" class="w-full h-full object-cover" alt="Cover Preview">
                            <label for="cover_img" class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-sm font-medium">Ubah Cover</span>
                            </label>
                            <input type="file" id="cover_img" name="cover_img" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_cover')">
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-500 mb-2">Foto Utama ini akan ditampilkan secara penuh (layar penuh) pada bagian pertama undangan digital Anda.</p>
                            <ul class="text-xs text-gray-400 list-disc list-inside space-y-1">
                                <li>Rekomendasi rasio: 3:4 atau vertikal (Potret)</li>
                                <li>Maksimal ukuran file: 6MB</li>
                                <li>Format yang diizinkan: JPG, PNG</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mempelai Pria -->
                    <div class="space-y-5">
                        <h4 class="font-semibold text-brand-dark border-b border-gray-100 pb-3 text-lg flex items-center justify-between" style="font-family: 'Playfair Display', serif;">
                            Mempelai Pria
                        </h4>
                        
                        <!-- Foto Pria -->
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 border-4 border-white shadow-md relative group mb-3">
                                <img id="preview_pria" src="{{ $invitation->pria_foto ? asset('storage/' . $invitation->pria_foto) : asset('themes/aufilla-green/images/groom.png') }}" class="w-full h-full object-cover" alt="Foto Pria">
                                <label for="pria_foto" class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    <span class="text-[10px] font-medium">Ubah Foto</span>
                                </label>
                                <input type="file" id="pria_foto" name="pria_foto" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_pria')">
                            </div>
                            <span class="text-xs text-gray-500">Rekomendasi rasio 1:1 (Persegi)</span>
                        </div>

                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Panggilan</label>
                            <input type="text" name="pria_nama" value="{{ $invitation->pria_nama }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Bima">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Lengkap</label>
                            <input type="text" name="pria_nama_lengkap" value="{{ $invitation->pria_nama_lengkap }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Bima Saputra">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Ayah</label>
                            <input type="text" name="pria_ayah" value="{{ $invitation->pria_ayah }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Bapak ...">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Ibu</label>
                            <input type="text" name="pria_ibu" value="{{ $invitation->pria_ibu }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Ibu ...">
                        </div>
                    </div>
                    
                    <!-- Mempelai Wanita -->
                    <div class="space-y-5">
                        <h4 class="font-semibold text-brand-dark border-b border-gray-100 pb-3 text-lg flex items-center justify-between" style="font-family: 'Playfair Display', serif;">
                            Mempelai Wanita
                        </h4>
                        
                        <!-- Foto Wanita -->
                        <div class="flex flex-col items-center mb-6">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 border-4 border-white shadow-md relative group mb-3">
                                <img id="preview_wanita" src="{{ $invitation->wanita_foto ? asset('storage/' . $invitation->wanita_foto) : asset('themes/aufilla-green/images/bride.png') }}" class="w-full h-full object-cover" alt="Foto Wanita">
                                <label for="wanita_foto" class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center text-white opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity">
                                    <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                    <span class="text-[10px] font-medium">Ubah Foto</span>
                                </label>
                                <input type="file" id="wanita_foto" name="wanita_foto" class="hidden" accept="image/*" onchange="previewImage(this, 'preview_wanita')">
                            </div>
                            <span class="text-xs text-gray-500">Rekomendasi rasio 1:1 (Persegi)</span>
                        </div>

                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Panggilan</label>
                            <input type="text" name="wanita_nama" value="{{ $invitation->wanita_nama }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Ayu">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Lengkap</label>
                            <input type="text" name="wanita_nama_lengkap" value="{{ $invitation->wanita_nama_lengkap }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Ayu Lestari">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Ayah</label>
                            <input type="text" name="wanita_ayah" value="{{ $invitation->wanita_ayah }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Bapak ...">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Ibu</label>
                            <input type="text" name="wanita_ibu" value="{{ $invitation->wanita_ibu }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Ibu ...">
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <button type="submit" id="btn-save-pengantin" class="bg-gradient-to-br from-brand-accent to-brand-accent-dark hover:from-brand-accent-dark hover:to-[#a28056] text-white font-semibold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(197,168,128,0.3)] hover:shadow-[0_6px_20px_rgba(197,168,128,0.4)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#form-pengantin').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btn-save-pengantin');
            var originalText = btn.html();
            
            btn.html('<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...').prop('disabled', true);
            
            var formData = new FormData(this);
            
            $.ajax({
                url: "{{ route('client.mempelai.update') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data pengantin berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            popup: 'border-l-4 border-green-500 rounded-lg shadow-lg'
                        }
                    });
                    // Remove "Belum Disimpan" badges
                    $('.unsaved-badge').remove();
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    let errorMsg = 'Gagal menyimpan data. Silakan coba lagi.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        let firstError = Object.values(errors)[0][0];
                        if (firstError.includes('mimes') || firstError.includes('image')) {
                            errorMsg = 'Format file tidak valid. Harap unggah file gambar (JPG, PNG, WEBP).';
                        } else if (firstError.includes('max')) {
                            errorMsg = 'Ukuran gambar terlalu besar. Maksimal 6MB.';
                        } else {
                            errorMsg = firstError;
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
    });

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('#' + previewId).attr('src', e.target.result);
                
                // Tambahkan badge "Belum Disimpan" jika belum ada
                if ($('#badge-' + previewId).length === 0) {
                    $('#' + previewId).parent().append('<div id="badge-' + previewId + '" class="unsaved-badge absolute top-2 right-2 bg-amber-500 text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full shadow-md z-20 animate-pulse border border-white/50">Belum Disimpan</div>');
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
