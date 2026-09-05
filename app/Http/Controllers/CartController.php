<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cart,
    ) {}

    /**
     * Show the cart page.
     */
    public function index(): View
    {
        return view('cart.index', [
            'items'  => $this->cart->items(),
            'total'  => $this->cart->total(),
            'active' => 'kategori',
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'produk_id' => ['required', 'exists:produks,id'],
            'qty'       => ['nullable', 'integer', 'min:1'],
        ]);

        $produk = Produk::with('toko')->findOrFail($data['produk_id']);

        // Reject adding products from unapproved shops.
        abort_if($produk->toko->status !== 'approved', 403, 'Produk ini tidak tersedia.');

        $qty = $data['qty'] ?? 1;

        if ($produk->stok < 1) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Stok produk habis.'], 422);
            }
            return back()->with('error', "Stok {$produk->nama_produk} habis.");
        }

        $this->cart->add($produk->id, $qty);

        if ($request->wantsJson()) {
            return response()->json([
                'success'    => true,
                'cart_count' => $this->cart->count(),
            ]);
        }

        return redirect()->back()->with('success', "{$produk->nama_produk} ditambahkan ke keranjang.");
    }

    /**
     * Update quantity for a cart item.
     */
    public function update(Request $request, int $productId): RedirectResponse
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $this->cart->update($productId, $data['qty']);

        return redirect()->route('cart.index')
            ->with('success', 'Jumlah keranjang diperbarui.');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(int $productId): RedirectResponse
    {
        $this->cart->remove($productId);

        return redirect()->route('cart.index')
            ->with('success', 'Item dihapus dari keranjang.');
    }
}