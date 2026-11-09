<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Permintaan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function create(Request $request)
    {
        $buku = Buku::with('kategori')->where('aktif', true)->orderBy('judul')->get();

        $dipilih = $request->filled('buku')
            ? $buku->firstWhere('id', $request->integer('buku'))
            : $buku->first();

        $aktif = Permintaan::query()
            ->where('user_id', $request->user()->id)
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->pluck('buku_id');

        return view('pengelola.ajukan', compact('buku', 'dipilih', 'aktif'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'buku_id' => ['required', 'exists:buku,id'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ], [
            'buku_id.required' => 'Pilih buku yang dibutuhkan.',
            'catatan.max' => 'Catatan maksimal 255 karakter.',
        ]);

        $sudahAda = Permintaan::query()
            ->where('user_id', $request->user()->id)
            ->where('buku_id', $data['buku_id'])
            ->whereIn('status', ['diajukan', 'disetujui'])
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors(['buku_id' => 'Taman baca Anda sudah memiliki permintaan aktif untuk buku ini.']);
        }

        Permintaan::create([
            'user_id' => $request->user()->id,
            'taman_baca_id' => $request->user()->taman_baca_id,
            'buku_id' => $data['buku_id'],
            'catatan' => $data['catatan'] ?? null,
            'status' => 'diajukan',
        ]);

        return redirect()
            ->route('riwayat.index')
            ->with('status', 'Permintaan berhasil dikirim dan menunggu tinjauan admin.');
    }
}
