@extends('layouts.client')

@section('title', 'Panduan Penggunaan - Aufilla Invitation')

@section('content')
<div class="max-w-5xl mx-auto w-full space-y-6">
    
    <!-- Header -->
    <div class="bg-gradient-to-br from-brand-dark to-[#1d3226] rounded-[20px] p-8 md:p-10 shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 blur-2xl"></div>
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold mb-3" style="font-family: 'Playfair Display', serif;">Panduan Penggunaan</h1>
            <p class="text-white/80 text-lg max-w-2xl">Selamat datang di Panel Klien Aufilla Invitation. Berikut adalah panduan lengkap cara mengatur undangan pernikahan Anda hingga siap disebarkan.</p>
        </div>
    </div>

    <!-- 1. Persiapan Undangan -->
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-accent/15 bg-gray-50/50 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">1</div>
            <h3 class="text-xl font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Persiapan Data Undangan</h3>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            
            <div class="flex gap-4 items-start">
                <div class="mt-1"><svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Mengisi Data Mempelai & Acara</h4>
                    <p class="text-gray-600 leading-relaxed mb-3">Langkah pertama yang wajib Anda lakukan adalah masuk ke menu <strong>Kelola Undangan</strong>. Isi secara berurutan mulai dari tab Pengantin hingga Acara.</p>
                    <ul class="list-disc pl-5 text-gray-600 space-y-1 text-sm">
                        <li>Gunakan foto yang cerah dan tajam.</li>
                        <li>Pastikan link Google Maps pada bagian Acara sudah benar agar tamu tidak tersasar.</li>
                    </ul>
                </div>
            </div>

            <div class="flex gap-4 items-start">
                <div class="mt-1"><svg class="w-6 h-6 text-brand-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Menambahkan Galeri & Cerita (Opsional)</h4>
                    <p class="text-gray-600 leading-relaxed">Anda dapat menambahkan foto-foto *pre-wedding* di menu Galeri. Jika Anda memiliki kisah cinta yang menarik, tuangkan cerita tersebut di menu Cerita Cinta secara kronologis.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- 2. Buku Tamu & WhatsApp -->
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-accent/15 bg-gray-50/50 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center font-bold text-lg">2</div>
            <h3 class="text-xl font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Manajemen Tamu & WhatsApp</h3>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            
            <div class="flex gap-4 items-start">
                <div class="mt-1"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Menambahkan Daftar Tamu</h4>
                    <p class="text-gray-600 leading-relaxed mb-3">Masuk ke menu <strong>Buku Tamu</strong>. Anda bisa menambahkan tamu satu per satu secara manual, atau menggunakan fitur <strong>Import Excel</strong> agar lebih cepat (Unduh template Excel yang kami sediakan di dalam menu Import).</p>
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm p-4 rounded-xl">
                        <strong>Penting:</strong> Nomor WA tamu harus diisi dengan angka penuh (Contoh: 08123456789 atau 628123456789).
                    </div>
                </div>
            </div>

            <div class="flex gap-4 items-start">
                <div class="mt-1"><svg class="w-6 h-6 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Menyebarkan Undangan via WhatsApp</h4>
                    <p class="text-gray-600 leading-relaxed mb-3">Klik tombol <strong>Pesan WA</strong> di atas tabel tamu untuk merangkai kalimat *template* undangan Anda. Gunakan kode <code>[nama_tamu]</code> agar sistem otomatis menggantinya dengan nama setiap tamu.</p>
                    <p class="text-gray-600 leading-relaxed">Setelah *template* disimpan, Anda tinggal mengklik ikon logo WhatsApp berwarna hijau di sebelah kanan nama setiap tamu untuk langsung mengirim pesannya secara personal!</p>
                </div>
            </div>

        </div>
    </div>

    <!-- 3. Hari H (Resepsionis) -->
    <div class="bg-white border border-brand-accent/15 rounded-[20px] shadow-[0_10px_30px_rgba(10,34,20,0.03)] overflow-hidden">
        <div class="px-6 py-5 border-b border-brand-accent/15 bg-gray-50/50 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-lg">3</div>
            <h3 class="text-xl font-bold text-brand-dark" style="font-family: 'Playfair Display', serif;">Penerimaan Tamu di Hari H</h3>
        </div>
        <div class="p-6 md:p-8 space-y-6">
            
            <div class="flex gap-4 items-start">
                <div class="mt-1"><svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Memberikan Akses ke Resepsionis Pintu Masuk</h4>
                    <p class="text-gray-600 leading-relaxed mb-3">Pada hari H, pihak Resepsionis (Penerima Tamu) akan melakukan *Check-in* menggunakan alat *Barcode Scanner*, HP (Kamera), ataupun mengetik nama manual.</p>
                    <div class="bg-blue-50 border border-blue-200 text-blue-800 text-sm p-4 rounded-xl">
                        Akses khusus Resepsionis dapat diberikan oleh Tim Admin kami. Resepsionis akan memiliki *username* dan *password* tersendiri untuk masuk ke sistem tanpa bisa mengubah data undangan Anda.
                    </div>
                </div>
            </div>

            <div class="flex gap-4 items-start">
                <div class="mt-1"><svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                <div>
                    <h4 class="text-lg font-semibold text-gray-800 mb-2">Layar Ganda (Welcome Screen)</h4>
                    <p class="text-gray-600 leading-relaxed mb-3">Agar pernikahan terlihat lebih mewah, resepsionis dapat mengklik tombol <strong>"Buka Layar Penyambutan"</strong>. Layar ini bisa dihubungkan ke Monitor Eksternal (TV/Proyektor) yang menghadap ke arah tamu.</p>
                    <p class="text-gray-600 leading-relaxed">Setiap kali ada tamu yang melakukan *Check-in*, layar monitor tersebut akan otomatis memunculkan nama tamu disertai suara bel masuk dan animasi selamat datang yang elegan.</p>
                </div>
            </div>

        </div>
    </div>

    <!-- 4. Support -->
    <div class="bg-brand-dark rounded-[20px] p-6 md:p-8 text-center text-white mt-8 mb-4">
        <h3 class="text-xl font-bold mb-2">Butuh Bantuan Lebih Lanjut?</h3>
        <p class="text-white/70 mb-5">Tim Aufilla Invitation selalu siap membantu kelancaran persiapan acara Anda.</p>
        <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#1EBE5D] text-white px-6 py-3 rounded-xl font-semibold transition-all shadow-lg hover:shadow-[#25D366]/30">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Hubungi Admin
        </a>
    </div>

</div>
@endsection
