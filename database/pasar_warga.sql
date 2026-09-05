-- ============================================================================
--  PASAR WARGA - Struktur Database (MySQL)
--  Direktori & Marketplace UMKM Lokal (Hyperlocal)
-- ============================================================================
--  Cara pakai:
--    1. Buka phpMyAdmin (Laragon) -> tab "Import"
--    2. Pilih file ini -> klik "Go"
--    ATAU jalankan di terminal MySQL:
--      mysql -u root -p < database/pasar_warga.sql
-- ============================================================================
--
--  RELASI ANTAR TABEL:
--
--  users 1───1 tokos          (1 user pemilik_toko punya 1 toko)
--  tokos 1───* produks        (1 toko punya banyak produk)
--  kategoris 1───* produks    (1 kategori dipakai banyak produk)
--  users 1───* keranjangs     (warga menyimpan produk ke keranjang)
--  produks 1───* keranjangs
--  users 1───* pesanans       (warga membuat banyak pesanan)
--  tokos 1───* pesanans       (toko menerima banyak pesanan)
--  pesanans 1───* pesanan_items (detail produk di dalam 1 pesanan)
--  produks 1───* pesanan_items
--  users 1───* ulasans        (warga memberi ulasan)
--  produks 1───* ulasans
--  users 1───* favorits       (warga menyimpan favorit/wishlist)
--  produks 1───* favorits
-- ============================================================================

-- ----------------------------------------------------------------------------
-- 0. Buat database (skip kalau database sudah dibuat lewat phpMyAdmin)
-- ----------------------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS pasar_warga
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE pasar_warga;

-- ============================================================================
-- 1. TABEL BAWAAN LARAVEL (auth, session, cache, queue)
-- ============================================================================

