# Panduan Step-by-Step: Pasar Warga
### Direktori & Marketplace UMKM Lokal

**Tujuan project:** Website yang menghubungkan warga dengan UMKM/usaha kecil di sekitar tempat tinggal mereka, sekaligus membantu pelaku usaha lokal (yang sering dijalankan perorangan) lebih mudah ditemukan pembeli baru.

**Tech stack yang direkomendasikan:**
- Backend: Laravel 10/11
- Database: MySQL
- Frontend: Blade + Tailwind CSS (atau Bootstrap kalau lebih familiar)
- Auth: Laravel Breeze (starter kit ringan, cocok buat role-based access)

> Kalau kamu lebih nyaman pakai CodeIgniter, struktur fase di bawah tetap sama — cuma bagian migration/model/middleware diganti jadi model CI + custom auth.

---

## Fase 0: Persiapan Environment

- [ ] Install PHP (≥8.1), Composer, Node.js
- [ ] Install Laragon/XAMPP (buat local server + MySQL)
- [ ] Install Laravel installer: `composer global require laravel/installer`
- [ ] Siapkan code editor (VS Code) + extension Laravel/Blade
- [ ] Buat repo GitHub baru buat backup progress & portofolio

---

## Fase 1: Perencanaan & Desain (jangan skip fase ini!)

- [ ] Tulis daftar fitur, pisahkan **Must Have** (wajib ada buat demo) vs **Nice to Have** (kalau waktu sisa)
- [ ] Gambar ERD (skema di bawah) di draw.io / kertas / Figma
- [ ] Sketsa wireframe kasar untuk halaman: landing, list toko, detail toko, dashboard admin, dashboard pemilik toko
- [ ] Tulis user flow tiap role (admin, pemilik toko, warga) — ini juga bahan bagus buat dijelasin pas wawancara

**Skema ERD:**

```
users        : id, name, email, password, role (admin/pemilik_toko/warga)
tokos        : id, user_id (FK), nama_toko, deskripsi, lokasi, no_wa, foto, status
kategoris    : id, nama
produks      : id, toko_id (FK), kategori_id (FK), nama_produk, deskripsi, harga, stok, foto
ulasans*     : id, produk_id (FK), user_id (FK), rating, komentar   (*opsional)
```

---

## Fase 2: Setup Project Laravel

```bash
laravel new pasar-warga
cd pasar-warga
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
```

- [ ] Setup `.env` — sesuaikan `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- [ ] Buat database kosong di phpMyAdmin/MySQL Workbench
- [ ] Jalankan `php artisan migrate` (pastikan koneksi DB sukses)
- [ ] Init git: `git init`, commit pertama, push ke GitHub

---

## Fase 3: Database & Model

- [ ] Tambah kolom `role` ke tabel users:
```bash
php artisan make:migration add_role_to_users_table --table=users
```
```php
$table->enum('role', ['admin', 'pemilik_toko', 'warga'])->default('warga');
```

- [ ] Buat migration + model untuk `Toko`, `Kategori`, `Produk`:
```bash
php artisan make:model Toko -m
php artisan make:model Kategori -m
php artisan make:model Produk -m
```

- [ ] Isi migration sesuai skema ERD di Fase 1 (kolom `foreignId()->constrained()` untuk relasi)
- [ ] Definisikan relasi di model:
```php
// User.php
public function toko() { return $this->hasOne(Toko::class); }

// Toko.php
public function user() { return $this->belongsTo(User::class); }
public function produks() { return $this->hasMany(Produk::class); }

// Produk.php
public function toko() { return $this->belongsTo(Toko::class); }
public function kategori() { return $this->belongsTo(Kategori::class); }
```

- [ ] Buat seeder untuk data dummy (kategori, beberapa toko & produk contoh)
```bash
php artisan make:seeder KategoriSeeder
php artisan db:seed
```

---

## Fase 4: Auth & Role Management

- [ ] Buat middleware role:
```bash
php artisan make:middleware CheckRole
```
```php
public function handle($request, Closure $next, ...$roles)
{
    if (!in_array(auth()->user()->role, $roles)) {
        abort(403, 'Akses ditolak');
    }
    return $next($request);
}
```
- [ ] Daftarkan middleware di `bootstrap/app.php` (Laravel 11) atau `Kernel.php` (Laravel 10)
- [ ] Redirect user setelah login sesuai role (cek di `RouteServiceProvider` atau controller login)
- [ ] Buat halaman register khusus "Daftar sebagai Pemilik Usaha" (set role otomatis)

---

## Fase 5: Fitur Inti (CRUD)

- [ ] **Admin**: CRUD kategori, approve/reject pendaftaran toko baru
- [ ] **Pemilik toko**: CRUD profil toko (nama, deskripsi, lokasi, no WA, foto)
- [ ] **Pemilik toko**: CRUD produk (nama, harga, stok, kategori, foto)
- [ ] Validasi form di tiap Controller (`$request->validate([...])`)
- [ ] Upload foto pakai `Storage::disk('public')` + `php artisan storage:link`

Contoh route grup by role:
```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('kategoris', KategoriController::class);
});

