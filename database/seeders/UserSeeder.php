<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed demo users for all roles.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name'     => 'Admin Pasar Warga',
            'email'    => 'admin@pasarwarga.test',
            'password' => 'password',
            'role'     => 'admin',
        ]);

        // Pemilik toko
        $sellers = [
            ['name' => 'Bu Sari',     'email' => 'busari@pasarwarga.test'],
            ['name' => 'Mbak Eni',    'email' => 'mbakeni@pasarwarga.test'],
            ['name' => 'Mas Budi',    'email' => 'masbudi@pasarwarga.test'],
            ['name' => 'Pak Harto',   'email' => 'pakharto@pasarwarga.test'],
            ['name' => 'Bu Rahmi',    'email' => 'burahmi@pasarwarga.test'],
            ['name' => 'Kak Dinda',   'email' => 'kakdinda@pasarwarga.test'],
        ];
        foreach ($sellers as $seller) {
            User::create([
                'name'     => $seller['name'],
                'email'    => $seller['email'],
                'password' => 'password',
                'role'     => 'pemilik_toko',
            ]);
        }

        // Warga
        $wargas = [
            ['name' => 'Andi Pratama',  'email' => 'andi@pasarwarga.test'],
            ['name' => 'Siti Nuraini',  'email' => 'siti@pasarwarga.test'],
            ['name' => 'Rizky Ramadhan','email' => 'rizky@pasarwarga.test'],
        ];
        foreach ($wargas as $warga) {
            User::create([
                'name'     => $warga['name'],
                'email'    => $warga['email'],
                'password' => 'password',
                'role'     => 'warga',
            ]);
        }
    }
}
