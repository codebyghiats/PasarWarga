<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KatalogController extends Controller
{
    /**
     * Products listing with search & filters.
     */
    public function index(Request $request): View
    {
        $kategoris = Kategori::orderBy('nama')->get();

        $query = Produk::fromApprovedShops()->with(['toko', 'kategori']);

        // Search by product or shop name
        if ($q = trim($request->query('q', ''))) {
            $query->where(function ($qry) use ($q) {
                $qry->where('nama_produk', 'ilike', "%{$q}%")
                    ->orWhereHas('toko', fn ($t) => $t->where('nama_toko', 'ilike', "%{$q}%"));
            });
        }

        // Filter by category
        if ($kategori = $request->query('kategori')) {
            $query->where('kategori_id', $kategori);
        }

        // Filter by location (substring on shop location)
        if ($lokasi = trim($request->query('lokasi', ''))) {
            $query->whereHas('toko', fn ($t) => $t->where('lokasi', 'ilike', "%{$lokasi}%"));
        }

        // Filter by price range
        if ($min = $request->query('min_harga')) {
            $query->where('harga', '>=', (int) $min);
        }
        if ($max = $request->query('max_harga')) {
            $query->where('harga', '<=', (int) $max);
        }

        $produks = $query->latest()->paginate(12)->withQueryString();

        return view('katalog.index', [
            'produks'   => $produks,
            'kategoris' => $kategoris,
            'filters'   => [
                'q'        => $request->query('q', ''),
                'kategori' => $request->query('kategori', ''),
                'lokasi'   => $request->query('lokasi', ''),
                'min'      => $request->query('min_harga', ''),
                'max'      => $request->query('max_harga', ''),
            ],
            'active' => 'kategori',
        ]);
    }

    /**
     * Shops listing (approved only).
     */
    public function shops(Request $request): View
    {
        $tokos = Toko::approved()
            ->with(['produks.kategori'])
            ->where(function ($q) use ($request) {
                if ($qText = trim($request->query('q', ''))) {
                    $q->where('nama_toko', 'like', "%{$qText}%");
                }
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('katalog.shops', [
            'tokos'  => $tokos,
            'active' => 'kategori',
        ]);
    }

    /**
     * Show a single shop and its products, only if approved.
     */
    public function show(Toko $toko): View
    {
        // Only the owner, an admin, or an approved shop is viewable publicly
        $user = auth()->user();
        $isOwner = $user && $user->id === $toko->user_id;
        $isAdmin = $user && $user->isAdmin();

        if ($toko->status !== 'approved' && ! $isOwner && ! $isAdmin) {
            abort(404);
        }

        $produks = $toko->produks()
            ->with(['kategori'])
            ->latest()
            ->paginate(12);

        return view('katalog.show-toko', [
            'toko'    => $toko,
            'produks' => $produks,
        ]);
    }
}