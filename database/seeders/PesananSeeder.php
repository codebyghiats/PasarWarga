<?php

namespace Database\Seeders;

use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    /**
     * Seed demo orders with line items.
     */
    public function run(): void
    {
        $warga = User::where('email', 'andi@pasarwarga.test')->first();
        if (! $warga) return;

        $orders = [
            [
                'status'  => 'menunggu',
                'penerima' => 'Andi Pratama',
                'alamat'  => 'Jl. Merdeka No. 10, RT 03 RW 02, Kel. Sukamaju, Kec. Sukamaju',
                'items'   => [
                    ['produk' => 'Nasi Kuning Spesial', 'qty' => 2],
                    ['produk' => 'Tempe Mendoan', 'qty' => 4],
                ],
            ],
            [
                'status'  => 'menunggu',
                'penerima' => 'Andi Pratama',
                'alamat'  => 'Jl. Merdeka No. 10, RT 03 RW 02, Kel. Sukamaju, Kec. Sukamaju',
                'items'   => [
                    ['produk' => 'Es Teh Manis Jumbo', 'qty' => 2],
                    ['produk' => 'Kopi Susu Gula Aren', 'qty' => 1],
                ],
            ],
            [
                'status'  => 'dikonfirmasi',
                'penerima' => 'Siti Nuraini',
                'alamat'  => 'Jl. Kenanga No. 5, Kel. Cempaka, Kec. Cempaka',
                'items'   => [
                    ['produk' => 'Keripik Singkong Pedas', 'qty' => 3],
                ],
            ],
            [
                'status'  => 'ditolak',
                'penerima' => 'Rizky Ramadhan',
                'alamat'  => 'Jl. Mawar No. 21, Kel. Melati, Kec. Melati',
                'items'   => [
                    ['produk' => 'Bayam Segar 500gr', 'qty' => 1],
                ],
            ],
        ];

        foreach ($orders as $order) {
            $total = 0;
            $lines = [];

            foreach ($order['items'] as $item) {
                $produk = Produk::where('nama_produk', $item['produk'])->first();
                if (! $produk) continue;
                $subtotal = $produk->harga * $item['qty'];
                $total += $subtotal;
                $lines[] = [
                    'produk'       => $produk,
                    'qty'          => $item['qty'],
                    'harga_satuan' => $produk->harga,
                    'subtotal'     => $subtotal,
                ];
            }

            if (empty($lines)) continue;

            $pesanan = Pesanan::create([
                'user_id'           => $warga->id,
                'nama_penerima'     => $order['penerima'],
                'alamat_pengiriman' => $order['alamat'],
                'catatan'           => null,
                'status'            => $order['status'],
                'total'             => $total,
            ]);

            foreach ($lines as $line) {
                PesananItem::create([
                    'pesanan_id'   => $pesanan->id,
                    'produk_id'    => $line['produk']->id,
                    'qty'          => $line['qty'],
                    'harga_satuan' => $line['harga_satuan'],
                    'subtotal'     => $line['subtotal'],
                ]);
            }
        }
    }
}
