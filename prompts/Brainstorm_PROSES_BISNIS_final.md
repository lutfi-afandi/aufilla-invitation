# Proses Bisnis — Aufilla Invitation

Dokumen ini menjelaskan aturan bisnis yang harus diimplementasikan di aplikasi, berdasarkan role dan status paket.

---

## 1. ADMIN — Manajemen Klien

### 1.1 Kolom Paket
- Tabel daftar klien harus menampilkan kolom **Paket** (Basic / Premium / VIP / —).
- Form **Create** dan **Edit** klien harus menyertakan dropdown pemilihan paket (`package_id`).
- Admin bisa mengubah paket klien kapan saja melalui form Edit.
- `package_id` adalah nullable foreign key di tabel `invitations` → klien yang masih trial belum punya paket (`package_id = null`).

### 1.2 Status & Masa Berlaku
- Kolom **Terdaftar**: tanggal registrasi klien.
- Kolom **Masa Aktif Berakhir**: dihitung dari `created_at` + `package.active_days`.
- Jika status `active` dan `trial_habis_at` sudah lewat → sistem otomatis menunjukkan status kedaluwarsa.
- Filter pencarian berdasarkan: username, email, status, dan paket.

### 1.3 Status Undangan
- Enum kolom `status` di tabel `invitations`: **`trial`**, **`active`**, **`expired`**.
  - `trial` — masa percobaan 1 hari.
  - `active` — sudah aktif (berbayar, punya paket).
  - `expired` — sudah kedaluwarsa.

---

## 2. USER (KLIEN) — Aturan Fitur Berdasarkan Paket

### 2.1 Aturan Per Paket

| Paket | Cerita Cinta | Upload Musik Latar | Keterangan |
|-------|-------------|-------------------|------------|
| **Trial** | ✅ Aktif | ✅ Bisa upload | Semua fitur premium & VIP bisa diakses (free testing) |
| **Basic** | ❌ Disable | ❌ Disable | `has_love_story = false`, `can_custom_music = false` |
| **Premium** | ✅ Aktif | ❌ Disable | `has_love_story = true`, `can_custom_music = false` |
| **VIP** | ✅ Aktif | ✅ Bisa upload | `has_love_story = true`, `can_custom_music = true` |

### 2.2 Detail Implementasi

#### Trial
- Toggle **Cerita Cinta** → enabled, bisa diaktifkan/nonaktifkan bebas.
- Input **Musik Latar** → bisa upload file MP3/WAV.
- Semua fitur lain (galeri, kado) juga terbuka penuh.
- Masa trial otomatis 1 hari setelah registrasi.
- Jika trial habis dan belum membeli paket → status berubah `expired`.

#### Basic (`has_love_story = false`, `can_custom_music = false`)
- Toggle **Cerita Cinta** → **disabled** (tidak bisa dicentang), tampilkan gembok + teks "Tidak tersedia di paket Basic".
- Input **Musik Latar** → **disabled** (tidak bisa upload), tampilkan teks "Tidak tersedia di paket Basic".

#### Premium (`has_love_story = true`, `can_custom_music = false`)
- Toggle **Cerita Cinta** → **enabled**, bisa diaktifkan/nonaktifkan.
- Input **Musik Latar** → **disabled**, tampilkan teks "Hanya tersedia di paket VIP".

#### VIP (`has_love_story = true`, `can_custom_music = true`)
- Toggle **Cerita Cinta** → **enabled**.
- Input **Musik Latar** → **enabled**, bisa upload file MP3/WAV.

### 2.3 Catatan Penting: Trial ≠ Paket
- **Trial bukan paket** — `package_id` tetap null selama masa trial.
- Trial hanyalah status sementara (`status = trial`) yang memberi akses ke semua fitur.
- Begitu user membeli paket → `package_id` diisi, `status` berubah jadi `active`, dan aturan paket berlaku.
- Jika trial habis (melebihi `trial_habis_at`) tanpa pembelian → `status` menjadi `expired`.

### 2.4 Validasi Backend (Wajib)
- **Server-side validation**: method `updateSettings()` di `InvitationController` harus mengecek paket sebelum menyimpan:
  - Jika user Basic dan mengirim `is_cerita_aktif = true` → tolak dengan error.
  - Jika user Basic/Premium dan mengirim `music_file` → tolak dengan error.
  - Trial: semua diperbolehkan (tidak perlu cek paket karena `package_id = null`).
- **UI disabling**: toggle dan input harus disabled di HTML agar user tidak bisa mengirim data yang tidak diizinkan.

### 2.5 Dashboard — Sambutan & Aktivasi WA

#### Sambutan Berdasarkan Status
- **Trial**: "Anda saat ini sedang dalam masa trial. Aktifkan undangan Anda agar dapat disebar tanpa batasan waktu."
- **Aktif + Basic/Premium/VIP**: "Selamat! Paket [Nama Paket] Anda aktif hingga [tanggal]."
- **Expired**: "Undangan Anda tidak aktif. Silakan hubungi Admin untuk informasi lebih lanjut."

