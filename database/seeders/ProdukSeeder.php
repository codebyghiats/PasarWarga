<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Toko;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Seed demo products across approved shops.
     */
    public function run(): void
    {
        $kategori = fn (string $nama) => Kategori::where('nama', $nama)->first();

        $produks = [
            // Warung Bu Sari
            ['toko' => 'Warung Bu Sari', 'nama' => 'Nasi Kuning Spesial', 'kat' => 'Makanan', 'harga' => 15000, 'stok' => 20, 'deskripsi' => 'Nasi kuning lengkap dengan ayam suwir, telur, dan sambal goreng.'],
            ['toko' => 'Warung Bu Sari', 'nama' => 'Tempe Mendoan', 'kat' => 'Snack', 'harga' => 3000, 'stok' => 100, 'deskripsi' => 'Tempe mendoan goreng kriuk, paket dengan sambal kecap.'],
            ['toko' => 'Warung Bu Sari', 'nama' => 'Nasi Uduk Komplit', 'kat' => 'Makanan', 'harga' => 18000, 'stok' => 15, 'deskripsi' => 'Nasi uduk dengan lauk pauk pilihan dan kerupuk.'],

            // Dapur Mbak Eni
            ['toko' => 'Dapur Mbak Eni', 'nama' => 'Ayam Bakar Kecap', 'kat' => 'Makanan', 'harga' => 22000, 'stok' => 10, 'deskripsi' => 'Ayam bakar bumbu kecap manis, dipesan minimal H-1.'],
            ['toko' => 'Dapur Mbak Eni', 'nama' => 'Sambal Goreng Kentang', 'kat' => 'Makanan', 'harga' => 12000, 'stok' => 25, 'deskripsi' => 'Sambal goreng kentang ati ampela untuk lauk pendamping.'],
            ['toko' => 'Dapur Mbak Eni', 'nama' => 'Es Teler Rumahan', 'kat' => 'Minuman', 'harga' => 10000, 'stok' => 20, 'deskripsi' => 'Es teler dengan alpukat, kelapa muda, dan nangka.'],

            // Toko Mas Budi
            ['toko' => 'Toko Mas Budi', 'nama' => 'Keripik Singkong Pedas', 'kat' => 'Snack', 'harga' => 12000, 'stok' => 35, 'deskripsi' => 'Keripik singkong gurih dengan level pedas bikin nagih.'],
            ['toko' => 'Toko Mas Budi', 'nama' => 'Kopi Luwak Bubuk 250gr', 'kat' => 'Minuman', 'harga' => 85000, 'stok' => 8, 'deskripsi' => 'Kopi bubuk robusta-arabika, giling halus.'],
            ['toko' => 'Toko Mas Budi', 'nama' => 'Tisu Kotak Isi 3', 'kat' => 'Rumah Tangga', 'harga' => 18000, 'stok' => 40, 'deskripsi' => 'Tisu kotak lembut 2 ply, isi 3 kotak.'],

            // Kedai Pak Harto
            ['toko' => 'Kedai Pak Harto', 'nama' => 'Es Teh Manis Jumbo', 'kat' => 'Minuman', 'harga' => 5000, 'stok' => 50, 'deskripsi' => 'Es teh manis legendaris, gelas jumbo 500ml.'],
            ['toko' => 'Kedai Pak Harto', 'nama' => 'Es Jeruk Peras', 'kat' => 'Minuman', 'harga' => 8000, 'stok' => 30, 'deskripsi' => 'Jeruk peras asli tanpa pemanis buatan.'],
            ['toko' => 'Kedai Pak Harto', 'nama' => 'Kopi Susu Gula Aren', 'kat' => 'Minuman', 'harga' => 13000, 'stok' => 25, 'deskripsi' => 'Kopi susu dengan gula aren asli, creamy dan manis.'],

            // Toko Bu Rahmi
            ['toko' => 'Toko Bu Rahmi', 'nama' => 'Bayam Segar 500gr', 'kat' => 'Sayuran', 'harga' => 8000, 'stok' => 15, 'deskripsi' => 'Bayam segar petik pagi, siap diolah.'],
            ['toko' => 'Toko Bu Rahmi', 'nama' => 'Kangkung Segar 500gr', 'kat' => 'Sayuran', 'harga' => 7000, 'stok' => 20, 'deskripsi' => 'Kangkung segar, cocok untuk tumis atau plecing.'],
            ['toko' => 'Toko Bu Rahmi', 'nama' => 'Tomat Merah 1kg', 'kat' => 'Sayuran', 'harga' => 15000, 'stok' => 12, 'deskripsi' => 'Tomat merah matang, segar untuk sayur atau sambal.'],
        ];

        foreach ($produks as $produk) {
            $toko = Toko::where('nama_toko', $produk['toko'])->first();
            $kat = $kategori($produk['kat']);
            if (! $toko || ! $kat) continue;

            $toko->produks()->create([
                'kategori_id' => $kat->id,
                'nama_produk' => $produk['nama'],
                'deskripsi'   => $produk['deskripsi'],
                'harga'       => $produk['harga'],
                'stok'        => $produk['stok'],
            ]);
        }
    }
}
