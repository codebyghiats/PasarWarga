<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Toko;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with summary stats.
     */
    public function index(): View
    {
        $pendingTokos = Toko::pending()->with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', [
            'statTokos'     => Toko::count(),
            'statProduks'   => Produk::count(),
            'statUsers'     => User::count(),
            'statPending'   => Toko::pending()->count(),
            'pendingTokos'  => $pendingTokos,
            'recentOrders'  => Pesanan::latest()->limit(5)->get(),
            'active'        => 'profil',
        ]);
    }
}
