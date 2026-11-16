# 🎮 FawThar Top Up - Game Top-Up & Digital Voucher Platform

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

**FawThar Top Up** adalah platform web modern untuk layanan top-up game online dan voucher digital secara instan, aman, dan responsif. Dirancang dengan UI/UX modern berbasis tema *Royal Electric Indigo*, sistem keamanan berlapis (WAF, rate limiting, sanitasi input), serta panel manajemen admin yang komprehensif.

---

## 🌟 Fitur Utama

### 👤 Pengguna & Pelanggan (Customer Experience)
- **Katalog Game Populer**: Pemilihan judul game instan (Mobile Legends, Free Fire, Genshin Impact, Valorant, dll.) dengan filter interaktif.
- **Form Top-Up Otomatis**: Input User ID & Server/Zone ID dengan validasi instan.
- **Pilihan Nominal Fleksibel**: Pilihan denominasi diamond / item dengan kartu harga dinamis.
- **Simulasi Pembayaran & Invoice Real-Time**: Halaman invoice terstruktur lengkap dengan simulasi status pembayaran langsung (*Pending*, *Success*, *Expired*).
- **Autentikasi Multi-Metode**:
  - Login / Register standar dengan proteksi puzzle captcha & throttling.
  - **Google OAuth 2.0**: Masuk cepat menggunakan akun Google resmi.
  - **Pemulihan Password (OTP Email)**: Reset password menggunakan kode OTP 6-digit via SMTP email.
- **Profil & Portal Pengguna**: Riwayat transaksi, pengaturan akun, dan update password pribadi.
- **Multilingual Support**: Tombol pengalih bahasa instan (Bahasa Indonesia & English).
- **Dark Mode / Light Mode**: Tampilan tema yang ramah di mata dengan tombol switch dinamis.

---

### 🛡️ Admin Control Center
- **Dashboard Statistik**: Ringkasan performa penjualan, total order, total game, dan pengguna aktif.
- **Manajemen Game & Kategori**: Tambah, edit, aktif/nonaktifkan status game beserta banner dan instruksi ID game.
- **Manajemen Produk & Denominasi**: Kelola paket diamond/voucher per game dengan pengaturan status aktif.
- **Kelola Order & Transaksi**: Pantau daftar invoice, update status transaksi, dan detail pembayaran pembeli.
- **Pusat FAQ**: Manajemen tanya-jawab dinamis yang langsung tampil di halaman depan.
- **Activity Logs**: Pencatatan aktivitas audit log untuk keamanan platform.
- **Pengaturan Sistem & Branding**: Kustomisasi logo website, nama situs, kontak bantuan, dan konfigurasi WAF.

---

## 🛠️ Tech Stack

- **Backend Framework**: [Laravel 10](https://laravel.com/)
- **Frontend / Styling**: [Tailwind CSS](https://tailwindcss.com/), Blade Templating, Alpine.js
- **Database**: MySQL / MariaDB
- **Authentication**: Laravel Session Auth, Laravel Socialite (Google OAuth), SMTP Mailer
- **Build Tool**: Vite

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal (misal: Laragon / XAMPP):

### 1. Clone Repository
```bash
git clone https://github.com/gueewazz19/FawThar-Top-Up-.git
cd FawThar-Top-Up-
```

### 2. Install Dependency PHP & Node.js
```bash
composer install
npm install
```

### 3. Konfigurasi Environment (`.env`)
Duplikasi file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Generate App Key:
```bash
php artisan key:generate
```

Sesuaikan konfigurasi database dan kredensial di file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fawthar_topup
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Migrasi & Seeder Database
Jalankan migrasi tabel beserta data demo bawaan:
```bash
php artisan migrate:fresh --seed
```

### 5. Kompilasi Aset Frontend & Jalankan Server
Jalankan Vite di terminal pertama:
```bash
npm run dev
```

Jalankan server Laravel di terminal kedua:
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

## 🔑 Akun Demo Default

Setelah menjalankan `php artisan db:seed`, kamu dapat masuk menggunakan akun default berikut:

| Peran (Role) | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@gametopup.test` | `password123` |
| **Customer** | `customer@gametopup.test` | `password123` |

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah lisensi [MIT](LICENSE).
Dikembangkan oleh **[@gueewazz19](https://github.com/gueewazz19)**.
