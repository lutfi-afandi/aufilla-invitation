# 📋 Form Kendali Mutu & Testing QA (Quality Assurance Control Sheet)
## Aufilla Invitation v2 — End-to-End System Testing Guide

Dokumen ini disusun sebagai panduan pengujian independen dan kendali mutu (*Quality Assurance*) untuk sistem **Aufilla Invitation v2**. Digunakan oleh Tester / QA / Owner untuk melakukan verifikasi manual seluruh alur proses bisnis, proteksi paket, serta integritas fitur.

---

### 📝 Informasi Pengujian
- **Tanggal Pengujian**: `[ Diisi oleh Tester ]`
- **Nama Tester**: `[ Diisi oleh Tester ]`
- **Versi Aplikasi**: `v2.0-Production-Ready`
- **Lingkungan Pengujian**: `[ Localhost / Staging / Production ]`

---

## 📌 RANGKUMAN INDIKATOR STATUS PENGUJIAN
- `[ ] PASS` : Fitur berjalan 100% sesuai alur bisnis tanpa error.
- `[ ] FAIL` : Terjadi bug, error 500, salah logika, atau masalah visual.
- `[ ] N/A`  : Tidak diuji / Tidak berlaku.

---

## 1. 🌐 LANDING PAGE & REGISTRASI MANDIRI (PUBLIC & AUTH)

| No | Kasus Uji (Test Case) | Langkah Pengujian (Steps) | Hasil yang Diharapkan (Expected Result) | Status | Catatan / Temuan |
|:--:|:----------------------|:--------------------------|:----------------------------------------|:------:|:-----------------|
| **1.1** | Navigation & Smooth Scroll | Klik menu Navbar: Home, Fitur, Katalog Tema, Harga. | Halaman melakukan scroll halus (*smooth scroll*) ke section target tanpa lag. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.2** | Preview Tema dari Katalog | Klik tombol **Preview** pada salah satu tema di Katalog Tema. | Membuka tab baru URL `/preview/theme/{theme_code}` berisi tampilan dummy lengkap. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.3** | Pilih Tema & Modal Register | Klik tombol **Coba** pada salah satu tema di Katalog Tema. | Modal register terbuka dan nama tema yang dipilih langsung terpasang sebagai pilihan awal. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.4** | Form Register: Pemisahan Input | Buka Modal Register. Periksa input **Username Login** dan **URL Slug Undangan**. | Input **Username Login** dan **URL Slug Undangan** terpisah dalam 2 kolom yang jelas. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.5** | Auto-Sync Username ke Slug | Ketik `bimaayu` di kolom **Username Login**. | Kolom **URL Slug Undangan** otomatis terisi `bimaayu` dan preview URL `domain.com/bimaayu` muncul. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.6** | Custom Slug Mandiri | Ubah kolom **URL Slug Undangan** menjadi `bima-dan-ayu`. | Kolom Username tetap `bimaayu`, sementara URL Slug menjadi `bima-dan-ayu`. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.7** | AJAX Validation Keunikan Slug | Ketik Username/Slug yang sudah ada di database (misal `admin` atau `demo`). | Pesan peringatan merah "Username/URL ini tidak bisa digunakan" muncul & tombol **Daftar** di-disable. | `[ ] PASS`<br>`[ ] FAIL` | |
| **1.8** | Submit Register & Direct Access | Isi email, password, lalu klik **Daftar Sekarang**. | Akun terbuat di DB, `email_verified_at` otomatis terisi, dan pengguna **langsung masuk ke Panel Dashboard Klien** (`/client/dashboard`) tanpa tertahan verifikasi email. | `[ ] PASS`<br>`[ ] FAIL` | |

---

## 2. 🛡️ PANEL ADMIN (ADMINISTRATION CONTROL)

