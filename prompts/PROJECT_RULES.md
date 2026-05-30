# ATURAN PROYEK (PROJECT RULES) - REVISI JQUERY

## Gambaran Proyek

Proyek ini adalah platform undangan digital premium berbasis *multi-tenant* ringan (menggunakan arsitektur *path subfolder*) yang dibangun menggunakan Laravel 12 dan MySQL.

Fase MVP (Minimum Viable Product) ini berfokus pada alur kerja efisien dengan memangkas biaya operasional (*Zero Cost Messaging*):
- Halaman utama (Landing page) yang memuat pratinjau tema (Demo preview).
- Sistem Trial 1 Hari (Registrasi otomatis dengan URL spesifik tema).
- Pemesanan paket & aktivasi undangan secara manual melalui WhatsApp (tanpa Payment Gateway).
- *Dashboard Admin* untuk kelola status Klien dan Master Tema.
- *Dashboard Klien* (Wizard) untuk kelola detail acara dan manajemen daftar tamu.
- Fitur *Greeting Wall* (RSVP & Ucapan).
- Generator link WhatsApp (API Manual) dari sisi Klien.

---

# Tumpukan Teknologi (Core Stack)

## Backend
- PHP 8.3
- Laravel 12
- MySQL

## Frontend
- Blade templating
- Tailwind CSS
- jQuery (Sebagai motor tunggal penanganan AJAX asinkron form dan interaksi DOM UI seperti Modal/Tab/Dropdown)

## Build Asset
- Vite

## Autentikasi
- Laravel Breeze (Dimodifikasi)

---

# Aturan Autentikasi & Routing

- Gunakan Laravel Breeze sebagai pondasi autentikasi.
- **Login Fleksibel:** Sistem login harus mendukung penggunaan `email` ATAU `username`.
- UI Autentikasi harus dirombak total meninggalkan bawaan Breeze, mengadopsi filosofi desain utama: Modern, bersih, minimalis.
- **Arsitektur URL Undangan:** Wajib menggunakan skema *Path Subfolder* (contoh: `domain.com/nama-pasangan`).
- **Pencegahan Bentrok Rute:** Rute undangan tamu `/{slug}` HANYA boleh diletakkan di baris paling bawah pada `routes/web.php`.

---

# Sistem Peran (Role System)

## Arsitektur Alur Bisnis

| Aspek | Admin (Pengelola Platform) | Client (Mempelai) |
|-------|----------------|-------------------|
| **Peran** | Mengontrol aktivasi akun & aset global | Mengisi konten undangan & menyebar undangan |
| **Undangan** | Set status (`trial`, `active`, `expired`), Hapus undangan bermasalah | **CRUD Penuh** atas data undangan mereka sendiri |
| **Tema** | Kelola ketersediaan (Aktif/Nonaktif) | Memilih & mengganti tema yang tersedia |
| **Manajemen Tamu** | ❌ Tidak perlu ikut campur | Input nama tamu, Generate WA Link, Lihat RSVP |
| **Ucapan (Wishes)** | Moderasi global (Hapus jika perlu) | Moderasi lokal (Sembunyikan ucapan di undangan sendiri) |

## Pengguna Awal (Seeded Users)

| Username | Password | Role | Keterangan |
|----------|----------|------|------------|
| `admin` | `admin123` | admin | Pemilik / pengelola platform |
| `lutfi` | `admin123` | client | Akun uji coba Mempelai |

---

# Prinsip Pengkodean (Coding Principles)

## Konvensi Penamaan (Indo-English Hybrid)
Untuk mempercepat pengembangan namun tetap menjaga keteraturan (*clean code*), penamaan *field* pada tabel *database* diizinkan menggunakan gaya campuran **Indo-English Hybrid** dengan format `snake_case`.
- Contoh: `nama_mempelai`, `tgl_acara`, `user_id`, `is_muncul`, `trial_habis_at`.
- Nama *Table*, *Controller*, dan *Model* tetap menggunakan Bahasa Inggris standar (contoh: `Invitation`, `RsvpMessage`).

