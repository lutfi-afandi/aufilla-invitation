# AGENTS.md — Theme Generation Manifesto (Aufilla Invitation)

Baca ini SETIAP KALI sebelum membuat/meng-clone tema baru. Dokumen ini mencegah masalah kontras, kerataan visual, dan kesalahan role warna yang pernah terjadi sebelumnya.

---

## 1. Flow Pembuatan Tema Baru

1. **Clone** dari tema yang struktur cahaya/gelapnya paling cocok (`aufilla-maroon` = dark cover/light right, `aufilla-white` = all light).
2. **Ganti Tailwind palette** (colors) di `index.blade.php` — setiap palette WAJIB punya gradasi 50–950 yang lengkap.
3. **Ganti nama kelas** Tailwind secara massal (primary → primary baru, accent → accent baru, bg → bg baru).
4. **Ganti inline hex colors** (rgba, borders, backgrounds) satu per satu — jangan dilewat.
5. **Audit kontras** — gunakan checklist di bawah. Ini langkah paling krusial.
6. **Cek setiap section**: cover, hero, quote, couple, event, story, gallery, gift, rsvp, footer, loading, floating controls, QR modal.

---

## 2. Color Role Convention (WAJIB)

Setiap tema punya 3 kelompok warna:

| Role | Contoh nama | Fungsi |
|------|-----------|--------|
| **Primary** | maroon, teal, blush, onyx | Warna utama tema. Untuk heading H2, tombol CTA, nama pasangan, elemen IMPORTANT saja. |
| **Neutral** | gold → silver, champagne, copper | Warna pendamping. Untuk subtitle, border, garis, icon, frame, divider — semua elemen DEKORATIF. |
| **Background** | cream → ice/pearl, white, ivory | Warna latar. Untuk section bg, card bg, canvas. |

### Aturan penggunaan di setiap konteks:

#### Light section (bg terang)
| Elemen | Warna | Contoh |
|--------|-------|--------|
| H2 heading | Primary 800/900 | `text-maroon-800` |
| Section subtitle | Neutral 600 | `text-gold-600` |
| Section underline | Neutral 400 | `bg-gold-400` |
| Nama pasangan | Primary 800 | `text-maroon-800` |
| Tombol CTA | Primary 800 | `bg-maroon-800 text-white` |
| Icon dekoratif | Neutral 500/600 | `text-gold-500` |
| Border dekoratif | Neutral 400/20–30% | `border-gold-400/20` |
| Body text | Stone 600 | `text-stone-600` |
| Label sekunder | Neutral 600 | `text-gold-600` |
| Card bg | White | `bg-white` |

#### Dark section / overlay (bg gelap)
| Elemen | Warna | Contoh |
|--------|-------|--------|
| Teks utama | White | `text-white` |
| Teks sekunder | Primary/Light 100–200 | `text-maroon-100` |
| Aksen dekoratif | Neutral 200–300 | `text-gold-200` |
| Icon dekoratif | Primary 200–300 | `text-maroon-200` |
| Border | Primary 400/15–20% | `border-maroon-400/15` |
| **JANGAN PAKAI** | Neutral/Accent 500 sbg teks | ❌ `text-gold-500` di `bg-maroon-800` |

### ⚠️ Golden Rule: JANGAN PERNAH menaruh `{accent}-500` sbg teks di atas `{primary}-800/900` sbg background. Kontrasnya selalu kurang.

---

## 3. Checklist Audit Kontras (Cek Setiap Tema Baru)

Setelah replace warna selesai, audit SATU PER SATU:

### Cover / Hero Overlay
- [ ] Overlay opacity: maksimal 0.55–0.60 di bagian tengah. Foto harus tetap terlihat.
- [ ] Gradient: darker di tepi (0.65–0.70), lighter di tengah (0.40–0.50).
- [ ] `&` symbol pakai light variant (100–200), jangan 500.

### Dark Sections (loading, cover overlay, left panel, footer, floating controls)
- [ ] Semua teks: white atau 100–200, JANGAN 500.
- [ ] Tombol CTA di atas overlay: bg putih/terang + teks primary-800 (contrast maksimal).
- [ ] Countdown numbers: `text-white` + `drop-shadow-sm` untuk legibility.
- [ ] Countdown labels: neutral-100/200, bukan warna asli.
- [ ] Countdown box borders: primary-400/15, jangan neutral-500/30.

### Light Sections (right panel)
- [ ] Subtitle section: neutral-600 (bukan primary-500).
- [ ] Underline: neutral-400 (bukan primary-500).
- [ ] Border dekoratif: neutral-400/20 (bukan primary-500/20).
- [ ] Frame foto: neutral-400 (bukan primary-500).
- [ ] Label "Mempelai Pria/Wanita": neutral-600 (bukan primary-600).
- [ ] Ikon event (calendar, clock, map): neutral-600 (bukan primary-600).
- [ ] Icon container bg: neutral-50 (bukan primary-50).
- [ ] Divider heart: neutral-500 (bukan primary-500).

### CTA Buttons
- [ ] Primary-800 bg + white text untuk semua tombol aksi utama (maps, submit RSVP).
- [ ] Hover state: brightness/scale effect.

### Floating Controls
- [ ] Music button: primary gradient dengan white icon.
- [ ] QR/Back-to-top: primary bg, light icon (200–300).
- [ ] Nav bar: border primary-400/20, active state white atau light variant.

### Section Background Alternation
- [ ] Genap dan ganjil bergantian: ice-50 (white) ↔ ice-100 (light tint).

---

## 4. Palette Quality Standards

Setiap palette WAJIB:

1. **Mid-tones (400–600) harus vibrant** — jangan muted/pucat. Kalau perlu, pakai saturasi lebih tinggi.
2. **Dark base (800) harus cukup gelap** untuk kontras dengan teks putih di atasnya.
3. **Light variants (50–200) harus murni** — tidak bercampur hue lain yang membuatnya kotor.
4. **Gradasi halus** — no abrupt jumps. 50→100→200→300→400→500→600→700→800→900→950.

**Test palette**: cek visual dengan mata — teks 800 di atas bg 50 harus jelas, teks white di atas bg 800 harus kontras.

---

## 5. Yang PERNAH SALAH (Lessons Learned)

Dari pengalaman `aufilla-teal`:

| Masalah | Akar | Solusi |
|---------|------|--------|
| Cover foto tidak keliatan | Overlay opacity 0.85–0.95 | Maks 0.55–0.70 |
| Tampilan datar/monoton | Semua elemen pakai primary-500 (border, icon, subtitle, underline) | Neutral untuk decorative, primary hanya untuk heading/CTA |
| Text kusam di dark section | silver-500 (#8E98A0) di atas teal-800 (#0E5E6B) | Teks di dark bg pake 100–200 atau white |
| Countdown angka tidak terbaca | silver-500 pada teal-800 | white + drop-shadow |
| Button Buka Undangan samar | Silver gradient + dark teal text di atas overlay | White bg + primary-800 text |
| `&` symbol tidak jelas | neutral-500 di dark bg | light primary (200) atau white/70 |

---

## 6. File Referensi

- `resources/views/themes/aufilla-teal/index.blade.php` — contoh implementasi dengan koreksi kontras lengkap
- `resources/views/themes/aufilla-maroon/index.blade.php` — template dasar untuk clone dark theme
- `docs/theme_generation_guide.md` — panduan teknis struktur tema
- `future_themes_suggestions.md` — daftar calon tema dan contoh prompt
