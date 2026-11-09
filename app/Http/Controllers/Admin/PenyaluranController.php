<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Permintaan;
use App\Models\TamanBaca;

class PenyaluranController extends Controller
{
    public function index()
    {
        $perBuku = Buku::with('kategori')
            ->withCount(['permintaan as disetujui' => fn ($q) => $q->where('status', 'disetujui')])
            ->withSum(['permintaan as unduhan' => fn ($q) => $q->where('status', 'disetujui')], 'unduhan')
            ->orderBy('judul')
            ->get();

        $perTamanBaca = TamanBaca::query()
            ->withCount(['permintaan as disetujui' => fn ($q) => $q->where('status', 'disetujui')])
            ->withSum(['permintaan as unduhan' => fn ($q) => $q->where('status', 'disetujui')], 'unduhan')
            ->orderBy('nama')
            ->get();

        $total = [
            'disetujui' => Permintaan::where('status', 'disetujui')->count(),
            'unduhan' => (int) Permintaan::where('status', 'disetujui')->sum('unduhan'),
        ];

        return view('admin.penyaluran.index', compact('perBuku', 'perTamanBaca', 'total'));
    }
}
