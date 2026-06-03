# Panduan Pembuatan Tema Baru (Aufilla Invitation)

Aufilla menggunakan sistem **Tema Terisolasi (Total Isolation)**. Artinya, setiap tema memiliki *view* sendiri dan tidak saling berbagi tata letak (*layout*) atau kelas utilitas yang bisa bocor.

## 📁 Struktur Direktori Tema

Saat membuat tema baru, Anda harus membuatnya di dalam direktori `resources/views/themes/{nama_tema}/`.

Misal kita ingin membuat tema bernama **"classic"**:
```
resources/views/themes/classic/
├── index.blade.php          # File utama (meng-include partials)
├── partials/
│   ├── cover.blade.php      # Halaman pembuka undangan (Nama tamu, tombol Buka)
│   ├── hero.blade.php       # Salam pembuka & Nama Mempelai
│   ├── couple.blade.php     # Profil Mempelai Pria & Wanita
│   ├── events.blade.php     # Detail Acara (Akad, Resepsi) + Countdown & Maps
│   ├── gallery.blade.php    # Galeri Foto (Hanya tampil jika kuota galeri terpenuhi)
│   ├── love_story.blade.php # Cerita Cinta (Hanya tampil di paket Premium/VIP)
│   ├── rsvp.blade.php       # Form Kehadiran & Ucapan Tamu
│   └── footer.blade.php     # Penutup undangan
```

## 🛠️ Aturan Pengembangan Tema

### 1. Database & Registrasi Tema
Sebelum tema bisa dipilih, pastikan sudah dimasukkan ke dalam database melalui seeder atau panel Admin:
- Pastikan field `is_active` bernilai `true`.
- Catat ID atau *slug* tema yang akan dicocokkan dengan direktori folder.

### 2. Standar Desain Tema
- **Gunakan Tailwind CSS murni.** Tema harus responsif penuh (*mobile-first*). Undangan biasanya dilihat dari layar HP, jadi pastikan lebar maksimum kontainer dibatasi (misal `max-w-md mx-auto` untuk meniru tampilan *smartphone* di layar desktop).
- **Hindari Custom CSS berlebih.** Jika butuh animasi spesifik atau CSS khusus tema, bungkus dalam namespace/ID tema tersebut di *head* agar tidak bocor. Misal:
  ```html
  <style>
     .theme-classic .anim-fade { ... }
  </style>
  <body class="theme-classic">
  ```

### 3. Pengecekan Paket (Conditional Rendering)
Karena klien memiliki paket yang berbeda (Basic, Premium, VIP), tema **WAJIB** mengecek izin paket sebelum merender komponen tertentu:

```php
{{-- Contoh di index.blade.php tema --}}

@include('themes.classic.partials.hero')
@include('themes.classic.partials.couple')
@include('themes.classic.partials.events')

{{-- Hanya tampilkan Love Story jika paket klien memiliki izin --}}
@if($client->package->has_love_story && $client->loveStories->count() > 0)
    @include('themes.classic.partials.love_story')
@endif

{{-- Batasi foto Galeri sesuai kuota paket klien --}}
@if($client->galleries->count() > 0)
    @php
        $photos = $client->galleries->take($client->package->max_gallery_photos);
    @endphp
    @include('themes.classic.partials.gallery', ['photos' => $photos])
@endif
```

### 4. Integrasi Musik
Setiap tema harus menyertakan pemutar musik otomatis/manual dengan tombol putar/jeda (karena *autoplay* sering diblokir peramban modern). Klien di paket VIP ("Bebas Ganti Musik Lagu") bisa menggunakan musik *custom*, klien Basic menggunakan musik standar tema.
Tugas ini ditangani oleh variabel `$client->music_url`.

### 5. Komponen RSVP (Dynamic Form)
Form RSVP harus mengarah ke *endpoint* simpan RSVP klien (biasanya melalui AJAX/Axios) tanpa me-*reload* keseluruhan halaman agar pengalaman membaca undangan tidak terputus. Pastikan menyertakan *CSRF token*!

---
Ikuti panduan ini setiap kali men-generate tema baru untuk memastikan stabilitas dan kompatibilitas dengan ekosistem Aufilla.
