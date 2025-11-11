> ⚠️ **INTERNAL INSTRUCTION FILE – DO NOT DUPLICATE OR RECREATE DOCUMENTATION**  
> File ini berfungsi sebagai pedoman desain resmi untuk AI dan tim frontend.  
> **Jangan buat dokumentasi baru, update atau ganti file ini tanpa alasan yang jelas.**  
> Seluruh perubahan harus melalui evaluasi desain dan UX consistency review.

---

# 🧭 Peran

Bertindak sebagai **Senior Frontend dan UI/UX Expert** yang merancang keseluruhan **Landing Experience Gunung**, meliputi:

-   Halaman **Home**
-   Halaman **Booking**
-   Halaman **Login**
-   Halaman **Profile**

AI bertugas sebagai **partner desain kritis**, yang:

-   Mengevaluasi ide UI, animasi, dan interaksi.
-   Memastikan estetika tetap kuat & minimalis (Swiss Design).
-   Menjaga performa mobile.
-   Menjamin pengalaman pengguna terasa alami dan kohesif di semua halaman.

---

# 🌋 Konsep Visual Umum

> “Sejernih udara gunung — visual besar, teks sedikit, dan ritme yang tenang.”

### Prinsip utama:

1. **Image-focused** — foto hero dan background besar menjadi elemen utama.
2. **Swiss Design grid** — proporsi simetris, ruang putih luas, tipografi tegas.
3. **Mobile-first** — fokus pada pengalaman vertikal dan kenyamanan scroll.
4. **Light motion** — animasi lembut dan bermakna (Anime.js / Three.js).
5. **Flexible theme** — tiap gunung memiliki warna dan gambar hero sendiri, tapi layout tetap sama.

---

# 🧱 Struktur Global

[Navbar minimal]
├─ Logo gunung / nama
├─ Link (Home, Booking, Profile)
└─ Icon Login/Profile
↓
[Page Content (berbeda tiap halaman)]
↓
[Footer universal]
├─ Sosial media
├─ Tombol Pengaduan
└─ Hak cipta

> Navbar dan footer **tetap sama** di semua halaman — hanya warna dan konten dinamis sesuai gunung.

---

# 🏠 Halaman Home

### Tujuan

Memperkenalkan gunung dan mengajak pengguna untuk mulai pendakian.

### Struktur

1. **Hero Section**
    - Foto penuh layar.
    - Nama gunung, status (Open/Closed), CTA “Mulai Pendakian”.
2. **Quick Stats**
    - Tinggi, suhu, jumlah pendaki aktif, cuaca.
3. **Pricing & Regulation Preview**
    - 2–3 poin ringkas, tombol menuju Booking.
4. **Gallery Teaser**
    - 3–4 foto horizontal scroll, animasi fade-up.
5. **FAQ Ringkas**
    - 2–3 pertanyaan umum.
6. **Footer**
    - Tombol pengaduan (floating di mobile).

### Interaksi & Motion

-   Scroll-snap lembut antar-section.
-   Fade-up muncul saat viewport aktif.
-   Hero dengan **parallax slow scroll** (Three.js atau CSS transform).

---

# 📅 Halaman Booking

### Tujuan

Memesan jadwal pendakian secara online.

### Struktur

-   **Header foto pendek (mini hero)** “Booking Pendakian”.
-   **Step Form (3 langkah)**:
    1. Pilih tanggal & jalur.
    2. Isi data pendaki.
    3. Konfirmasi & pembayaran.
-   Progress bar horizontal di atas form.
-   Kartu transparan, `rounded-2xl`, bayangan halus.
-   Tombol CTA sticky di bawah layar mobile.

### Animasi

-   Transisi antar langkah → _slide left/right_ (Anime.js).
-   Validasi sukses → tombol berganti warna.
-   Success page → overlay fade-in + scale.

### UX Prinsip

-   Satu langkah satu fokus.
-   Input besar (48px min).
-   Validasi real-time tanpa reload.

---

# 🔐 Halaman Login

### Tujuan

User masuk untuk mengakses profile & booking history.

### Layout

-   Kartu tengah di atas background blur hero image.
-   Elemen:
    -   Logo kecil gunung.
    -   Input email & password.
    -   Tombol “Masuk”.
    -   Link “Daftar” kecil.
-   Warna tombol = `brand_accent`.

### Motion

-   Card muncul dengan **fade-up (200ms)**.
-   Fokus input → **border glow lembut**.
-   Transisi ke halaman berikut → **fade to black → fade-in**.

### UX Prinsip

-   Clean, tenang, tanpa distraksi.
-   Pesan error singkat, kontras tinggi.
-   Warna dan kontras menyesuaikan tema gunung.

---

# 👤 Halaman Profile

### Tujuan

Menampilkan data pengguna, riwayat, dan status pendakian aktif.

### Isi

1. **Header Profile**
    - Avatar, nama, level pendakian.
    - Tombol logout kecil.
2. **Booking History**
    - Kartu daftar pendakian, expandable untuk detail.
3. **Active Tracking**
    - Peta mini atau snapshot posisi terakhir.
    - Tombol “Lihat Detail Tracking”.
4. **Footer**
    - Tombol pengaduan & sosial media.

### Motion

-   Kartu fade-in staggered.
-   Expand → animasi height easing (300ms).
-   Hover desktop → lift subtle (translateY-2, shadow-sm).

### UX Prinsip

-   Informasi penting di atas.
-   Rata kiri, grid sejajar.
-   Tombol pengaduan selalu terlihat.

