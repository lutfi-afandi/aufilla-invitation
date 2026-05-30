@extends('layouts.client')

@section('title', 'Data Pengantin - Aufilla Invitation')

@section('content')
<div class="max-w-7xl mx-auto w-full">
    
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-brand-dark/5 to-transparent border-b border-brand-accent/15 px-7 py-5">
            <h3 class="text-[1.15rem] font-semibold text-brand-dark" style="font-family: 'Playfair Display', serif;">Data Mempelai</h3>
        </div>
        
        <!-- Card Body -->
        <div class="p-7">
            <form id="form-pengantin">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mempelai Pria -->
                    <div class="space-y-5">
                        <h4 class="font-semibold text-brand-dark border-b border-gray-100 pb-3 text-lg" style="font-family: 'Playfair Display', serif;">Mempelai Pria</h4>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Panggilan</label>
                            <input type="text" name="pria_nama" value="{{ $invitation->pria_nama }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Romeo">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Lengkap</label>
                            <input type="text" name="pria_nama_lengkap" value="{{ $invitation->pria_nama_lengkap }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Romeo Montague">
                        </div>
                    </div>
                    
                    <!-- Mempelai Wanita -->
                    <div class="space-y-5">
                        <h4 class="font-semibold text-brand-dark border-b border-gray-100 pb-3 text-lg" style="font-family: 'Playfair Display', serif;">Mempelai Wanita</h4>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Panggilan</label>
                            <input type="text" name="wanita_nama" value="{{ $invitation->wanita_nama }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Juliet">
                        </div>
                        <div>
                            <label class="block font-medium text-brand-dark mb-2 text-sm">Nama Lengkap</label>
                            <input type="text" name="wanita_nama_lengkap" value="{{ $invitation->wanita_nama_lengkap }}" class="w-full border-1.5 border-brand-accent/20 rounded-xl px-4 py-2.5 text-sm focus:border-brand-accent focus:ring-4 focus:ring-brand-accent/15 transition-all outline-none" placeholder="Contoh: Juliet Capulet">
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
            
            $.ajax({
                url: "{{ route('client.mempelai.update') }}",
                method: "POST",
                data: $(this).serialize(),
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
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Gagal menyimpan data. Silakan coba lagi.'
                    });
                }
            });
        });
    });
</script>
@endpush
