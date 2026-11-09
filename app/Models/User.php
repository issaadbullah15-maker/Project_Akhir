<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'taman_baca_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tamanBaca(): BelongsTo
    {
        return $this->belongsTo(TamanBaca::class, 'taman_baca_id');
    }

    public function permintaan(): HasMany
    {
        return $this->hasMany(Permintaan::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function labelRole(): string
    {
        return $this->isAdmin() ? 'Admin' : 'Pengelola';
    }
}
