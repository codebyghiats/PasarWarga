<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['toko_id', 'kategori_id', 'nama_produk', 'deskripsi', 'harga', 'stok', 'foto'])]
#[Hidden([])]
class Produk extends Model
{
    use HasFactory;

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'stok'  => 'integer',
        ];
    }

    /**
     * The shop that owns this product.
     */
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class);
    }

    /**
     * The category this product belongs to.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    /**
     * Scope: only products with stock > 0.
     */
    public function scopeAvailable(Builder $query): void
    {
        $query->where('stok', '>', 0);
    }

    /**
     * Scope: only products from shops with status 'approved'.
     */
    public function scopeFromApprovedShops(Builder $query): void
    {
        $query->whereHas('toko', fn (Builder $q) => $q->where('status', 'approved'));
    }

    /**
     * Format harga as Indonesian Rupiah.
     */
    public function formatHarga(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
