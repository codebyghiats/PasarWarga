<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Seed the categories used across the catalog.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Makanan',      'icon' => 'makanan'],
            ['nama' => 'Minuman',      'icon' => 'minuman'],
            ['nama' => 'Snack',        'icon' => 'snack'],
            ['nama' => 'Sayuran',      'icon' => 'sayuran'],
            ['nama' => 'Rumah Tangga', 'icon' => 'rumah tangga'],
            ['nama' => 'Fashion',      'icon' => 'fashion'],
            ['nama' => 'Kecantikan',   'icon' => 'kecantikan'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(['nama' => $kategori['nama']], ['icon' => $kategori['icon']]);
        }
    }
}
