<?php

namespace App\Http\Controllers;

use App\Models\Permintaan;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $permintaan = Permintaan::query()
            ->with(['buku.kategori', 'tamanBaca'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return view('pengelola.riwayat', compact('permintaan'));
    }

    public function batalkan(Request $request, Permintaan $permintaan)
    {
        abort_unless($permintaan->user_id === $request->user()->id, 403);
        abort_unless($permintaan->status === 'diajukan', 403);

        $permintaan->update(['status' => 'dibatalkan']);

        return back()->with('status', 'Permintaan dibatalkan.');
    }

    public function unduh(Request $request, Permintaan $permintaan)
    {
        abort_unless($permintaan->user_id === $request->user()->id, 403);

        if ($permintaan->status !== 'disetujui' || ($permintaan->sisaHari() ?? 0) === 0) {
            return back()->withErrors(['unduh' => 'Tautan unduhan sudah tidak berlaku.']);
        }

        $permintaan->increment('unduhan');

        return back()->with('status', "Tautan unduhan {$permintaan->buku->judul} dibuka. Berlaku {$permintaan->sisaHari()} hari lagi.");
    }
}