#### Tombol Aktivasi WA
- Nomor WhatsApp: **085171097138** (format internasional: `6285171097138`).
- Link: `https://wa.me/6285171097138?text=Halo%2C%20saya%20ingin%20aktivasi%20undangan...`
- Disimpan di `.env` sebagai `ACTIVATION_WA_NUMBER`.

### 2.6 Slug Undangan
- Slug harus **berdasarkan input user**, bukan random string.
- Contoh: user input nama "Lutfi & Rina" → slug: `lutfi-rina`.
- Jika slug sudah dipakai, tambahkan counter: `lutfi-rina-1`, `lutfi-rina-2`, dst.
- **Seragamkan di semua entry point**:
  - `LandingController::register()` — pakai counter.
  - `Admin/ClientController::store()` — pakai counter.
  - `Client/DashboardController::getInvitation()` — pakai counter.
  - `InvitationService::quickRegister()` — ✅ sudah pakai counter.

---

## 3. VIEW UNDANGAN PUBLIK (Tema)

### 3.1 Aturan Tampilan
- Tema publik (`/{slug}`) harus **menyesuaikan fitur yang aktif** pada invitation:
  - `is_galeri_aktif` → tampilkan/sembunyikan section Galeri.
  - `is_cerita_aktif` → tampilkan/sembunyikan section Cerita Cinta.
  - `is_kado_aktif` → tampilkan/sembunyikan section Kado Digital.
- Kondisi saat ini: ✅ sudah diimplementasikan di kedua tema (`aufilla-green` & `aufilla-maroon`).

### 3.2 Batas Galeri dari Paket
- Upload foto galeri dibatasi oleh `package.max_gallery_photos`:
  - Basic: maks 5 foto.
  - Premium: maks 10 foto.
  - VIP: maks 999 foto (unlimited).
  - Trial: unlimited.
- Tampilkan sisa kuota di panel klien: "Foto: X dari Y slot terpakai".
- **Server validation**: `FeatureController@storeGaleri` harus cek jumlah existing foto vs `max_gallery_photos`.

---

## 4. CATATAN TEKNIS

### 4.1 Environment Variable
```env
ACTIVATION_WA_NUMBER=6285171097138
```

Akses via: `config('app.activation_wa')`.

### 4.2 Status Enum (wajib konsisten)
- `trial` — masa percobaan (`package_id = null`).
- `active` — sudah aktif dengan paket.
- `expired` — sudah kedaluwarsa.

**⚠️ Bug yang ada**: `Admin/ClientController::updateStatus()` menggunakan validator `['draft','trial','aktif','nonaktif']` — ini tidak sesuai dengan enum migration. Harus diperbaiki menjadi `['trial','active','expired']`.

### 4.3 Helper Method di Invitation Model
Tambahkan method untuk mengecek akses fitur:
```php
public function getFeatureAccess(): array
{
    if ($this->status === 'trial' || !$this->package) {
        // Trial: semua fitur terbuka
        return ['can_cerita' => true, 'can_music' => true, 'max_galeri' => 999];
    }
    return [
        'can_cerita' => $this->package->has_love_story,
        'can_music'  => $this->package->can_custom_music,
        'max_galeri' => $this->package->max_gallery_photos,
    ];
}
```
Return: `['can_cerita' => bool, 'can_music' => bool, 'max_galeri' => int]`.

---

## 5. FILE-FILE TERKAIT

| Area | File |
|------|------|
| Admin Controller | `app/Http/Controllers/Admin/ClientController.php` |
| Client Invitation | `app/Http/Controllers/Client/InvitationController.php` |
| Client Dashboard | `app/Http/Controllers/Client/DashboardController.php` |
| Client Feature | `app/Http/Controllers/Client/FeatureController.php` |
| Landing Register | `app/Http/Controllers/LandingController.php` |
| Invitation Service | `app/Services/InvitationService.php` |
| Invitation Model | `app/Models/Invitation.php` |
| Package Model | `app/Models/Package.php` |
| Package Seeder | `database/seeders/PackageSeeder.php` |
| Migration Invitations | `database/migrations/2026_05_30_060341_create_invitations_table.php` |
| Migration Add Package | `database/migrations/2026_05_31_055028_add_package_id_to_invitations_table.php` |
| Admin Client View | `resources/views/admin/clients/index.blade.php` |
| Admin Row Partial | `resources/views/admin/clients/partials/row.blade.php` |
| Client Pengaturan | `resources/views/client/pengaturan.blade.php` |
| Client Dashboard | `resources/views/client/dashboard.blade.php` |
| Environment | `.env` |
| Config | `config/app.php` |
