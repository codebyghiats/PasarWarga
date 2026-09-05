<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\View\View;

class DashboardTokoController extends Controller
{
    /**
     * Show the seller dashboard.
     */
    public function index(): View
    {
        $toko = auth()->user()->toko;

        // If the seller hasn't created their shop yet, redirect to onboarding.
        if (! $toko) {
            return redirect()->route('toko.pendaftaran')
                ->with('success', 'Lengkapi profil tokomu dulu.');
        }

        $pesananMasuk = Pesanan::where('status', 'menunggu')
            ->whereHas('items.produk', fn ($q) => $q->where('toko_id', $toko->id))
            ->with(['items.produk', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        $produks = $toko->produks()
            ->with('kategori')
            ->latest()
            ->limit(10)
            ->get();

        return view('toko.dashboard', [
            'toko'         => $toko,
            'statProduk'   => Produk::where('toko_id', $toko->id)->count(),
            'pesananMasuk' => $pesananMasuk,
            'produks'      => $produks,
            'active'       => 'pesanan',
        ]);
    }
}