## Lean Controllers & Service Pattern
- Controller HARUS tetap ringkas (thin).
- Controller HANYA bertugas menerima *request*, memanggil *Services*, dan mengembalikan *response*.
- **Semua validasi wajib menggunakan Form Request** (contoh: `StoreRsvpRequest`).
- **Semua logika bisnis yang rumit wajib diletakkan di dalam Service Class** (contoh: `InvitationService`).

---

# Aturan Arsitektur Blade & Mesin Tema

- Hierarki layout Blade harus dipisah secara jelas antara:
    - `layouts/admin.blade.php` (Dashboard Admin)
    - `layouts/client.blade.php` (Dashboard Pengantin)
    - `themes/{kode_tema}/layout.blade.php` (Halaman Publik)
- **Logika Pemanggilan Tema:** Jangan gunakan `if/else` bersarang. Panggil tema secara dinamis berdasarkan nilai tabel: `return view("themes.{$invitation->theme_code}.index");`.
- Gunakan *Blade Components* untuk UI global (*buttons, inputs, cards*).

---

# Aturan Mutlak: NO-RELOAD UNTUK FORM & CRUD MINOR 🚨

Aplikasi ini dituntut untuk memberikan pengalaman yang instan tanpa membebani server dengan muat ulang (*reload*) halaman penuh secara terus-menerus. Seluruh interaksi dikendalikan oleh **jQuery**.

1. **Dashboard Klien (Multi-Page dengan AJAX Form):**
   Antarmuka klien dipisah menjadi beberapa halaman berbeda berdasarkan rute (contoh: `/client/pengantin`, `/client/acara`, `/client/tamu`) menggunakan Sidebar atau Top-nav. 
   **Penting:** Meskipun halamannya terpisah, setiap kali form utama disubmit (misal: menyimpan Data Pengantin), form WAJIB ditangani oleh jQuery AJAX (`$.ajax`). Tidak ada *page reload* saat menekan tombol simpan, cukup ubah tombol menjadi *loading state* dan tampilkan SweetAlert saat data berhasil disimpan.
2. **Form RSVP & Ucapan:**
   Wajib menggunakan **jQuery AJAX** (`$.ajax` / `$.post`). Ketika form disubmit:
   - Tombol berubah menjadi *loading state* via jQuery.
   - Data dikirim asinkron.
   - Respon berhasil menyembunyikan form dan menampilkan animasi ucapan terima kasih (`.fadeOut()` dan `.fadeIn()`).
   - Ucapan baru di-*prepend* secara *real-time* ke *Greeting Wall*.
3. **Manajemen Tamu (Aksi Minor & Modal):**
   Penambahan nama tamu oleh klien wajib berjalan secara asinkron. Buka/tutup *Modal* untuk tambah/edit tamu dikendalikan penuh oleh jQuery (`$('#modal-tamu').fadeIn()`).
4. **Validasi & Konfirmasi:**
   Jangan menggunakan `window.confirm`. Selalu panggil **SweetAlert2 (Swal)** untuk operasi destruktif (seperti menghapus nama tamu atau menyembunyikan ucapan).

---

# Bagian Opsional (Optional Sections)

Beberapa konten undangan dapat diaktifkan atau dinonaktifkan oleh Klien.
Contoh: Galeri, Cerita (Love Story), Kado Digital (Angpao), dan RSVP.
**Tema harus dirancang agar tata letaknya tidak rusak atau berantakan meskipun bagian-bagian tersebut dikosongkan/disembunyikan.**

---

# Filosofi Basis Data

- Gunakan kolom (field) MySQL konvensional untuk data inti (Nama, Tanggal, Slug).
- **Hindari penggunaan tipe data JSON** secara berlebihan untuk kolom yang sering digunakan dalam proses kueri (*querying*).

---

# Aturan Performa & Pemutaran Musik

Karena prioritas utama adalah perangkat seluler (*Mobile First*):
- Optimasi gambar (kompresi) adalah kewajiban.
- **DILARANG KERAS memutar musik secara otomatis (*autoplay*) saat halaman pertama kali dimuat.**
- Alur wajib: Tamu membuka URL -> Tampil Halaman Sampul (Cover) -> Tamu menekan tombol "Buka Undangan" -> Musik mulai diputar secara bersamaan dengan transisi layar.