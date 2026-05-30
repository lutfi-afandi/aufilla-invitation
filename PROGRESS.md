# 🚀 PROGRESS TRACKER - AUFILLA INVITATION 

**Platform:** Laravel 12 Premium Digital Invitation
**Tech Stack:** PHP 8.3, MySQL, Tailwind CSS, Blade Inheritance, jQuery & SweetAlert2 (No-Reload)

---

## 📊 Ringkasan Proyek
Tabel di bawah ini digunakan untuk melacak progres pengembangan dari awal hingga rilis. 
*Indikator Status: 🔲 (To-Do) | ⏳ (In Progress) | ✅ (Done)*

| Fase & Modul | Status | Prioritas | Target Penyelesaian | Keterangan / Catatan |
|---|:---:|:---:|---|---|
| **FASE 1: Setup Lingkungan & Arsitektur Dasar** | | | | |
| Instalasi Laravel 12 & Konfigurasi Awal | ✅ | Tinggi | | Konfigurasi `.env` dasar |
| Setup Manajemen Aset Lokal (NPM, jQuery, SweetAlert2) | ✅ | Tinggi | | Terintegrasi via `app.js` tanpa CDN |
| Konfigurasi Middleware Role System (`CheckRole`) | ✅ | Tinggi | | Tiga role: `admin`, `client`, `resepsionis` |
| Pemisahan Namespace Controller & Routing Dasar | ✅ | Tinggi | | Struktur `routes/web.php` dikelompokkan |
| | | | | |
| **FASE 2: Database & Model** | | | | |
| Desain Skema Hybrid (Indo-English) & Migration | ✅ | Tinggi | | Tabel terpisah: `invitations`, `acaras`, `tamus`, dsb. |
| Konfigurasi Eloquent Relationships | ✅ | Tinggi | | HasOne, HasMany antar model |
| Database Seeder (Demo Data) | ✅ | Sedang | | Setup akun Admin & Klien default |
| | | | | |
| **FASE 3: Modifikasi Autentikasi** | | | | |
| Modifikasi Laravel Breeze (No-Slot Layouts) | ✅ | Tinggi | | Menggunakan Strict Blade Inheritance |
| Custom Login (Username atau Email) | ✅ | Tinggi | | `LoginRequest` mendeteksi otomatis input user |
| Quick Register & Auto-Trial | ✅ | Tinggi | | Otomatis membuat undangan status `trial` 1 hari |
| | | | | |
| **FASE 4: Dashboard Panel (UI/UX)** | | | | |
| Layout Utama Dashboard Klien (Sidebar/Navbar) | ✅ | Tinggi | | Desain elegan dengan Tailwind |
| Single-Container Tab Switcher Klien | ✅ | Tinggi | | Navigasi menu dinamis via jQuery (No-Reload) |
| Layout Dasar Dashboard Admin & Resepsionis | ⏳ | Tinggi | | Klien selesai, Admin & Resepsionis segera |
| | | | | |
| **FASE 5: Mesin Tema & Halaman Publik** | | | | |
| Engine Rendering View Dinamis (`/{slug}`) | 🔲 | Tinggi | | Multi-tenant path-based rendering |
| Integrasi Tema Dasar (HTML/CSS) | 🔲 | Tinggi | | Merombak template HTML mentah ke Blade |
| Optimasi Asset per Tema | 🔲 | Sedang | | Mengisolasi CSS/JS setiap tema |
| | | | | |
| **FASE 6: Fungsionalitas Inti Klien (Backend Logic)** | | | | |
| CRUD Data Pengantin & Acara (AJAX) | ⏳ | Tinggi | | Controller dasar selesai, integrasi UI sedang berjalan |
| CRUD Manajemen Tamu (AJAX Modals & SweetAlert2) | ⏳ | Tinggi | | Menambah/menghapus daftar undangan tanpa reload |
| WhatsApp Link Generator untuk Tamu | ⏳ | Tinggi | | Autogenerate URL API WA |
| Galeri & Upload Media | 🔲 | Sedang | | Handling file lokal |
| | | | | |
| **FASE 7: Interaksi Tamu** | | | | |
| Form RSVP (Kehadiran & Pesan) via AJAX | 🔲 | Tinggi | | Submit tanpa reload pada halaman Publik |
| Dynamic Greeting Wall | 🔲 | Tinggi | | Pesan otomatis ter-prepend setelah submit |
| | | | | |
| **FASE 8: Landing Page & Checkout** | | | | |
| Pembuatan Halaman Depan Publik (Katalog Tema) | 🔲 | Sedang | | Presentasi UI untuk calon pembeli |
| Flow Pembelian / Aktivasi WA | 🔲 | Tinggi | | CTA tombol Order yang mengarah ke WA Admin |
| | | | | |
| **FASE 9: Optimasi & Produksi** | | | | |
| Vite Build & Minify Assets | 🔲 | Sedang | | |
| Caching Database & Routes | 🔲 | Sedang | | `php artisan optimize` |
| Persiapan Deployment ke VPS / Server | 🔲 | Rendah | | |

---

*Terakhir Diperbarui: 30 Mei 2026*