| No | Kasus Uji (Test Case) | Langkah Pengujian (Steps) | Hasil yang Diharapkan (Expected Result) | Status | Catatan / Temuan |
|:--:|:----------------------|:--------------------------|:----------------------------------------|:------:|:-----------------|
| **2.1** | DataTables Klien | Masuk ke menu **Admin > Manajemen Klien**. | Tabel Klien menggunakan DataTables lokal (pencarian instan, urutan kolom, dan pagination berfungsi cepat tanpa reload). | `[ ] PASS`<br>`[ ] FAIL` | |
| **2.2** | Kolom Username vs Link Slug | Periksa struktur kolom pada Tabel Klien. | Kolom **Username** (nama akun login) dan **Link Slug** (URL undangan `/[slug]`) tampil terpisah dengan jelas. | `[ ] PASS`<br>`[ ] FAIL` | |
| **2.3** | Tambah Klien Manual via Admin | Klik tombol **+ Tambah Klien**, isi Username `klienbaru`, URL Slug `pernikahan-klien`, Email, Password, Tema, & Paket. Klik Simpan. | Klien baru berhasil dibuat. Tautan URL `domain.com/pernikahan-klien` dapat diakses, dan login akun `klienbaru` berfungsi. | `[ ] PASS`<br>`[ ] FAIL` | |
| **2.4** | Edit Klien via Admin | Klik tombol **Edit** pada salah satu klien. Ubah Paket/Masa Aktif/Slug. Klik Simpan. | Data klien dan undangan terbarui di DB tanpa mengubah password jika dikosongkan. | `[ ] PASS`<br>`[ ] FAIL` | |
| **2.5** | Impersonate Session | Klik ikon **Impersonate** (Masuk Akun) di aksi tabel klien. | Admin langsung masuk ke Dashboard Klien yang bersangkutan. Bar pengingat "Mode Impersonate" muncul di atas halaman dengan tombol **Kembali ke Admin**. | `[ ] PASS`<br>`[ ] FAIL` | |
| **2.6** | Manajemen Tema Admin | Buka menu **Admin > Katalog Tema**. Tambah/Edit tema, toggle status aktif. | Tema aktif/nonaktif tersimpan. File thumbnail lokal tersimpan di `public/storage/`. | `[ ] PASS`<br>`[ ] FAIL` | |
| **2.7** | Manajemen Paket Admin | Buka menu **Admin > Paket**. Ubah harga, masa aktif (hari), kuota foto galeri, kuota kirim WA, dan toggle fitur Cerita Cinta/Musik Kustom. | Aturan paket tersimpan dan langsung berdampak pada batasan fitur klien di paket tersebut. | `[ ] PASS`<br>`[ ] FAIL` | |

---

## 3. 💒 PANEL KLIEN (CLIENT MANAGEMENT & FITUR PAKET)

