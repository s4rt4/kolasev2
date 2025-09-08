# 🎨 Kolase Foto v2

Proyek web aplikasi untuk menampilkan **kolase foto dinamis** dengan fitur galeri modern + panel **admin** untuk mengelola foto, kategori, fotografer, dan laporan statistik.



---

## 🚀 Fitur

### 🌐 Frontend (Pengunjung)
- **Kolase dinamis** dengan [Masonry.js] → tata letak rapat & responsif.
- **Lightbox cantik** dengan [LightGallery]:
  - Navigasi next / prev
  - Slideshow otomatis
  - Zoom & fullscreen
  - Thumbnail preview
  - Download foto
- **Filter & Pencarian**:
  - Berdasarkan kategori
  - Berdasarkan fotografer
  - Berdasarkan judul
  - Berdasarkan tanggal
- **Tema Gelap / Terang** (toggle 1 klik).
- **Navbar modern** dengan tombol filter sidebar (gaya e-commerce).
- **Tombol Refresh** untuk randomisasi ulang kolase.
- **Tombol Kembali ke Atas** (smooth scroll).

### 🔑 Admin Panel
- **Dashboard ringkas**:
  - Total foto, kategori, fotografer
  - Grafik **donut** distribusi foto per kategori
  - Grafik **batang** jumlah upload per bulan
  - Pencarian cepat (langsung scroll ke hasil “Foto Terbaru”)
- **Manajemen Data**:
  - Upload foto baru
  - CRUD kategori
  - CRUD fotografer
  - Daftar foto dengan preview, edit, dan hapus
  - Penomoran otomatis + jumlah foto ditampilkan
- **UI Modern**:
  - Sidebar gradient tetap (fixed)
  - Sidebar collapsible dengan tombol hamburger
  - Konten responsif (mobile & desktop)

---

## 📂 Struktur Folder

| File / Folder        | Deskripsi |
|----------------------|-----------|
| `index.html`         | Halaman utama galeri frontend |
| `style.css`          | CSS frontend |
| `script.js`          | Logika frontend (Masonry, filter, dll) |
| `uploads/`           | Folder tempat file foto yang diupload |
| `admin/`             | Folder panel admin |
| ├── `dashboard.php`  | Halaman utama admin (statistik & grafik) |
| ├── `foto.php`       | Manajemen daftar foto |
| ├── `upload.php`     | Form upload foto |
| ├── `kategori.php`   | CRUD kategori |
| ├── `fotografer.php` | CRUD fotografer |
| ├── `edit_foto.php`  | Form edit data foto |
| ├── `navbar.php`     | Sidebar + layout utama admin |
| `dist/`              | Library lokal (Bootstrap, Font Awesome, Chart.js, Masonry, LightGallery) |
| `config.php`         | Koneksi database |
| `README.md`          | Dokumentasi proyek |

---

## 🛠️ Teknologi
- **Frontend:** HTML5, CSS3, Vanilla JavaScript
- **Backend:** PHP 8+, MySQL/MariaDB
- **Library:**
  - [Masonry.js](https://masonry.desandro.com/) → layout kolase
  - [ImagesLoaded](https://imagesloaded.desandro.com/) → sinkronisasi loading gambar
  - [LightGallery](https://www.lightgalleryjs.com/) → lightbox interaktif
  - [Bootstrap 5](https://getbootstrap.com/) → UI responsif
  - [Font Awesome](https://fontawesome.com/) → ikon modern
  - [Chart.js](https://www.chartjs.org/) → grafik admin

---

## 🙏 Kredit Foto
- Foto berasal dari [Unsplash](https://unsplash.com/)

---
