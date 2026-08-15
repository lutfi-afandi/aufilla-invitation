# Rencana Tema Undangan Soraya Mendatang

Berikut adalah saran konsep tema untuk keluarga desain **Soraya** (gaya Editorial/Majalah). Desain Soraya berbeda fundamental dari Aufilla: menggunakan layout *single-column scrollable*, bentuk asimetris (`rounded-tr-[80px]`), blok vertikal berteks putar ("THE BRIDE"), dan font Google Fonts (Playfair Display, Great Vibes, Montserrat).

---

## Daftar Saran Tema

### 1. Soraya Rose (Romantic Blush)

- **Brand:** Dusty Rose / Blush Pink (`#7A3B4A` → `#B26B7A`)
- **Accent:** Rose Gold (`#C49B7A`)
- **Background:** Soft Pink (`#FFF5F5`)
- **Vibe:** Sangat feminin, romantis. Ideal untuk pernikahan floral/garden party.

### 2. Soraya Noir (Dark Luxury)

- **Brand:** Jet Black / Charcoal (`#1A1A1A` → `#2D2D2D`)
- **Accent:** Pure Gold (`#D4AF37`)
- **Background:** Dark Smoke (`#121212`)
- **Vibe:** Ultra mewah, misterius, high-end. Kontras tinggi emas di atas hitam.

### 3. Soraya Sage (Botanical Minimalist)

- **Brand:** Sage Green (`#3D5A45` → `#5B7A63`)
- **Accent:** Champagne (`#C9B477`)
- **Background:** Mint White (`#F5F9F5`)
- **Vibe:** Natural, menenangkan, cocok untuk pernikahan outdoor/rustic.

### 4. Soraya Royal (Deep Navy)

- **Brand:** Deep Navy Blue (`#1A2744` → `#2C3E6B`)
- **Accent:** Silver (`#A8B5C4`)
- **Background:** Ice White (`#F4F6F9`)
- **Vibe:** Elegan, maskulin, klasik. Sangat premium dan timeless.

### 5. Soraya Amber (Warm Autumn)

- **Brand:** Deep Amber / Cognac (`#6B3A15` → `#8B5A2B`)
- **Accent:** Copper (`#B87333`)
- **Background:** Warm Ivory (`#FDF8F0`)
- **Vibe:** Hangat, membumi, cocok untuk intimate wedding musim gugur.

### 6. Soraya Plum (Dramatic Purple)

- **Brand:** Deep Plum (`#3A1D4A` → `#5B2D6B`)
- **Accent:** Lavender Gold (`#C4A8D4`)
- **Background:** Soft Lavender (`#FAF5FF`)
- **Vibe:** Dramatis, royal, megah. Warna ungu kerajaan yang sophisticated.

### 7. Soraya Teal (Oceanic Fresh)

- **Brand:** Deep Teal (`#0E4A50` → `#1A6A6B`)
- **Accent:** Pale Gold (`#C9B477`)
- **Background:** Ice Mint (`#F0FAFA`)
- **Vibe:** Segar, unik, modern. Kesan jewel-tone yang dalam.

### 8. Soraya Ivory (Classic White)

- **Brand:** Espresso Brown (`#3E2723` → `#5D4037`)
- **Accent:** Warm Gold (`#C9A962`)
- **Background:** Pure Ivory (`#FFFFF0`)
- **Vibe:** All-white classic yang sangat netral dan timeless.

---

## Contoh Prompt Clone Soraya

### Contoh: "Soraya Rose"

> **Prompt:**
> "Buatkan tema baru `soraya-rose` yang dikloning dari `soraya-pilot`.
>
> **Kebutuhan Warna:**
>
> 1. Ganti palette `brand` di tailwind.config menjadi Dusty Rose (900: `#7A3B4A`, 800: `#8B4A5A`, 700: `#A06070`).
> 2. Background body tetap light (`#FFF5F5`).
> 3. Accent color untuk ornamen/dekoratif: Rose Gold (`#C49B7A`).
>
> **Instruksi Penting:**
>
> - Ganti SEMUA inline rgba() di CSS ornament yang mengandung `74,30,36` menjadi rgb values dari warna brand baru.
> - Ganti Google Fonts sesuai kebutuhan (opsional, bisa tetap sama).
> - Pastikan kontras teks putih di atas brand-800 tetap terjaga.
> - Daftarkan tema ke database."

### Contoh: "Soraya Noir" (Dark Theme)

> **Prompt:**
> "Buatkan tema `soraya-noir` dari `soraya-pilot`.
>
> **Kebutuhan Warna:**
>
> - Brand: Jet Black (`900: #1A1A1A`, `800: #2D2D2D`, `700: #404040`).
> - Accent: Pure Gold (`#D4AF37`).
> - Background body: `#121212` (dark mode).
>
> **Instruksi Khusus Dark Mode:**
>
> - Ubah bg-[#F9F9F9] menjadi bg-[#121212] di body dan section.
> - Ubah bg-white pada card menjadi bg-[#1E1E1E] border border-white/10.
> - Teks stone-600/700 menjadi stone-300/400.
> - Section heading tetap putih/emas.
> - Ornament rgba opacity dinaikkan sedikit (0.06-0.10) agar terlihat di dark bg."

---

## Mengapa Prompt Ini Baik?

1. **Target Clone Jelas:** Selalu clone dari `soraya-pilot` sebagai satu-satunya basis.
2. **Definisi Warna Spesifik:** Brand 700/800/900 + accent + background dijabarkan secara eksplisit.
3. **Inline CSS Awareness:** Mengingatkan bahwa ornament CSS mengandung hardcoded rgba yang WAJIB diganti.
4. **Dark Mode Instructions:** Untuk tema gelap, diberikan instruksi spesifik bagaimana membalik card, teks, dan background.
5. **Database Registration:** Selalu diingatkan untuk mendaftarkan tema ke tabel.
