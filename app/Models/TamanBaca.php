<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TamanBaca extends Model
{
    protected $table = 'taman_baca';

    protected $fillable = ['nama', 'alamat', 'kota', 'provinsi', 'kontak_nama', 'kontak_telepon'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'taman_baca_id');
    }

    public function permintaan(): HasMany
    {
        return $this->hasMany(Permintaan::class, 'taman_baca_id');
    }

    public function lokasi(): string
    {
        return "{$this->kota}, {$this->provinsi}";
    }
}
