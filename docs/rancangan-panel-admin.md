# Rancangan Panel Admin — Aufilla Invitation

> **Status:** ✅ APPROVED  
> **Target Sesi:** 31 Mei 2026

---

## Konteks Bisnis

Berdasarkan [blueprint](file:///C:/Users/lutfi/.gemini/antigravity-ide/knowledge/aufilla_blueprint/artifacts/blueprint.md), Aufilla adalah **Guided Service (Premium Concierge)**. Admin yang mengelola pesanan, memasukkan data, menentukan tema, dan mengaktifkan undangan. Panel Admin adalah **pusat kontrol utama** dari seluruh platform.

---

## Arsitektur yang Sudah Ada

### Model & Relasi
```
User (role: admin/client/resepsionis)
  └─ hasOne → Invitation
                ├─ belongsTo → Theme
                ├─ hasMany → Acara
                ├─ hasMany → Galeri
                ├─ hasMany → Cerita
                ├─ hasMany → Kado
                ├─ hasMany → Tamu
                └─ hasMany → Ucapan
```

### Route Admin Saat Ini (Kosong)
```php
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
});
```

### Controller Admin Saat Ini (Skeleton)
[DashboardController.php](file:///c:/laragon/www/self-project/my-undangan-v2/app/Http/Controllers/Admin/DashboardController.php) — hanya return view kosong.

---

## Modul yang Direncanakan

### 1. Dashboard Admin (Statistik Utama)

**Tujuan:** Ringkasan bisnis dalam satu pandangan.

**Widget/Card Statistik:**
| Widget | Data | Query |
|---|---|---|
| Total Klien | `User::where('role','client')->count()` | Count |
| Undangan Aktif | `Invitation::where('status','aktif')->count()` | Count |
| Undangan Trial | `Invitation::where('status','trial')->count()` | Count |
| Undangan Draft | `Invitation::where('status','draft')->count()` | Count |
| Total Tamu (Global) | `Tamu::count()` | Count |
| Ucapan Terbaru | 5 ucapan terakhir di semua undangan | Latest |

**Grafik (Opsional):**
- Grafik pendaftaran klien per minggu/bulan (line chart).

**File yang akan dibuat/dimodifikasi:**
#### [MODIFY] [DashboardController.php](file:///c:/laragon/www/self-project/my-undangan-v2/app/Http/Controllers/Admin/DashboardController.php)
- Query semua statistik dan kirim ke view.

#### [NEW] `resources/views/admin/dashboard.blade.php`
- Card statistik + tabel ucapan terbaru.

---

### 2. Manajemen Klien (Users)

**Tujuan:** CRUD akun klien + overview undangan mereka.

**Fitur:**
- Tabel daftar klien: Username, Email, Status Undangan, Tanggal Daftar, Aksi.
- **Buat Klien Baru:** Form modal (username, email, password, tema).
  - Otomatis membuat `Invitation` terhubung saat membuat user baru.
- **Edit Klien:** Ubah email, reset password.
- **Hapus Klien:** Soft delete atau hard delete + cascade hapus invitation.
- **Lihat Detail:** Ringkasan undangan klien (jumlah tamu, ucapan, status).
- **Impersonasi (Opsional):** Login sebagai klien untuk membantu mengisi data mereka.

**File yang akan dibuat:**
#### [NEW] `app/Http/Controllers/Admin/ClientController.php`
- `index()`, `store()`, `show()`, `update()`, `destroy()`

#### [NEW] `resources/views/admin/clients/index.blade.php`
- Tabel + Search + Pagination + Modal form

#### [NEW] `resources/views/admin/clients/show.blade.php`
- Detail ringkasan undangan klien

---

### 3. Manajemen Tema

**Tujuan:** CRUD tema undangan.

**Fitur:**
- Tabel daftar tema: Nama, Kode, Thumbnail, Status (Aktif/Nonaktif), Jumlah Pengguna.
- **Tambah Tema:** Form (name, code, thumbnail upload, is_active).
- **Edit Tema:** Ubah nama, upload thumbnail baru.
- **Nonaktifkan Tema:** Toggle `is_active` — tema nonaktif tidak bisa dipilih untuk undangan baru.
- **Preview Tema:** Link ke `/{slug}?preview=true` dengan data dummy.

**File yang akan dibuat:**
#### [NEW] `app/Http/Controllers/Admin/ThemeController.php`
- `index()`, `store()`, `update()`, `toggleActive()`

#### [NEW] `resources/views/admin/themes/index.blade.php`
- Grid card tema + modal form

---

### 4. Kontrol Status Undangan (Hak Mutlak Admin)

**Tujuan:** Mengubah status undangan klien (draft/trial/aktif/nonaktif).

> [!IMPORTANT]
> Ini adalah fitur yang baru saja **dicabut** dari panel client. Hanya admin yang boleh mengubah status.

**Pendekatan:** Terintegrasi ke dalam halaman detail klien (modul #2), bukan halaman terpisah.

**Fitur:**
- Dropdown status di halaman detail klien.
- Saat diubah ke `aktif`, otomatis set `trial_habis_at = null`.
- Saat diubah ke `trial`, otomatis set `trial_habis_at = now()->addDays(3)` (atau sesuai kebutuhan).
- Log perubahan status (opsional, untuk audit trail).

**File yang akan dimodifikasi:**
#### [MODIFY] `app/Http/Controllers/Admin/ClientController.php`
- Tambah method `updateStatus($id)`.

---

### 5. Manajemen Resepsionis

**Tujuan:** CRUD akun resepsionis yang nantinya bisa scan QR di acara.

**Fitur:**
- Tabel daftar resepsionis: Username, Email, Assigned Invitation, Aksi.
- **Buat Resepsionis:** Form (username, email, password, pilih invitation yang di-assign).
- **Edit/Hapus.**

**File yang akan dibuat:**
#### [NEW] `app/Http/Controllers/Admin/ReceptionistController.php`
#### [NEW] `resources/views/admin/receptionists/index.blade.php`

---

### 6. Broadcast / WhatsApp Template (Opsional)

**Tujuan:** Generate link WhatsApp massal untuk semua tamu dari suatu undangan.

> [!NOTE]
> Ini sudah ada di panel client (per undangan). Di panel admin bisa ditambahkan untuk mengirim broadcast lintas undangan.

---

## Layout Admin

### Pendekatan
Membuat layout admin baru yang terpisah dari client, dengan sidebar navigasi sendiri.

**File yang akan dibuat:**
#### [NEW] `resources/views/layouts/admin.blade.php`
- Sama pola dengan `client.blade.php`: sidebar + navbar + content area.
- Warna berbeda (misal: dark navy/indigo) agar admin mudah membedakan panel mereka dari panel client.

#### [NEW] `resources/views/partials/admin_sidebar.blade.php`
- Menu: Dashboard, Klien, Tema, Resepsionis.

#### [NEW] `resources/views/partials/admin_navbar.blade.php`
- Info admin, logout.

---

## Routing yang Direncanakan

```php
// Di dalam Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group()

// Dashboard
Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

// Clients
Route::get('/clients', [Admin\ClientController::class, 'index'])->name('clients.index');
Route::post('/clients', [Admin\ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}', [Admin\ClientController::class, 'show'])->name('clients.show');
Route::put('/clients/{id}', [Admin\ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{id}', [Admin\ClientController::class, 'destroy'])->name('clients.destroy');
Route::patch('/clients/{id}/status', [Admin\ClientController::class, 'updateStatus'])->name('clients.status');

// Themes
Route::get('/themes', [Admin\ThemeController::class, 'index'])->name('themes.index');
Route::post('/themes', [Admin\ThemeController::class, 'store'])->name('themes.store');
Route::put('/themes/{id}', [Admin\ThemeController::class, 'update'])->name('themes.update');
Route::patch('/themes/{id}/toggle', [Admin\ThemeController::class, 'toggleActive'])->name('themes.toggle');

// Receptionists
Route::get('/receptionists', [Admin\ReceptionistController::class, 'index'])->name('receptionists.index');
Route::post('/receptionists', [Admin\ReceptionistController::class, 'store'])->name('receptionists.store');
Route::put('/receptionists/{id}', [Admin\ReceptionistController::class, 'update'])->name('receptionists.update');
Route::delete('/receptionists/{id}', [Admin\ReceptionistController::class, 'destroy'])->name('receptionists.destroy');
```

---

## Keputusan Final

| # | Pertanyaan | Keputusan |
|---|---|---|
| 1 | Warna Panel Admin | **Berbeda** (dark navy/slate), tapi gaya/bahasa UI tetap sama dengan panel client |
| 2 | Impersonasi Klien | **Disetujui** — fitur "Login sebagai Klien" akan dibuat |
| 3 | Resepsionis | **Many-to-many** — 1 resepsionis bisa handle beberapa undangan. Dikerjakan **terakhir** |
| 4 | Prioritas Modul | **Disepakati**: Layout → Dashboard → Klien+Status → Tema → Resepsionis |

---

## Verification Plan

### Automated
- `php artisan route:list --path=admin` — memastikan semua route terdaftar.
- Menjalankan CRUD via browser: buat klien, ubah status, buat tema.

### Manual
- Login sebagai admin → navigasi seluruh modul.
- Buat klien baru → verifikasi undangan otomatis ter-create.
- Ubah status undangan → verifikasi halaman publik berubah behavior (aktif = bisa diakses, nonaktif = 404).
