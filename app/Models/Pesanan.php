<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'nama_penerima', 'alamat_pengiriman', 'catatan', 'status', 'total'])]
#[Hidden([])]
class Pesanan extends Model
{
    use HasFactory;

    /**
     * Cast attributes.
     */
    protected function casts(): array
    {
        return [
            'total' => 'integer',
        ];
    }

    /**
     * The buyer who placed this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Line items in this order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(PesananItem::class);
    }

    /**
     * Format total as Indonesian Rupiah.
     */
    public function formatTotal(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }
}
