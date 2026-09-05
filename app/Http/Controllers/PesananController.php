<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PesananItem;
use App\Models\Produk;
use App\Services\CartService;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesananController extends Controller
{
    public function __construct(
        protected CartService $cart,
        protected DatabaseManager $db,
    ) {}

    /**
     * Show the checkout form with the cart summary.
     */
    public function checkout(): View|RedirectResponse
    {
        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu masih kosong.');
        }

        return view('pesanan.checkout', [
            'items'  => $items,
            'total'  => $this->cart->total(),
            'active' => 'kategori',
        ]);
    }

    /**
     * Place the order(s). One Pesanan per shop.
     */
    public function store(Request $request): RedirectResponse
    {
        $items = $this->cart->items();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu kosong.');
        }

        $data = $request->validate([
            'nama_penerima'     => ['required', 'string', 'max:100'],
            'alamat_pengiriman' => ['required', 'string', 'max:2000'],
            'catatan'           => ['nullable', 'string', 'max:2000'],
        ]);

        // Group cart items by shop.
        $byToko = $items->groupBy(fn ($line) => $line['produk']->toko_id);

        // Validate stock for all items before creating anything.
        foreach ($items as $line) {
            $produk = $line['produk'];
            if ($line['qty'] > $produk->stok) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$produk->nama_produk} tidak cukup (sisa {$produk->stok}).");
            }
        }

        $created = 0;

        $this->db->transaction(function () use ($byToko, $data, &$created) {
            foreach ($byToko as $tokoId => $lines) {
                $total = $lines->sum('subtotal');

                $pesanan = Pesanan::create([
                    'user_id'           => auth()->id(),
                    'nama_penerima'     => $data['nama_penerima'],
                    'alamat_pengiriman' => $data['alamat_pengiriman'],
                    'catatan'           => $data['catatan'] ?? null,
                    'status'            => 'menunggu',
                    'total'             => $total,
                ]);

                foreach ($lines as $line) {
                    $produk = Produk::findOrFail($line['produk']->id);
                    PesananItem::create([
                        'pesanan_id'   => $pesanan->id,
                        'produk_id'    => $produk->id,
                        'qty'          => $line['qty'],
                        'harga_satuan' => $produk->harga,
                        'subtotal'     => $produk->harga * $line['qty'],
                    ]);
                    // Decrement stock.
                    $produk->decrement('stok', $line['qty']);
                }

                $created++;
            }
        });

        $this->cart->clear();

        return redirect()->route('pesanan.index')
            ->with('success', "Pesananmu berhasil dibuat ({$created} pesanan ke toko berbeda).");
    }

    /**
     * List the buyer's order history, grouped by status.
     */
    public function index(): View
    {
        $pesanans = auth()->user()
            ->pesanans()
            ->with('items.produk.toko')
            ->latest()
            ->paginate(20);

        return view('pesanan.index', [
            'pesanans' => $pesanans,
            'active'   => 'pesanan',
        ]);
    }

    /**
     * Show a single order detail (owner only).
     */
    public function show(Pesanan $pesanan): View
    {
        abort_if($pesanan->user_id !== auth()->id(), 403);

        return view('pesanan.show', [
            'pesanan' => $pesanan->load(['items.produk.toko', 'user']),
            'active'  => 'pesanan',
        ]);
    }
}