Route::middleware(['auth', 'role:pemilik_toko'])->group(function () {
    Route::resource('produk', ProdukController::class);
});
```

---

## Fase 6: Fitur Pencarian (untuk warga — ini fitur "wajah depan" website)

- [ ] Halaman landing: tampilkan toko/produk terbaru (tanpa perlu login)
- [ ] Search bar (nama produk/toko) — `WHERE nama_produk LIKE '%keyword%'`
- [ ] Filter by kategori & lokasi
- [ ] Halaman detail toko (info + list produk toko itu)
- [ ] Halaman detail produk
- [ ] Tombol **"Hubungi via WhatsApp"** — cukup pakai link, gak perlu API:
```php
<a href="https://wa.me/62{{ $toko->no_wa }}?text=Halo, saya mau tanya soal {{ $produk->nama_produk }}">
    Hubungi via WhatsApp
</a>
```

---

## Fase 7: Fitur Tambahan (opsional — nilai plus kalau waktu cukup)

- [ ] Rating & ulasan toko/produk
- [ ] Dashboard statistik toko pakai Chart.js (produk terlaris, jumlah dilihat)
- [ ] Fitur favorit/wishlist untuk warga (butuh login)
- [ ] Notifikasi WhatsApp otomatis pakai API Fonnte saat ada yang minat produk
- [ ] Export laporan penjualan ke PDF (`barryvdh/laravel-dompdf`)

---

## Fase 8: Styling & UI Polish

- [ ] Rapikan tampilan pakai Tailwind (card produk, navbar, form)
- [ ] Cek responsive di HP — warga kemungkinan besar akses dari mobile
- [ ] Konsistensi warna & komponen di semua halaman
- [ ] Tambah empty state ("Belum ada produk") biar gak keliatan error saat data kosong

---

## Fase 9: Testing

- [ ] Test manual tiap role: login, CRUD, search, filter
- [ ] Cek validasi form (input kosong, harga negatif/nol, upload file salah format)
- [ ] Cek middleware — pastikan warga **tidak bisa** akses dashboard admin/toko lewat URL langsung
- [ ] Cek relasi data — hapus toko harus ikut hapus/handle produk di dalamnya

---

## Fase 10: Dokumentasi & Persiapan Wawancara/UKK

- [ ] Tulis laporan project: latar belakang masalah, tujuan, fitur, ERD, screenshot tiap halaman
- [ ] Siapkan 3 akun demo (admin, pemilik toko, warga) dengan data yang sudah terisi rapi — jangan demo pakai database kosong
- [ ] Susun skenario demo runtut, misalnya:
  1. Login sebagai pemilik toko → tambah produk baru
  2. Logout → login sebagai warga → cari produk itu lewat search
  3. Klik detail produk → klik "Hubungi via WhatsApp"
  4. Login sebagai admin → tunjukkan approval toko baru
- [ ] Siapkan pitch 1 kalimat: *"Pasar Warga bantu warga nemuin dan pesen produk dari UMKM sekitar rumah mereka, karena selama ini banyak UMKM lokal gak keliatan online sama sekali."*
- [ ] Antisipasi pertanyaan "kenapa gak pakai Shopee/Tokopedia aja?" → jawaban: fokus **hyperlocal**, UMKM kecil gak perlu bersaing sama seller se-Indonesia

---

## Fase 11: Deployment ke Google Cloud (Compute Engine e2-micro)

> Pakai e2-micro + region us-west1/us-central1/us-east1 supaya tetap masuk **Always Free tier** (gratis selamanya, bukan cuma 90 hari kredit trial).

### 11.1 Buat Akun & Project Google Cloud

**a. Daftar akun & mulai Free Trial**
- [ ] Buka [console.cloud.google.com](https://console.cloud.google.com), login pakai akun Google
- [ ] Terima Google Cloud Terms of Service
- [ ] Isi info kartu kredit/debit buat verifikasi (gak langsung ditagih, dapat kredit $300 gratis)

**b. Buat Project baru**
- [ ] Klik **Project Selector** (dropdown di pojok kiri atas, tulisan "Select a project")
- [ ] Klik **New Project** di kanan atas
- [ ] Isi **Project name** (misal: `pasar-warga`)
- [ ] Catat **Project ID** yang otomatis di-generate (dipakai lagi kalau nanti pakai `gcloud` CLI)
- [ ] Pastikan **Billing account** sudah terpilih
- [ ] Klik **Create**, tunggu sampai project jadi dan aktif di Project Selector

**c. Aktifkan Compute Engine API**
- [ ] Di search bar atas, ketik "Compute Engine API" → klik hasil pertama → klik **Enable**
- [ ] Tunggu proses aktivasi (beberapa detik sampai menit)

### 11.2 Buat VM Instance
- [ ] Console → **Compute Engine → VM Instances → Create Instance**
- [ ] Machine type: `e2-micro`
- [ ] Region: `us-west1`, `us-central1`, atau `us-east1` (wajib salah satu ini biar gratis)
- [ ] Boot disk: **Ubuntu 22.04 LTS**, 30 GB standard persistent disk
- [ ] Centang **Allow HTTP traffic** dan **Allow HTTPS traffic**
- [ ] Klik Create, tunggu VM jadi

### 11.3 SSH ke VM
- [ ] Klik tombol **SSH** di samping VM (langsung buka terminal via browser, gak perlu setup key manual)

### 11.4 Install LEMP Stack
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install nginx mysql-server php-fpm php-mysql php-mbstring php-xml php-bcmath php-curl git unzip -y
```

