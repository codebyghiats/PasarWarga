<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'nama_toko', 'deskripsi', 'lokasi', 'no_wa', 'foto', 'status'])]
#[Hidden([])]
class Toko extends Model
{
    use HasFactory;

    /**
     * Owner of this shop.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Products listed by this shop.
     */
    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    /**
     * Scope: only approved shops.
     */
    public function scopeApproved(Builder $query): void
    {
        $query->where('status', 'approved');
    }

    /**
     * Scope: only pending shops.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    /**
     * Get wa.me URL for this shop's WhatsApp number.
     */
    public function waUrl(): string
    {
        $number = ltrim($this->no_wa ?? '', '0');
        return 'https://wa.me/62' . $number;
    }
}
