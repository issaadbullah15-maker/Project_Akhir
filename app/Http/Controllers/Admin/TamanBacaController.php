<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TamanBaca;
use Illuminate\Http\Request;

class TamanBacaController extends Controller
{
    public function index()
    {
        $tamanBaca = TamanBaca::orderBy('nama')->get();

        return view('admin.taman-baca.index', compact('tamanBaca'));
    }

    public function store(Request $request)
    {
        TamanBaca::create($this->validated($request));

        return back()->with('status', 'Taman baca berhasil ditambahkan.');
    }

    public function update(Request $request, TamanBaca $tamanBaca)
    {
        $tamanBaca->update($this->validated($request));

        return back()->with('status', 'Data taman baca berhasil diperbarui.');
    }

    public function destroy(TamanBaca $tamanBaca)
    {
        if ($tamanBaca->permintaan()->whereIn('status', ['diajukan', 'disetujui'])->exists()) {
            return back()->withErrors([
                'hapus' => 'Taman baca tidak dapat dihapus karena masih memiliki permintaan aktif.',
            ]);
        }

        $tamanBaca->delete();

        return back()->with('status', 'Taman baca berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kontak_nama' => ['required', 'string', 'max:255'],
            'kontak_telepon' => ['required', 'string', 'max:32'],
        ], [
            'nama.required' => 'Nama taman baca wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'kontak_nama.required' => 'Nama kontak wajib diisi.',
            'kontak_telepon.required' => 'Nomor kontak wajib diisi.',
        ]);
    }
}
