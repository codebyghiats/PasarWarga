<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the landing page.
     */
    public function index(): View
    {
        $kategoris = Kategori::orderBy('nama')->get();
        $tokos = Toko::approved()
            ->with(['produks.kategori'])
            ->latest()
            ->limit(8)
            ->get();

        $produks = Produk::fromApprovedShops()
            ->with(['toko', 'kategori'])
            ->latest()
            ->limit(8)
            ->get();

        return view('welcome', [
            'kategoris'    => $kategoris,
            'tokos'        => $tokos,
            'produks'      => $produks,
            'showGuestCta' => ! auth()->check(),
            'active'       => 'beranda',
        ]);
    }
}