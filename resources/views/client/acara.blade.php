@extends('layouts.client')

@section('title', 'Data Acara - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    
    @include('client.partials.tab_navigation')

    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Detail Acara</h3>
        </div>
        
        <!-- Card Body -->
        <div class="p-7">
            <form id="form-acara">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Akad Nikah -->
                    <div class="space-y-5 bg-brand-light/5 p-6 rounded-2xl border border-brand-light/20 relative">
                        <!-- Badge/Icon -->
                        <div class="absolute -top-4 -left-4 w-12 h-12 bg-brand-dark text-white rounded-2xl flex items-center justify-center shadow-lg transform rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="font-semibold text-brand-dark border-b border-brand-light/20 pb-3 text-lg pl-6" style="font-family: 'Playfair Display', serif;">Akad Nikah / Pemberkatan</h4>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Tanggal Acara</label>
                            <input type="date" name="akad_tgl" value="{{ optional($akad)->tgl_acara ? $akad->tgl_acara->format('Y-m-d') : '' }}" class="w-full bg-white border-1.5 border-brand-light/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-dark focus:ring-4 focus:ring-brand-dark/10 transition-all outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-brand-dark mb-2 text-sm">Waktu Mulai</label>
                                <input type="time" name="akad_mulai" value="{{ optional($akad)->waktu_mulai ? \Carbon\Carbon::parse($akad->waktu_mulai)->format('H:i') : '' }}" class="w-full bg-white border-1.5 border-brand-light/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-dark focus:ring-4 focus:ring-brand-dark/10 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-brand-dark mb-2 text-sm">Waktu Selesai</label>
                                <input type="time" name="akad_selesai" value="{{ optional($akad)->waktu_selesai ? \Carbon\Carbon::parse($akad->waktu_selesai)->format('H:i') : '' }}" class="w-full bg-white border-1.5 border-brand-light/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-dark focus:ring-4 focus:ring-brand-dark/10 transition-all outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Lokasi / Gedung</label>
                            <input type="text" name="akad_lokasi" value="{{ optional($akad)->lokasi }}" class="w-full bg-white border-1.5 border-brand-light/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-dark focus:ring-4 focus:ring-brand-dark/10 transition-all outline-none" placeholder="Contoh: Masjid Agung / Gereja / Hotel ABC">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Alamat Lengkap</label>
                            <textarea name="akad_alamat" rows="2" class="w-full bg-white border-1.5 border-brand-light/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-dark focus:ring-4 focus:ring-brand-dark/10 transition-all outline-none" placeholder="Alamat lengkap acara">{{ optional($akad)->alamat }}</textarea>
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Link Google Maps (URL)</label>
                            <input type="url" name="akad_gmaps" value="{{ optional($akad)->gmaps_link }}" class="w-full bg-white border-1.5 border-brand-light/30 rounded-xl px-4 py-2.5 text-sm focus:border-brand-dark focus:ring-4 focus:ring-brand-dark/10 transition-all outline-none" placeholder="https://maps.google.com/...">
                        </div>
                    </div>
                    
                    <!-- Resepsi -->
                    <div class="space-y-5 bg-brand-accent/5 p-6 rounded-2xl border border-brand-accent/30 relative">
                        <!-- Badge/Icon -->
                        <div class="absolute -top-4 -left-4 w-12 h-12 bg-gradient-to-br from-brand-accent to-brand-accent-dark text-white rounded-2xl flex items-center justify-center shadow-lg transform -rotate-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                        </div>
                        <h4 class="font-semibold text-brand-accent-dark border-b border-brand-accent/30 pb-3 text-lg pl-6" style="font-family: 'Playfair Display', serif;">Resepsi Perayaan</h4>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Tanggal Acara</label>
                            <input type="date" name="resepsi_tgl" value="{{ optional($resepsi)->tgl_acara ? $resepsi->tgl_acara->format('Y-m-d') : '' }}" class="w-full bg-white border-1.5 border-brand-accent/40 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-brand-dark mb-2 text-sm">Waktu Mulai</label>
                                <input type="time" name="resepsi_mulai" value="{{ optional($resepsi)->waktu_mulai ? \Carbon\Carbon::parse($resepsi->waktu_mulai)->format('H:i') : '' }}" class="w-full bg-white border-1.5 border-brand-accent/40 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none">
                            </div>
                            <div>
                                <label class="block font-medium text-brand-dark mb-2 text-sm">Waktu Selesai</label>
                                <input type="time" name="resepsi_selesai" value="{{ optional($resepsi)->waktu_selesai ? \Carbon\Carbon::parse($resepsi->waktu_selesai)->format('H:i') : '' }}" class="w-full bg-white border-1.5 border-brand-accent/40 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none">
                            </div>
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Lokasi / Gedung</label>
                            <input type="text" name="resepsi_lokasi" value="{{ optional($resepsi)->lokasi }}" class="w-full bg-white border-1.5 border-brand-accent/40 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Contoh: Hotel ABC">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Alamat Lengkap</label>
                            <textarea name="resepsi_alamat" rows="2" class="w-full bg-white border-1.5 border-brand-accent/40 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="Alamat lengkap acara">{{ optional($resepsi)->alamat }}</textarea>
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Link Google Maps (URL)</label>
                            <input type="url" name="resepsi_gmaps" value="{{ optional($resepsi)->gmaps_link }}" class="w-full bg-white border-1.5 border-brand-accent/40 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/20 transition-all outline-none" placeholder="https://maps.google.com/...">
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end">
                    <button type="submit" id="btn-save-acara" class="bg-gradient-to-br from-brand-accent to-brand-accent-dark hover:from-brand-accent-dark hover:to-[#a28056] text-white font-semibold py-2.5 px-6 rounded-xl shadow-[0_4px_15px_rgba(197,168,128,0.3)] hover:shadow-[0_6px_20px_rgba(197,168,128,0.4)] transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Data Acara
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
        $('#form-acara').on('submit', function(e) {
            e.preventDefault();
            var btn = $('#btn-save-acara');
            var originalText = btn.html();
            
            btn.html('<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyimpan...').prop('disabled', true);
            
            $.ajax({
                url: "{{ route('client.acara.update') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data acara berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 3000,
                        customClass: {
                            popup: 'border-l-4 border-green-500 rounded-lg shadow-lg'
                        }
                    });
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    let errMsg = 'Gagal menyimpan data. Pastikan format URL/tanggal benar.';
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