| No | Kasus Uji (Test Case) | Langkah Pengujian (Steps) | Hasil yang Diharapkan (Expected Result) | Status | Catatan / Temuan |
|:--:|:----------------------|:--------------------------|:----------------------------------------|:------:|:-----------------|
| **3.1** | Form Pengantin / Mempelai | Buka **Informasi Pengantin**. Isi nama pria/wanita, orang tua, dan upload foto pengantin/cover. Klik Simpan. | Foto terunggah ke folder `storage/pengantin/` dan data tersimpan tanpa error. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.2** | Form Acara (Akad & Resepsi) | Buka **Detail Acara**. Isi tanggal, jam mulai/selesai, lokasi, alamat, dan link Google Maps. Klik Simpan. | Data acara akad nikah & resepsi tersimpan dengan presisi. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.3** | Pengaturan Slug Mandiri | Buka **Pengaturan**. Ubah URL Slug dari `bima-ayu` menjadi `bima-ayu-wedding`. Klik Simpan. | URL Slug undangan terbarui. Link undangan di baris bawah halaman otomatis berubah menjadi `domain.com/bima-ayu-wedding`. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.4** | Pengaturan Musik Kustom (Filter Paket) | Cobalah unggah MP3 pada akun dengan **Paket Trial / Hemat** (fitur musik kustom dilarang). | Sistem menolak unggahan musik dengan pesan error 403 / peringatan "Fitur Musik Kustom tidak tersedia pada paket Anda". | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.5** | Pembatasan Kuota Galeri Foto | Unggah foto galeri hingga melebihi kuota paket (misal Paket Trial kuota 5 foto). Unggah foto ke-6. | Tombol upload terkunci / disabled dan pesan "Batas maksimal foto tercapai" muncul. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.6** | Filter Fitur Cerita Cinta | Buka menu **Cerita Cinta** pada akun paket yang tidak mendukung cerita cinta. | Halaman menampilkan pemberitahuan kunci fitur (Lock Feature Screen) dengan ajakan upgrade paket. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.7** | Manajemen Buku Tamu: Tambah Single | Buka menu **Buku Tamu**. Klik **+ Tambah**, isi Nama Tamu & No. WhatsApp. Klik Simpan. | Data tamu bertambah di tabel, kode QR unik (`QR-XXXXX`) terbuat otomatis. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.8** | Manajemen Buku Tamu: Import Excel | Klik tombol **Import**, unduh Template Excel, isi 5 data tamu, lalu upload file `.xlsx`. | 5 data tamu berhasil diimpor sekaligus ke dalam database. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.9** | Format Pesan WA & Track Kuota WA | Klik tombol **Pesan WA** pada salah satu tamu. | Aplikasi membuka WhatsApp Web/App dengan teks undangan tersusun rapi (`[nama_tamu]` dan `[link_undangan]` otomatis terisi). Jumlah counter WA di badge atas bertambah. | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.10**| Pembatasan Kuota Kirim WA | Kirim WA melebihi batas `max_wa_send` paket trial (misal 3x). Kirim pada tamu ke-4. | Sistem memblokir pengiriman dengan modal SweetAlert: "Kuota Kirim WA Habis. Silakan Upgrade Paket!". | `[ ] PASS`<br>`[ ] FAIL` | |
| **3.11**| Export Data Tamu | Klik tombol **Export**. | File `.xlsx` berisi seluruh daftar tamu, nomor WA, dan status pesan berhasil diunduh. | `[ ] PASS`<br>`[ ] FAIL` | |

---

## 4. 💌 TAMPILAN UNDANGAN PUBLIK (PUBLIC INVITATION & THEME ACCURACY)

| No | Kasus Uji (Test Case) | Langkah Pengujian (Steps) | Hasil yang Diharapkan (Expected Result) | Status | Catatan / Temuan |
|:--:|:----------------------|:--------------------------|:----------------------------------------|:------:|:-----------------|
| **4.1** | Akses URL Publik | Buka `domain.com/{slug}` di browser incognito / mobile. | Undangan terbuka sesuai tema yang dipilih klien, menampilkan nama pengantin, tanggal, dan lokasi. | `[ ] PASS`<br>`[ ] FAIL` | |
| **4.2** | Parameter Custom Nama Tamu | Buka `domain.com/{slug}?to=Bapak+Santoso`. | Teks pada sampul/cover undangan secara khusus menyapa **"Bapak Santoso"**. | `[ ] PASS`<br>`[ ] FAIL` | |
| **4.3** | Modal QR Code Tamu Spesial | Buka `domain.com/{slug}?to=Bapak+Santoso`. Klik tombol QR Code di bagian melayang. | Modal QR Code terbuka menampilkan gambar QR SVG dengan kode QR unik milik Bapak Santoso. | `[ ] PASS`<br>`[ ] FAIL` | |
| **4.4** | Pengiriman Ucapan & Doa | Pada section Ucapan & Doa, isi Nama, Kehadiran (Hadir/Tidak), dan Pesan Ucapan. Klik Kirim. | Ucapan langsung muncul di daftar ucapan secara otomatis (*real-time update*) tanpa reload halaman. | `[ ] PASS`<br>`[ ] FAIL` | |
| **4.5** | Pembatasan Modul Non-Aktif | Di Panel Klien, nonaktifkan toggle **Galeri Foto** & **Kado Digital**. Buka link undangan publik. | Section Galeri Foto dan Kado Digital **otomatis tersembunyi** dari halaman undangan publik. | `[ ] PASS`<br>`[ ] FAIL` | |
| **4.6** | Anti-Forced Dark Mode Meta Tag | Buka undangan di HP Android dengan Dark Mode aktif. | Skema warna undangan tetap bersih (latar putih/terang tidak terbalik menjadi hitam kusam). | `[ ] PASS`<br>`[ ] FAIL` | |

---

