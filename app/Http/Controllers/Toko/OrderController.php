<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Confirm a pending order for the seller's shop.
     */
    public function konfirmasi(Pesanan $pesanan): RedirectResponse
    {
        $this->authorizePesanan($pesanan);

        abort_if($pesanan->status !== 'menunggu', 409, 'Pesanan sudah diproses.');

        $pesanan->update(['status' => 'dikonfirmasi']);

        return back()->with('success', "Pesanan #{$pesanan->id} dikonfirmasi.");
    }

    /**
     * Reject a pending order for the seller's shop.
     */
    public function tolak(Pesanan $pesanan): RedirectResponse
    {
        $this->authorizePesanan($pesanan);

        abort_if($pesanan->status !== 'menunggu', 409, 'Pesanan sudah diproses.');

        $pesanan->update(['status' => 'ditolak']);

        return back()->with('success', "Pesanan #{$pesanan->id} ditolak.");
    }

    /**
     * Ensure the order belongs to the authenticated seller's shop.
     */
    protected function authorizePesanan(Pesanan $pesanan): void
    {
        $toko = auth()->user()->toko;
        abort_if(! $toko, 403);

        $belongsToShop = $pesanan->items()
            ->whereHas('produk', fn ($q) => $q->where('toko_id', $toko->id))
            ->exists();

        abort_if(! $belongsToShop, 403, 'Pesanan ini bukan milik tokomu.');
    }
}