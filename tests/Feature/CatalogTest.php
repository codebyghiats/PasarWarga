<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Guest can browse the landing page.
     */
    public function test_guest_can_view_home_page(): void
    {
        $this->get('/')->assertStatus(200);
    }

    /**
     * Products from unapproved shops are hidden from the catalog.
     */
    public function test_unapproved_shop_products_are_hidden(): void
    {
        $kat = Kategori::create(['nama' => 'Makanan', 'icon' => 'makanan']);

        $approvedShop = $this->makeShop('approved');
        $pendingShop = $this->makeShop('pending');

        $approvedShop->produks()->create(['kategori_id' => $kat->id, 'nama_produk' => 'Produk Tampil', 'harga' => 1000, 'stok' => 5]);
        $pendingShop->produks()->create(['kategori_id' => $kat->id, 'nama_produk' => 'Produk Tersembunyi', 'harga' => 2000, 'stok' => 5]);

        $response = $this->get('/katalog');

        $response->assertOk();
        $response->assertSee('Produk Tampil');
        $response->assertDontSee('Produk Tersembunyi');
    }

    /**
     * Guest can view an approved shop detail.
     */
    public function test_approved_shop_detail_is_viewable(): void
    {
        $shop = $this->makeShop('approved');

        $this->get(route('tokos.show', $shop))->assertOk();
    }

    /**
     * A pending shop detail is 404 for a guest.
     */
    public function test_pending_shop_detail_is_404_for_guest(): void
    {
        $shop = $this->makeShop('pending');

        $this->get(route('tokos.show', $shop))->assertNotFound();
    }

    protected function makeShop(string $status): Toko
    {
        $user = User::create([
            'name'     => 'Penjual ' . $status,
            'email'    => str_replace('-', '', $status) . '@test.com',
            'password' => 'password',
            'role'     => 'pemilik_toko',
        ]);

        return Toko::create([
            'user_id'   => $user->id,
            'nama_toko' => 'Toko ' . $status,
            'deskripsi' => null,
            'lokasi'    => 'Kel. Test, Kec. Test',
            'no_wa'     => '81234567890',
            'status'    => $status,
        ]);
    }
}