## 5. ⏰ SIMULASI MASA AKTIF & EXPIRED SYSTEM (TRIAL & CRONJOB)

| No | Kasus Uji (Test Case) | Langkah Pengujian (Steps) | Hasil yang Diharapkan (Expected Result) | Status | Catatan / Temuan |
|:--:|:----------------------|:--------------------------|:----------------------------------------|:------:|:-----------------|
| **5.1** | Pengujian Kedaluwarsa Otomatis (Cronjob) | **1.** Buka DB/Tinker, set `expired_at = 2026-08-01` pada undangan trial.<br>**2.** Jalankan CLI: `php artisan invitation:check-expired`. | Status undangan di database otomatis berubah dari `aktif` menjadi `kedaluwarsa`. Log tercatat di tabel `expired_logs`. | `[ ] PASS`<br>`[ ] FAIL` | |
| **5.2** | Akses Undangan Publik Kedaluwarsa | Buka link `domain.com/{slug}` untuk undangan yang sudah kedaluwarsa. | Aplikasi menampilkan halaman **403 Forbidden / Expired Banner**: "Masa aktif undangan ini telah habis. Silakan hubungi Pemilik/Admin". | `[ ] PASS`<br>`[ ] FAIL` | |
| **5.3** | Pembatasan Fitur Panel Klien Expired | Login ke Dashboard Klien yang undangannya kedaluwarsa. Cobalah buka menu Mempelai, Acara, Galeri, atau Tamu. | Middleware `CheckClientExpired` mengunci form edit / menampilkan peringatan bahwa akun sudah kedaluwarsa dan harus diperpanjang. | `[ ] PASS`<br>`[ ] FAIL` | |
| **5.4** | Perpanjangan Masa Aktif via Admin | Buka **Admin > Klien**. Edit klien kedaluwarsa, ubah Status menjadi `aktif` & simpan. | Undangan kembali aktif, `expired_at` bertambah sesuai hari paket, dan link undangan publik dapat diakses kembali. | `[ ] PASS`<br>`[ ] FAIL` | |

---

## 6. 📱 PANEL RESEPSIONIS (RECEPTIONIST & DUAL-SCREEN BUKU TAMU)

| No | Kasus Uji (Test Case) | Langkah Pengujian (Steps) | Hasil yang Diharapkan (Expected Result) | Status | Catatan / Temuan |
|:--:|:----------------------|:--------------------------|:----------------------------------------|:------:|:-----------------|
| **6.1** | Login Resepsionis | Login dengan akun role `resepsionis`. | Otomatis diarahkan ke `/receptionist/dashboard` (tidak bisa mengakses menu Admin/Klien). | `[ ] PASS`<br>`[ ] FAIL` | |
| **6.2** | Scanner QR Code Check-in | Buka scanner buku tamu, scan QR Code tamu (`QR-XXXXX`) melalui kamera HP/Webcam. | Sistem berhasil mengenali kode QR, mencatat jam kehadiran, dan menampilkan notifikasi "Tamu Berhasil Check-in". | `[ ] PASS`<br>`[ ] FAIL` | |
| **6.3** | Manual Check-in & Search | Ketik nama tamu di kolom pencarian manual buku tamu. Klik **Check-in**. | Status kehadiran tamu berubah menjadi "Hadir". | `[ ] PASS`<br>`[ ] FAIL` | |
| **6.4** | Welcome Screen (Dual Screen Display) | Buka Layar Sapaan (`/receptionist/welcome-screen/{id}`) di monitor/TV terpisah. Lakukan check-in tamu di monitor utama. | Layar sapaan secara instan menampilkan animasi ucapan selamat datang "Selamat Datang [Nama Tamu]" dengan efek suara/visual. | `[ ] PASS`<br>`[ ] FAIL` | |

---

## 📊 HASIL AKHIR EVALUASI QA
- **Total Kasus Uji**: 35 Test Cases
- **Jumlah PASS**: `___`
- **Jumlah FAIL**: `___`
- **Persentase Kelayakan**: `___ %`

### 💬 Kesimpulan & Rekomendasi Tester:
```text
[ Tuliskan ringkasan atau masukan untuk pengembang di sini ]
```
