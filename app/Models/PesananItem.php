<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['pesanan_id', 'produk_id', 'qty', 'harga_satuan', 'subtotal'])]
#[Hidden([])]
class PesananItem extends Model
{
    use HasFactory;

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'qty'          => 'integer',
            'harga_satuan' => 'integer',
            'subtotal'     => 'integer',
        ];
    }

    /**
     * The order this item belongs to.
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * The product this line item references.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class);
    }
}
