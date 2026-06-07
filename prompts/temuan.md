# Temuan Pengujian Manual

| Tanggal | Fitur/Skenario | Status | Deskripsi Temuan |
|---------|---------------|--------|------------------|
| 2026-06-06 | Halaman undangan publik (user baru daftar) | ❌ | Link undangan yang disebar user baru sudah menampilkan ucapan selamat, padahal seharusnya kosong (belum diisi). |
| 2026-06-06 | Halaman undangan publik (cerita pengantin) | ❌ | Isi cerita tidak tampil di undangannya. |
| 2026-06-06 | UX Panel Klien (Kelola Undangan + Pengaturan Tema) | ⚠️ | Navigasi antara tab Kelola Undangan dan Pengaturan Tema merepotkan karena terpisah menu & full page reload. Disarankan digabung jadi 1 halaman SPA dengan jQuery + History API. |
| 2026-06-06 | Halaman undangan publik — sinkronisasi pengaturan | ⚠️ | Perlu diperiksa apakah toggle Galeri/Cerita/Kado di Pengaturan Tema sudah sinkron dengan tampilan undangan publik (`/{slug}`). Pastikan fitur yang dimatikan tidak muncul, dan yang dihidupkan muncul sesuai. |
| 2026-06-06 | Pengaturan Tema — Modul & Fitur (trial) | ❌ | UI pakai `getFeatureAccess()` (beri akses trial ke Cerita), controller pakai `PackageHelper::canAccessLoveStory()` (tolak trial). Detail payload test: **Payload sukses**: `is_galeri_aktif=on` saja → `{success:true}`. `is_galeri_aktif=on + is_kado_aktif=on` → `{success:true}`. `is_kado_aktif=on` saja → `{success:true}`. **Payload gagal (error 403)**: `is_galeri_aktif=on + is_cerita_aktif=on` → error Paket tidak mendukung Cerita Cinta. `is_cerita_aktif=on + is_kado_aktif=on` → error sama. `is_galeri_aktif=on + is_cerita_aktif=on + is_kado_aktif=on` → error sama. Kesimpulan: setiap kali `is_cerita_aktif` ikut terkirim, controller return 403 sebelum sempat menyimpan field apa pun. |

