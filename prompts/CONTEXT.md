# STATUS PENGEMBANGAN APLIKASI (APPLICATION CONTEXT)

## 1. Fase Saat Ini
- Sedang mengerjakan: **Fase 6 - Sisa Modul Klien (Galeri, Cerita, Kado) & Admin Dashboard**.

## 2. Fitur yang Sudah Selesai (Done)
- [x] Migration database & Modifikasi Laravel Breeze (Quick Register).
- [x] Base Layout Blade (Strict Template Inheritance).
- [x] Manajemen Aset Lokal (jQuery & SweetAlert2 via `npm`).
- [x] Middleware `CheckRole` dan Arsitektur Multi-Pilar (Admin, Client, Receptionist).
- [x] **Panel Klien**: UI Dashboard, Form Pengantin, Form Acara, Buku Tamu, Pengaturan Tema/Status (Multi-Page AJAX).
- [x] **Tema Engine Publik**: Render dinamis `/{slug}`.
- [x] Migrasi tema `aufilla-green` dan penyelarasan variabel dengan data undangan V2.
- [x] AJAX submission untuk form RSVP Publik (Dinding Ucapan) dan status kehadiran.

## 3. Tugas Selanjutnya (Next Todo)
- [ ] Membangun antarmuka Manajemen Galeri Foto (Client).
- [ ] Membangun antarmuka Linimasa Cerita Cinta (Client).
- [ ] Membangun antarmuka Rekening/Kado Digital (Client).
- [ ] Menyelesaikan UI Dashboard Admin (Kelola Klien & Status Tema).

## 4. Perubahan Database & Arsitektur Terakhir
- Arsitektur Client berpindah dari *Single-Container* (tab switch DOM) ke *Multi-Page Architecture* agar lebih ringan.
- Skema *Ucapans* (kolom `pesan`, enum `tidak`) telah diselaraskan dengan rute form RSVP publik `aufilla-green`.