> **Update:** Halaman profile telah diperbarui menjadi menu navigasi sederhana dengan link ke Riwayat Booking, Pengaturan, dan Bantuan. Active tracking dipindahkan ke halaman terpisah.

---

# 📋 Halaman Booking History

### Tujuan

Menampilkan semua riwayat pendakian pengguna dengan filter dan status tracking.

### Isi

1. **Header**
    - Background Navy (#1B4965).
    - Back button ke `/profile`.
    - Judul "RIWAYAT BOOKING" dengan huruf kapital.
2. **Stats Bar**
    - Background Sky Blue (#CAE9FF).
    - Total booking, Selesai, Aktif dengan angka besar.
    - Icon dengan background putih.
3. **Filter Panel**
    - Collapsible dengan tombol toggle.
    - 4 tombol status: Semua, Aktif, Selesai, Dibatalkan.
    - Active state dengan background Navy (#1B4965).
4. **Booking Cards**
    - **Status Aktif:** Border Yellow (#FFD166), header yellow.
    - **Status Selesai:** Border gray-200, badge hijau.
    - Info per card:
        - Nama gunung (uppercase, bold).
        - Tanggal dengan icon calendar.
        - Jumlah pendaki dengan icon users.
        - Total biaya dengan icon wallet (background Sky Blue).
    - Action buttons:
        - **Aktif:** Detail + Tracking.
        - **Selesai:** Detail + Rating.
    - Rating display dengan 5 bintang Yellow (#FFD166).
5. **Empty State**
    - Icon gunung besar.
    - Pesan "Belum ada riwayat booking".
    - CTA "Mulai Booking" dengan background Navy.

### Motion

-   Cards fade-in dengan stagger delay (0.1s, 0.2s, 0.3s).
-   Filter panel slide down/up dengan ease-in-out (300ms).
-   Hover effect pada cards → shadow-lg.
-   Active button → scale 0.95.

### Color Coding

-   **Status Aktif:** Border & header #FFD166 (Yellow).
-   **Status Selesai:** Border gray-200, badge green-500.
-   **Status Dibatalkan:** Badge red-500.
-   **Icon backgrounds:** Sky Blue (#CAE9FF).
-   **Rating stars:** #FFD166 (Yellow).

### UX Prinsip

-   Status visual jelas dengan color coding.
-   Informasi penting (gunung, tanggal) di awal card.
-   Action buttons proporsional dan accessible (min 44px).
-   Filter mudah diakses tapi tidak menghalangi konten.
-   Empty state memberikan CTA yang jelas.

---

# 🚨 Tombol Pengaduan (Global Component)

-   **Bentuk:** bulat (56px), ikon alert minimalis.
-   **Posisi:** `fixed bottom-right` di mobile, `footer kanan` di desktop.
-   **Warna:** `brand_accent`.
-   **Animasi:**
    -   Subtle pulse setiap 6 detik.
    -   Hover → scale 1.05 + glow lembut.
-   **Fungsi:** buka modal dengan form laporan (judul, deskripsi, foto).
-   Modal muncul dengan **fade + scale-in (300ms)**.

---

# ✨ Motion & Interaction System

| Elemen                   | Library        | Efek                       | Durasi    |
| ------------------------ | -------------- | -------------------------- | --------- |
| Section in view          | Anime.js       | Fade-up sequential         | 250–350ms |
| Transition antar halaman | Anime.js       | Fade to black → fade-in    | 400ms     |
| Hero background          | Three.js       | Parallax slow / fog noise  | real-time |
| Form step                | Anime.js       | Slide left/right + opacity | 300ms     |
| Gallery                  | Anime.js       | Staggered fade-in          | 250ms     |
| Buttons                  | CSS + Anime.js | Hover scale + shadow fade  | 200ms     |
| Modal                    | Anime.js       | Scale-in + blur fade       | 300ms     |

> Semua efek mengikuti `prefers-reduced-motion` untuk aksesibilitas.

---

# 🎨 Visual Identity

| Aspek                     | Pedoman                                                |
| ------------------------- | ------------------------------------------------------ |
| **Font**                  | Jost / Satoshi / Neue Haas Grotesk                     |
| **Warna**                 | Token `brand_primary`, `brand_accent`, `brand_surface` |
| **Kontras teks**          | Minimal 4.5:1 (WCAG AA)                                |
| **Grid**                  | 8pt baseline, gutter 24px                              |
| **Icons**                 | Lucide outline, 1px stroke                             |
| **Spacing antar section** | 4rem (mobile) – 6rem (desktop)                         |
| **Image overlay**         | Gradient hitam lembut (opacity 40%)                    |
| **Footer tone**           | Lebih gelap dari surface utama                         |

---

# 🧠 UX Philosophy

1. **Konsistensi lintas halaman** — user selalu tahu posisinya.
2. **Gerakan kecil, konteks besar** — transisi menjelaskan arah navigasi.
3. **Mobile comfort first** — semua tombol besar dan nyaman disentuh.
4. **Visual rhythm** — foto besar → teks kecil → spasi → aksi.
5. **Satu layout, banyak kepribadian** — tiap gunung unik tanpa memecah desain global.

---

# ✅ Prinsip Kualitas

-   Indah, efisien, dan ringan.
-   Semua halaman cepat di-load.
-   Elemen memiliki fungsi yang jelas.
-   Animasi minimalis dan bermakna.
-   Tombol pengaduan selalu mudah dijangkau.
-   Layout seragam di seluruh halaman.
-   Tetap Swiss: tegas, bersih, menghormati ruang kosong.
