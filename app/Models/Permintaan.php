<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Permintaan extends Model
{
    protected $table = 'permintaan';

    protected $fillable = [
        'user_id', 'taman_baca_id', 'buku_id', 'catatan', 'status',
        'alasan_penolakan', 'unduhan', 'ditinjau_pada', 'berlaku_sampai',
    ];

    protected $casts = [
        'ditinjau_pada' => 'datetime',
        'berlaku_sampai' => 'datetime',
    ];

    public const STATUS = ['diajukan', 'disetujui', 'ditolak', 'kedaluwarsa', 'dibatalkan'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tamanBaca(): BelongsTo
    {
        return $this->belongsTo(TamanBaca::class, 'taman_baca_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function labelStatus(): string
    {
        return match ($this->status) {
            'diajukan' => 'Diajukan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'kedaluwarsa' => 'Kedaluwarsa',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    /** Chip biru untuk status aktif/positif, abu-abu untuk status final negatif. */
    public function toneStatus(): string
    {
        return in_array($this->status, ['diajukan', 'disetujui'], true) ? 'blue' : 'gray';
    }

    public function sisaHari(): ?int
    {
        if (! $this->berlaku_sampai) {
            return null;
        }

        $hari = (int) Carbon::now()->startOfDay()->diffInDays($this->berlaku_sampai->startOfDay(), false);

        return $hari > 0 ? $hari : 0;
    }

    public function tanggalAjuan(): string
    {
        return $this->created_at->translatedFormat('j M Y');
    }
}
