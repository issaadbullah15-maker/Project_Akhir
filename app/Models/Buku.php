<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = [
        'judul', 'penulis', 'kategori_id', 'format', 'lisensi', 'sumber', 'berkas', 'ukuran', 'aktif',
    ];

    protected $casts = ['aktif' => 'boolean'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function permintaan(): HasMany
    {
        return $this->hasMany(Permintaan::class, 'buku_id');
    }

    /** "Filsafat · PDF · Izin Donatur" */
    public function label(): string
    {
        return "{$this->kategori->nama} · {$this->format} · {$this->lisensi}";
    }

    /** "Filsafat · Michael J. Sandel · PDF · Izin Donatur · Harvard Library" */
    public function labelLengkap(): string
    {
        return collect([$this->kategori->nama, $this->penulis, $this->format, $this->lisensi, $this->sumber])
            ->filter()
            ->implode(' · ');
    }
}
