<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\RedirectResponse;

class AdminTokoController extends Controller
{
    /**
     * Approve a pending shop so it appears in the catalog.
     */
    public function approve(Toko $toko): RedirectResponse
    {
        $toko->update(['status' => 'approved']);

        return back()->with('success', "Toko {$toko->nama_toko} disetujui.");
    }

    /**
     * Reject a pending shop.
     */
    public function reject(Toko $toko): RedirectResponse
    {
        $toko->update(['status' => 'rejected']);

        return back()->with('success', "Toko {$toko->nama_toko} ditolak.");
    }
}
