<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PermintaanController extends Controller
{
    public function index(Request $request)
    {
        $permintaan = Permintaan::query()
            ->with(['buku.kategori', 'tamanBaca', 'user'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $ringkasan = [
            'total' => Permintaan::count(),
            'perlu_ditinjau' => Permintaan::where('status', 'diajukan')->count(),
        ];

        return view('admin.permintaan.index', compact('permintaan', 'ringkasan'));
    }

    public function setujui(Request $request, Permintaan $permintaan)
    {
        abort_unless($permintaan->status === 'diajukan', 403);

        $permintaan->update([
            'status' => 'disetujui',
            'ditinjau_pada' => Carbon::now(),
            'berlaku_sampai' => Carbon::now()->addDays(14),
        ]);

        return back()->with('status', "Permintaan {$permintaan->buku->judul} disetujui. Tautan unduhan berlaku 14 hari.");
    }

    public function tolak(Request $request, Permintaan $permintaan)
    {
        abort_unless($permintaan->status === 'diajukan', 403);

        $data = $request->validate([
            'alasan_penolakan' => ['required', 'string', 'max:255'],
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $permintaan->update([
            'status' => 'ditolak',
            'alasan_penolakan' => $data['alasan_penolakan'],
            'ditinjau_pada' => Carbon::now(),
        ]);

        return back()->with('status', "Permintaan {$permintaan->buku->judul} ditolak.");
    }
}
