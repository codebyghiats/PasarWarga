<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama', 'icon'])]
#[Hidden([])]
class Kategori extends Model
{
    use HasFactory;

    /**
     * Products in this category.
     */
    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class);
    }
}