### 11.5 Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 11.6 Setup Database
```bash
sudo mysql_secure_installation
sudo mysql -u root -p
```
```sql
CREATE DATABASE pasar_warga;
CREATE USER 'pasarwarga'@'localhost' IDENTIFIED BY 'password_kuat_kamu';
GRANT ALL PRIVILEGES ON pasar_warga.* TO 'pasarwarga'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 11.7 Upload Project (via GitHub)
```bash
cd /var/www
sudo git clone https://github.com/username-kamu/pasar-warga.git
cd pasar-warga
sudo composer install --optimize-autoloader --no-dev
```

### 11.8 Setup Laravel
```bash
cp .env.example .env
php artisan key:generate
nano .env   # isi DB_DATABASE, DB_USERNAME, DB_PASSWORD sesuai step 11.6
php artisan migrate --seed
php artisan storage:link
sudo chown -R www-data:www-data /var/www/pasar-warga
sudo chmod -R 775 storage bootstrap/cache
```

### 11.9 Konfigurasi Nginx
```bash
sudo nano /etc/nginx/sites-available/pasar-warga
```
Isi dengan config server block yang mengarah ke `/var/www/pasar-warga/public` dan meneruskan `.php` ke socket php-fpm.

```bash
sudo ln -s /etc/nginx/sites-available/pasar-warga /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 11.10 Akses Website
- [ ] Cek **External IP** VM di Console → akses `http://[IP-VM]` di browser
- [ ] (Opsional) kalau punya domain: arahkan A record ke IP VM, lalu install Certbot buat SSL gratis (`sudo apt install certbot python3-certbot-nginx`)

### Catatan Penting
- [ ] Cek **Billing → Reports** secara berkala buat mastiin gak ada biaya tak terduga
- [ ] Jangan ganti machine type ke yang lebih besar dari e2-micro kalau mau tetap gratis
- [ ] Kalau project udah selesai dinilai dan gak dipakai lagi, pertimbangkan **Stop** (bukan cuma delete file) VM instance-nya

---

## Estimasi Timeline (contoh untuk ~5 minggu pengerjaan)

| Minggu | Fase | Fokus |
|---|---|---|
| 1 | 0–2 | Setup environment, planning, ERD, wireframe |
| 2 | 3–4 | Database, model, auth & role |
| 3 | 5 | CRUD toko, produk, kategori |
| 4 | 6–7 | Search, filter, fitur tambahan |
| 5 | 8–10 | Styling, testing, dokumentasi, latihan demo & wawancara |

---

## Catatan Penting

Jangan tunggu semua fitur "sempurna" baru mulai latihan demo — di minggu ke-4, coba jalankan skenario demo di Fase 10 walaupun fiturnya belum lengkap. Ini bantu kamu nemuin bug/alur yang aneh lebih awal, sebelum hari-H wawancara.