# STATUS PENGEMBANGAN APLIKASI (APPLICATION CONTEXT)

## 1. Fase Saat Ini
- Sedang mengerjakan: **Fase 5 - Pembuatan Admin Dashboard & Manajemen Tema** (Setelah menyelesaikan Fase 4 Dashboard Klien).

## 2. Fitur yang Sudah Selesai (Done)
- [x] Migration database (hybrid username/email, tabel `themes`, `invitations`, `acaras`, `galeris`, `tamus`, `ucapans`).
- [x] Modifikasi Laravel Breeze untuk login multi-kolom (username/email) dan fitur Quick Register (generate trial 1 hari).
- [x] Base Layout Blade menggunakan sistem Strict Template Inheritance (`@extends`, `@section`).
- [x] Manajemen Aset Lokal (jQuery & SweetAlert2 via `npm` dan `app.js`).
- [x] Middleware `CheckRole` terpusat (Admin, Client, Receptionist).
- [x] Arsitektur Routing & Controller yang terpisah (`Admin`, `Client`, `Receptionist`).
- [x] UI Dashboard Klien (Single-Container Tab Switcher, no-reload AJAX forms).

## 3. Tugas Selanjutnya (Next Todo)
- [ ] Menyelesaikan UI Dashboard Admin (Kelola Klien & Status Tema).
- [ ] Menyelesaikan Service Logic yang lebih kompleks (seperti menyimpan gambar cover_img).
- [ ] Membangun Theme Engine Publik (`/{slug}`) yang merender file blade spesifik berdasarkan data `themes`.
- [ ] Pembuatan AJAX submission untuk form RSVP Publik.

## 4. Perubahan Database & Arsitektur Terakhir
- Redirect login (`AuthenticatedSessionController`) dibuat *strict* (`redirect()->route('dashboard')`) untuk menghindari isu *intended URL* yang menyebabkan loop/error 403.
- Tabel relasional anak (seperti `tamus`, `ucapans`) terhubung dengan foreign key ke tabel `invitations`.