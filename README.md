# Pasar Warga 🛒

**Direktori & marketplace hyperlocal** yang menghubungkan warga dengan UMKM/usaha kecil di sekitar tempat tinggal mereka. Warga menemukan produk dari tetangga sendiri, langsung memesan di aplikasi, dan penjual menkonfirmasi pesanan dari dashboard mereka.

> *"Pasar Warga bantu warga nemuin dan pesen produk dari UMKM sekitar rumah mereka, karena selama ini banyak UMKM lokal gak keliatan online sama sekali."*

## Fitur

- **Katalog publik** — search produk/toko, filter kategori, harga, dan lokasi (hanya toko yang sudah disetujui admin yang tampil).
- **Autentikasi & role** — `admin`, `pemilik_toko`, `warga`, dan guest read-only.
- **Pemilik Toko** — daftarkan toko, kelola profil & produk, konfirmasi/tolak pesanan masuk.
- **Warga** — tambah ke keranjang, checkout, pantau status pesanan.
- **Admin** — approve/reject pendaftaran toko, kelola kategori & pengguna.
- **Hubungi via WhatsApp** — tombol `wa.me` ke penjual sebagai kanal kontak tambahan.

## Tech Stack

- **Backend:** Laravel 13
- **Database:** PostgreSQL (Supabase pooler)
- **Frontend:** Blade + Tailwind CSS v4 + Vite
- **Auth:** Custom (role-based middleware)

## Setup Lokal

```bash
# 1. Install dependencies
composer install
npm install

# 2. Siapkan environment
cp .env.example .env
php artisan key:generate
# isi DB_DATABASE, DB_USERNAME, DB_PASSWORD di .env

# 3. Migrasi + seed data demo
php artisan migrate --seed
php artisan storage:link

# 4. Build & jalankan
npm run build
php artisan serve
# atau: npm run dev (hot reload)
```

Akses di `http://localhost:8000`.

## Akun Demo

Semua password: `password`

| Role         | Email                |
|--------------|----------------------|
| Admin        | `admin@pasarwarga.test` |
| Pemilik Toko | `busari@pasarwarga.test` |
| Pemilik Toko (pending) | `kakdinda@pasarwarga.test` |
| Warga        | `andi@pasarwarga.test` |

## Skenario Demo

1. Login sebagai **pemilik toko** (`busari@pasarwarga.test`) → dashboard menunjukkan pesanan masuk → konfirmasi/tolak pesanan.
2. Login sebagai **warga** (`andi@pasarwarga.test`) → cari produk → tambah ke keranjang → checkout → lihat pesanan.
3. Login sebagai **admin** → approve toko menunggu persetujuan → kelola kategori.

## Struktur Project

- `app/Http/Controllers/` — `Auth/`, `Admin/`, `Toko/` (per-role controllers)
- `app/Models/` — `Toko`, `Kategori`, `Produk`, `Pesanan`, `PesananItem`
- `app/Services/` — `CartService`, `FileService`
- `resources/views/` — `layouts/` (app & auth), `components/`, `pages/` per-domain
- `database/seeders/` — data demo untuk 3 role

## Lisensi

Dikembangkan untuk USaha Kecil & Menengah (UMKM) lokal. MIT License.