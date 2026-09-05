# Daftar Lengkap Fitur & Halaman — Pasar Warga

## Ringkasan Project
Pasar Warga adalah direktori & marketplace hyperlocal yang menghubungkan warga dengan UMKM/usaha kecil di sekitar tempat tinggal mereka.

## Role & Hak Akses

| Role | Deskripsi | Hak akses utama |
|---|---|---|
| **Admin** | Pengelola platform | Approve/reject toko baru, kelola kategori, kelola user |
| **Pemilik Toko** | Pelaku UMKM | Kelola profil toko, kelola produk, lihat statistik toko |
| **Warga** | Pembeli/pengguna umum | Cari & lihat produk/toko, hubungi penjual, simpan favorit |
| **Guest** (belum login) | Pengunjung | Lihat katalog & detail produk/toko (read-only) |

---

## Site Map / Daftar Halaman

### Halaman Publik (tanpa login)
1. **Beranda** — highlight toko/produk terbaru
2. **Katalog Produk** — daftar semua produk + search & filter
3. **Detail Toko** — profil toko + list produk milik toko itu
4. **Detail Produk** — info lengkap produk + tombol hubungi WA
5. **Login**
6. **Register** — pilih daftar sebagai Warga atau Pemilik Usaha

### Halaman Warga (role: warga)
7. **Profil Akun** — edit nama, email, password
8. **Favorit/Wishlist** *(opsional)*

### Halaman Pemilik Toko (role: pemilik_toko)
9. **Dashboard Toko** — ringkasan jumlah produk & status toko
10. **Kelola Profil Toko** — create/edit nama, deskripsi, lokasi, no WA, foto
11. **Kelola Produk** — list, tambah, edit, hapus produk
12. **Statistik Toko** *(opsional)* — produk terlaris, jumlah dilihat
13. **Laporan Penjualan** *(opsional)* — export ke PDF

### Halaman Admin (role: admin)
14. **Dashboard Admin** — ringkasan jumlah toko/produk/user
15. **Approval Toko** — approve/reject pendaftaran toko baru
16. **Kelola Kategori** — CRUD kategori produk
17. **Kelola User** *(opsional)* — lihat & nonaktifkan user

---

## Daftar Fitur Lengkap

### Autentikasi & Role
- [ ] Register (2 jalur: warga / pemilik usaha)
- [ ] Login/logout
- [ ] Role-based middleware (admin/pemilik_toko/warga)
- [ ] Redirect otomatis ke dashboard sesuai role setelah login

### Manajemen Toko
- [ ] Create/edit profil toko (nama, deskripsi, lokasi, no WA, foto)
- [ ] Status toko: pending → approved/rejected (dikontrol admin)
- [ ] Toko yang belum di-approve tidak muncul di katalog publik

### Manajemen Produk
- [ ] CRUD produk (nama, deskripsi, harga, stok, kategori, foto)
- [ ] Produk terhubung ke toko & kategori

### Manajemen Kategori
- [ ] CRUD kategori (admin only)

### Pencarian & Penemuan
- [ ] Search by nama produk/toko
- [ ] Filter by kategori
- [ ] Filter by lokasi
- [ ] Filter by rentang harga

### Kontak & Transaksi
- [ ] Tombol "Hubungi via WhatsApp" (link wa.me, prefill pesan)

### Fitur Tambahan (Nice to Have)
- [ ] Rating & ulasan toko/produk
- [ ] Dashboard statistik toko (Chart.js)
- [ ] Favorit/wishlist untuk warga
- [ ] Notifikasi WhatsApp otomatis (API Fonnte) saat ada yang minat produk
- [ ] Export laporan penjualan ke PDF

---

## Entitas Database (Ringkasan ERD)

```
users     : id, name, email, password, role (admin/pemilik_toko/warga)
tokos     : id, user_id (FK), nama_toko, deskripsi, lokasi, no_wa, foto, status
kategoris : id, nama
produks   : id, toko_id (FK), kategori_id (FK), nama_produk, deskripsi, harga, stok, foto
ulasans*  : id, produk_id (FK), user_id (FK), rating, komentar   (*opsional)
```

---

## Alur Pengguna Utama (User Flow)

**Warga mencari produk:**
Beranda → Katalog/Search → Detail Produk → Klik "Hubungi via WhatsApp"

**Pemilik usaha mendaftar & jualan:**
Register (Pemilik Usaha) → menunggu approval admin → Login → Buat Profil Toko → Tambah Produk → Produk muncul di katalog publik

**Admin approve toko baru:**
Login Admin → Dashboard → Approval Toko → Approve/Reject

---

## Tech Stack
- Backend: Laravel 10/11
- Database: MySQL
- Frontend: Blade + Tailwind CSS
- Auth: Laravel Breeze
- Hosting: Google Cloud Compute Engine (e2-micro)