<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminTokoController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Toko\DashboardTokoController;
use App\Http\Controllers\Toko\OrderController;
use App\Http\Controllers\Toko\ProdukController as TokoProdukController;
use App\Http\Controllers\Toko\TokoController;
use Illuminate\Support\Facades\Route;

// ─── Public catalog ──────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/tokos', [KatalogController::class, 'shops'])->name('tokos.index');
Route::get('/tokos/{toko}', [KatalogController::class, 'show'])->name('tokos.show');
Route::get('/produks/{produk}', [ProdukController::class, 'show'])->name('produks.show');

// ─── Guest auth ──────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::get('/register/{path}', [RegisterController::class, 'show'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::post('/logout', [LogoutController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ─── Cart (logged in) ────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::post('/keranjang/{produk}/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/keranjang/{produk}/hapus', [CartController::class, 'remove'])->name('cart.remove');
});

// ─── Orders (warga) ──────────────────────────────────────────

Route::middleware(['auth', 'role:warga'])->group(function () {
    Route::get('/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
    Route::post('/checkout', [PesananController::class, 'store'])->name('pesanan.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
});

// ─── Profile (any logged-in role) ────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ─── Admin ───────────────────────────────────────────────────

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::post('/tokos/{toko}/approve', [AdminTokoController::class, 'approve'])->name('tokos.approve');
    Route::post('/tokos/{toko}/reject', [AdminTokoController::class, 'reject'])->name('tokos.reject');

    Route::resource('kategoris', AdminKategoriController::class)->except(['show']);

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

// ─── Pemilik Toko ────────────────────────────────────────────

Route::middleware(['auth', 'role:pemilik_toko'])->prefix('toko')->name('toko.')->group(function () {
    Route::get('/dashboard', [DashboardTokoController::class, 'index'])->name('dashboard');
    Route::get('/profil', [TokoController::class, 'showForm'])->name('pendaftaran');
    Route::post('/profil', [TokoController::class, 'store'])->name('profil.simpan');
    Route::put('/profil', [TokoController::class, 'update'])->name('profil.update');

    Route::resource('produks', TokoProdukController::class);

    Route::post('/pesanans/{pesanan}/konfirmasi', [OrderController::class, 'konfirmasi'])->name('pesanans.konfirmasi');
    Route::post('/pesanans/{pesanan}/tolak', [OrderController::class, 'tolak'])->name('pesanans.tolak');
});