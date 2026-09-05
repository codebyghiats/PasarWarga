<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\View\View;

class ProdukController extends Controller
{
    /**
     * Show a product detail page.
     */
    public function show(Produk $produk): View
    {
        $user = auth()->user();
        $isOwner = $user && $user->id === $produk->toko->user_id;
        $isAdmin = $user && $user->isAdmin();

        // Only approved products visible publicly (unless owner/admin)
        if ($produk->toko->status !== 'approved' && ! $isOwner && ! $isAdmin) {
            abort(404);
        }

        $related = Produk::fromApprovedShops()
            ->where('id', '!=', $produk->id)
            ->where(function ($q) use ($produk) {
                $q->where('kategori_id', $produk->kategori_id)
                    ->orWhere('toko_id', $produk->toko_id);
            })
            ->with(['toko', 'kategori'])
            ->limit(4)
            ->get();

        return view('produk.show', [
            'produk'   => $produk->load(['toko', 'kategori']),
            'related'  => $related,
            'active'   => 'katalog',
        ]);
    }
}