-- ----------------------------------------------------------------------------
-- users : akun semua pengguna (admin, pemilik toko, warga)
-- ----------------------------------------------------------------------------
CREATE TABLE users (
    id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name              VARCHAR(255) NOT NULL,
    email             VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password          VARCHAR(255) NOT NULL,
    role              ENUM('admin', 'pemilik_toko', 'warga') NOT NULL DEFAULT 'warga',
    remember_token    VARCHAR(100) NULL,
    created_at        TIMESTAMP NULL,
    updated_at        TIMESTAMP NULL
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- password_reset_tokens : token reset password (default Laravel)
-- ----------------------------------------------------------------------------
CREATE TABLE password_reset_tokens (
    email      VARCHAR(255) PRIMARY KEY,
    token      VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- sessions : sesi login (default Laravel)
-- ----------------------------------------------------------------------------
CREATE TABLE sessions (
    id            VARCHAR(255) PRIMARY KEY,
    user_id       BIGINT UNSIGNED NULL,
    ip_address    VARCHAR(45) NULL,
    user_agent    TEXT NULL,
    payload       LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- cache & cache_locks : penyimpanan cache (default Laravel)
-- ----------------------------------------------------------------------------
CREATE TABLE cache (
    key        VARCHAR(255) PRIMARY KEY,
    value      MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL
) ENGINE = InnoDB;

CREATE TABLE cache_locks (
    key        VARCHAR(255) PRIMARY KEY,
    owner      VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- jobs, job_batches, failed_jobs : antrian pekerjaan (default Laravel)
-- ----------------------------------------------------------------------------
CREATE TABLE jobs (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue        VARCHAR(255) NOT NULL,
    payload      LONGTEXT NOT NULL,
    attempts     TINYINT UNSIGNED NOT NULL,
    reserved_at  INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at   INT UNSIGNED NOT NULL,
    INDEX jobs_queue_index (queue)
) ENGINE = InnoDB;

CREATE TABLE job_batches (
    id             VARCHAR(255) PRIMARY KEY,
    name           VARCHAR(255) NOT NULL,
    total_jobs     INT NOT NULL,
    pending_jobs   INT NOT NULL,
    failed_jobs    INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options        MEDIUMTEXT NULL,
    cancelled_at   INT NULL,
    created_at     INT NOT NULL,
    finished_at    INT NULL
) ENGINE = InnoDB;

CREATE TABLE failed_jobs (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid       VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue      TEXT NOT NULL,
    payload    LONGTEXT NOT NULL,
    exception  LONGTEXT NOT NULL,
    failed_at  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB;

-- ============================================================================
-- 2. TABEL BISNIS INTI
-- ============================================================================

-- ----------------------------------------------------------------------------
-- tokos : profil toko milik user ber-role 'pemilik_toko'
--         status 'pending' -> toko BELUM muncul di katalog publik
--         sampai di-approve admin.
-- ----------------------------------------------------------------------------
CREATE TABLE tokos (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    BIGINT UNSIGNED NOT NULL,
    nama_toko  VARCHAR(255) NOT NULL,
    slug       VARCHAR(255) NOT NULL UNIQUE COMMENT 'URL ramah SEO, mis. warung-bu-sari',
    deskripsi  TEXT NULL,
    lokasi     VARCHAR(255) NULL COMMENT 'Kecamatan/kota, dipakai untuk filter lokasi',
    no_wa      VARCHAR(20) NULL COMMENT 'Nomor WhatsApp untuk kontak, format 81234567890',
    foto       VARCHAR(255) NULL,
    status     ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT tokos_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    INDEX tokos_status_index (status),
    INDEX tokos_lokasi_index (lokasi)
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- kategoris : kategori produk, dikelola oleh admin
-- ----------------------------------------------------------------------------
CREATE TABLE kategoris (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama       VARCHAR(100) NOT NULL,
    slug       VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- produks : produk yang dijual oleh toko
-- ----------------------------------------------------------------------------
CREATE TABLE produks (
    id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    toko_id      BIGINT UNSIGNED NOT NULL,
    kategori_id  BIGINT UNSIGNED NULL,
    nama_produk  VARCHAR(255) NOT NULL,
    deskripsi    TEXT NULL,
    harga        DECIMAL(12, 2) NOT NULL DEFAULT 0 COMMENT 'Harga dalam Rupiah',
    stok         INT UNSIGNED NOT NULL DEFAULT 0,
    foto         VARCHAR(255) NULL,
    is_aktif     BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Sembunyikan produk tanpa hapus',
    created_at   TIMESTAMP NULL,
    updated_at   TIMESTAMP NULL,
    CONSTRAINT produks_toko_id_foreign
        FOREIGN KEY (toko_id) REFERENCES tokos (id) ON DELETE CASCADE,
    CONSTRAINT produks_kategori_id_foreign
        FOREIGN KEY (kategori_id) REFERENCES kategoris (id) ON DELETE SET NULL,
    INDEX produks_toko_id_index (toko_id),
    INDEX produks_kategori_id_index (kategori_id),
    INDEX produks_nama_produk_index (nama_produk)
) ENGINE = InnoDB;

-- ============================================================================
-- 3. KERANJANG & PESANAN (transaksi di dalam aplikasi)
-- ============================================================================

-- ----------------------------------------------------------------------------
-- keranjangs : isi keranjang milik warga (1 baris = 1 produk, qty bisa > 1)
-- ----------------------------------------------------------------------------
CREATE TABLE keranjangs (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    BIGINT UNSIGNED NOT NULL,
    produk_id  BIGINT UNSIGNED NOT NULL,
    qty        INT UNSIGNED NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT keranjangs_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT keranjangs_produk_id_foreign
        FOREIGN KEY (produk_id) REFERENCES produks (id) ON DELETE CASCADE,
    UNIQUE INDEX keranjangs_user_produk_unique (user_id, produk_id)
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- pesanans : header pesanan dari warga ke toko
--   status alur: pending -> confirmed / rejected -> completed / cancelled
-- ----------------------------------------------------------------------------
CREATE TABLE pesanans (
    id                 BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    no_pesanan         VARCHAR(50) NOT NULL UNIQUE COMMENT 'Format: PSW-20260804-0001',
    user_id            BIGINT UNSIGNED NOT NULL COMMENT 'Warga pemesan',
    toko_id            BIGINT UNSIGNED NOT NULL COMMENT 'Toko penerima pesanan',
    nama_penerima      VARCHAR(255) NOT NULL,
    alamat_pengiriman  TEXT NOT NULL,
    catatan            TEXT NULL COMMENT 'Catatan opsional dari pembeli',
    total_harga        DECIMAL(14, 2) NOT NULL DEFAULT 0,
    status             ENUM('pending', 'confirmed', 'rejected', 'completed', 'cancelled')
                       NOT NULL DEFAULT 'pending',
    created_at         TIMESTAMP NULL,
    updated_at         TIMESTAMP NULL,
    CONSTRAINT pesanans_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT pesanans_toko_id_foreign
        FOREIGN KEY (toko_id) REFERENCES tokos (id) ON DELETE CASCADE,
    INDEX pesanans_toko_id_index (toko_id),
    INDEX pesanans_status_index (status)
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- pesanan_items : detail/baris produk di dalam satu pesanan
--   nama_produk & harga_satuan disalin (snapshot) agar riwayat tetap akurat
--   walaupun produk diubah/dihapus oleh pemilik toko.
-- ----------------------------------------------------------------------------
CREATE TABLE pesanan_items (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pesanan_id    BIGINT UNSIGNED NOT NULL,
    produk_id     BIGINT UNSIGNED NULL COMMENT 'NULL jika produk sudah dihapus toko',
    nama_produk   VARCHAR(255) NOT NULL COMMENT 'Snapshot nama produk saat order',
    harga_satuan  DECIMAL(12, 2) NOT NULL COMMENT 'Snapshot harga saat order',
    qty           INT UNSIGNED NOT NULL,
    subtotal      DECIMAL(14, 2) NOT NULL COMMENT 'harga_satuan * qty',
    created_at    TIMESTAMP NULL,
    updated_at    TIMESTAMP NULL,
    CONSTRAINT pesanan_items_pesanan_id_foreign
        FOREIGN KEY (pesanan_id) REFERENCES pesanans (id) ON DELETE CASCADE,
    CONSTRAINT pesanan_items_produk_id_foreign
        FOREIGN KEY (produk_id) REFERENCES produks (id) ON DELETE SET NULL,
    INDEX pesanan_items_pesanan_id_index (pesanan_id)
) ENGINE = InnoDB;

-- ============================================================================
-- 4. FITUR TAMBAHAN (Nice to Have)
-- ============================================================================

-- ----------------------------------------------------------------------------
-- ulasans : rating & komentar warga terhadap produk (opsional)
-- ----------------------------------------------------------------------------
CREATE TABLE ulasans (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    produk_id  BIGINT UNSIGNED NOT NULL,
    user_id    BIGINT UNSIGNED NOT NULL,
    rating     TINYINT UNSIGNED NOT NULL DEFAULT 5
               COMMENT 'Skala 1-5',
    komentar   TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT ulasans_produk_id_foreign
        FOREIGN KEY (produk_id) REFERENCES produks (id) ON DELETE CASCADE,
    CONSTRAINT ulasans_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    UNIQUE INDEX ulasans_produk_user_unique (produk_id, user_id),
    CONSTRAINT ulasans_rating_check CHECK (rating BETWEEN 1 AND 5)
) ENGINE = InnoDB;

-- ----------------------------------------------------------------------------
-- favorits : wishlist produk favorit milik warga (opsional)
-- ----------------------------------------------------------------------------
CREATE TABLE favorits (
    id         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id    BIGINT UNSIGNED NOT NULL,
    produk_id  BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    CONSTRAINT favorits_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT favorits_produk_id_foreign
        FOREIGN KEY (produk_id) REFERENCES produks (id) ON DELETE CASCADE,
    UNIQUE INDEX favorits_user_produk_unique (user_id, produk_id)
) ENGINE = InnoDB;

-- ============================================================================
-- 5. DATA AWAL (SEED) - OPSIONAL
-- ============================================================================

-- Kategori awal yang umum di pasar lokal
INSERT INTO kategoris (nama, slug) VALUES
    ('Makanan & Minuman', 'makanan-minuman'),
    ('Sembako',          'sembako'),
    ('Pakaian',          'pakaian'),
    ('Kebutuhan Rumah Tangga', 'kebutuhan-rumah-tangga'),
    ('Jasa & Layanan',   'jasa-layanan');

-- Akun admin default (GANTI password dengan hasil bcrypt dari:
--   php -r "echo password_hash('password123', PASSWORD_BCRYPT);"
-- lalu paste hasilnya di kolom password di bawah ini)
INSERT INTO users (name, email, password, role) VALUES
    ('Admin Pasar Warga', 'admin@pasarwarga.test', '$2y$12$GANTI_DENGAN_HASH_BCRYPT_ANDA', 'admin');
