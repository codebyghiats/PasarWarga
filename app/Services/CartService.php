<?php

namespace App\Services;

use App\Models\Produk;
use Illuminate\Support\Collection;

class CartService
{
    protected string $sessionKey = 'cart';

    /**
     * Add a product to the cart (or increment qty).
     */
    public function add(int $produkId, int $qty = 1): void
    {
        $cart = session($this->sessionKey, []);
        $existing = $cart[$produkId]['qty'] ?? 0;
        $produk = Produk::find($produkId);
        if (! $produk) return;

        $newQty = min($existing + $qty, $produk->stok);
        $cart[$produkId] = ['qty' => max(1, $newQty)];

        session([$this->sessionKey => $cart]);
        $this->syncCount();
    }

    /**
     * Update quantity for a specific product.
     */
    public function update(int $produkId, int $qty): void
    {
        $cart = session($this->sessionKey, []);
        if (! isset($cart[$produkId])) return;

        $produk = Produk::find($produkId);
        if (! $produk) {
            unset($cart[$produkId]);
        } else {
            $cart[$produkId]['qty'] = max(1, min($qty, $produk->stok));
        }

        session([$this->sessionKey => $cart]);
        $this->syncCount();
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(int $produkId): void
    {
        $cart = session($this->sessionKey, []);
        unset($cart[$produkId]);
        session([$this->sessionKey => $cart]);
        $this->syncCount();
    }

    /**
     * Get all cart items with loaded Produk models.
     */
    public function items(): Collection
    {
        $cart = session($this->sessionKey, []);
        if (empty($cart)) return collect();

        $produks = Produk::with(['toko', 'kategori'])
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return collect($cart)->map(function ($item, $produkId) use ($produks) {
            $produk = $produks->get($produkId);
            if (! $produk) return null;
            return [
                'produk'   => $produk,
                'qty'      => $item['qty'],
                'subtotal' => $produk->harga * $item['qty'],
            ];
        })->filter();
    }

    /**
     * Get total price.
     */
    public function total(): int
    {
        return $this->items()->sum('subtotal');
    }

    /**
     * Get total item count.
     */
    public function count(): int
    {
        $cart = session($this->sessionKey, []);
        return array_sum(array_column($cart, 'qty'));
    }

    /**
     * Clear the cart entirely.
     */
    public function clear(): void
    {
        session()->forget($this->sessionKey);
        session(['cart_count' => 0]);
    }

    /**
     * Sync the cart_count session value for the topbar badge.
     */
    protected function syncCount(): void
    {
        session(['cart_count' => $this->count()]);
    }
}
