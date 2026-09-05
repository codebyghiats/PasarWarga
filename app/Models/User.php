<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The shop owned by this user (if a pemilik_toko).
     */
    public function toko(): HasOne
    {
        return $this->hasOne(Toko::class);
    }

    /**
     * Orders placed by this user (as warga).
     */
    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    /**
     * Whether the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Whether the user is a shop owner.
     */
    public function isPemilikToko(): bool
    {
        return $this->role === 'pemilik_toko';
    }

    /**
     * Whether the user is a regular resident/buyer.
     */
    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }
}
