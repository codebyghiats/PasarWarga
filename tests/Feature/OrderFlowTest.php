<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A warga can add to cart and check out, creating an order per shop.
     */
    public function test_warga_can_place_an_order(): void
    {
        $seller = User::create(['name' => 'Penjual', 'email' => 'seller_ord@test.com', 'password' => 'password', 'role' => 'pemilik_toko']);
        $toko = Toko::create(['user_id' => $seller->id, 'nama_toko' => 'Toko Order', 'lokasi' => 'Kel. A', 'no_wa' => '8123', 'status' => 'approved']);
        $kat = Kategori::create(['nama' => 'Makanan', 'icon' => 'makanan']);
        $produk = $toko->produks()->create(['kategori_id' => $kat->id, 'nama_produk' => 'Nasi', 'harga' => 10000, 'stok' => 5]);

        $warga = User::create(['name' => 'Warga', 'email' => 'warga_ord@test.com', 'password' => 'password', 'role' => 'warga']);

        $this->actingAs($warga);

        // Add to cart
        $this->post('/keranjang/tambah', ['produk_id' => $produk->id, 'qty' => 2]);

        // Checkout
        $response = $this->post('/checkout', [
            'nama_penerima'     => 'Warga',
            'alamat_pengiriman' => 'Jl. Test 1',
            'catatan'           => null,
        ]);

        $response->assertRedirect(route('pesanan.index'));
        $this->assertDatabaseHas('pesanans', ['user_id' => $warga->id, 'total' => 20000, 'status' => 'menunggu']);

        // Stock decremented
        $this->assertDatabaseHas('produks', ['id' => $produk->id, 'stok' => 3]);
    }

    /**
     * A seller can confirm an incoming order.
     */
    public function test_seller_can_confirm_order(): void
    {
        $seller = User::create(['name' => 'Penjual', 'email' => 'seller_cf@test.com', 'password' => 'password', 'role' => 'pemilik_toko']);
        $toko = Toko::create(['user_id' => $seller->id, 'nama_toko' => 'Toko CF', 'lokasi' => 'Kel. C', 'status' => 'approved']);
        $kat = Kategori::create(['nama' => 'Makanan', 'icon' => 'makanan']);
        $produk = $toko->produks()->create(['kategori_id' => $kat->id, 'nama_produk' => 'Ayam', 'harga' => 20000, 'stok' => 5]);

        $warga = User::create(['name' => 'Warga', 'email' => 'warga_cf@test.com', 'password' => 'password', 'role' => 'warga']);

        $pesanan = $warga->pesanans()->create([
            'nama_penerima'     => 'Warga',
            'alamat_pengiriman' => 'Jl. X',
            'status'            => 'menunggu',
            'total'             => 20000,
        ]);
        $pesanan->items()->create(['produk_id' => $produk->id, 'qty' => 1, 'harga_satuan' => 20000, 'subtotal' => 20000]);

        $this->actingAs($seller)
             ->post(route('toko.pesanans.konfirmasi', $pesanan))
             ->assertRedirect();

        $this->assertDatabaseHas('pesanans', ['id' => $pesanan->id, 'status' => 'dikonfirmasi']);
    }
}