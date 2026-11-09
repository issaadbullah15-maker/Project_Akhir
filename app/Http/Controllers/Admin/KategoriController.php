<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('buku')->orderBy('nama')->get();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori,nama'],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori ini sudah ada.',
        ]);

        Kategori::create($data);

        return back()->with('status', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategori,nama,' . $kategori->id],
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori ini sudah ada.',
        ]);

        $kategori->update($data);

        return back()->with('status', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->buku()->exists()) {
            return back()->withErrors([
                'hapus' => "Kategori {$kategori->nama} tidak dapat dihapus karena masih dipakai buku.",
            ]);
        }

        $kategori->delete();

        return back()->with('status', 'Kategori berhasil dihapus.');
    }
}
