<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Toko;

class TokoSeeder extends Seeder
{
    /**
     * Seed demo shops, mix of statuses.
     */
    public function run(): void
    {
        $tokos = [
            // Approved shops (visible in catalog)
            [
                'seller' => 'busari@pasarwarga.test',
                'nama_toko' => 'Warung Bu Sari',
                'deskripsi' => 'Warung makan rumahan yang menyajikan lauk dan nasi khas sehari-hari.',
                'lokasi' => 'Kel. Sukamaju, Kec. Sukamaju',
                'no_wa' => '81234567890',
                'status' => 'approved',
            ],
            [
                'seller' => 'mbakeni@pasarwarga.test',
                'nama_toko' => 'Dapur Mbak Eni',
                'deskripsi' => 'Katering dan masakan rumahan dengan pesanan dari sehari sebelumnya.',
                'lokasi' => 'Kel. Sukamaju, Kec. Sukamaju',
                'no_wa' => '81234567891',
                'status' => 'approved',
            ],
            [
                'seller' => 'masbudi@pasarwarga.test',
                'nama_toko' => 'Toko Mas Budi',
                'deskripsi' => 'Toko kelontong dan snack kebutuhan sehari-hari.',
                'lokasi' => 'Kel. Cempaka, Kec. Cempaka',
                'no_wa' => '81234567892',
                'status' => 'approved',
            ],
            [
                'seller' => 'pakharto@pasarwarga.test',
                'nama_toko' => 'Kedai Pak Harto',
                'deskripsi' => 'Kedai minuman segar dan es teh jumbo yang legendaris.',
                'lokasi' => 'Kel. Melati, Kec. Melati',
                'no_wa' => '81234567893',
                'status' => 'approved',
            ],
            [
                'seller' => 'burahmi@pasarwarga.test',
                'nama_toko' => 'Toko Bu Rahmi',
                'deskripsi' => 'Sayuran dan bahan dapur segar dipetik tiap pagi.',
                'lokasi' => 'Kel. Anggrek, Kec. Anggrek',
                'no_wa' => '81234567894',
                'status' => 'approved',
            ],
            // Pending shop (in admin approval queue)
            [
                'seller' => 'kakdinda@pasarwarga.test',
                'nama_toko' => 'Butik Dinda',
                'deskripsi' => 'Pakaian fashion wanita dengan bahan katun premium.',
                'lokasi' => 'Kel. Melati, Kec. Melati',
                'no_wa' => '81234567895',
                'status' => 'pending',
            ],
        ];

        foreach ($tokos as $toko) {
            $user = User::where('email', $toko['seller'])->first();
            if (! $user) continue;

            Toko::create([
                'user_id'   => $user->id,
                'nama_toko' => $toko['nama_toko'],
                'deskripsi' => $toko['deskripsi'],
                'lokasi'    => $toko['lokasi'],
                'no_wa'     => $toko['no_wa'],
                'status'    => $toko['status'],
            ]);
        }
    }
}
