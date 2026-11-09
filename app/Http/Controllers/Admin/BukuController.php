<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->withCount('permintaan')->orderBy('judul')->paginate(8);

        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.buku.form', [
            'buku' => new Buku(['format' => 'PDF', 'lisensi' => 'Izin Donatur', 'aktif' => true]),
            'kategori' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.form', [
            'buku' => $buku,
            'kategori' => Kategori::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Buku::create($this->validated($request));

        return redirect()->route('admin.buku.index')->with('status', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, Buku $buku)
    {
        $buku->update($this->validated($request, $buku));

        return redirect()->route('admin.buku.index')->with('status', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->permintaan()->whereIn('status', ['disetujui'])->exists()) {
            return back()->withErrors([
                'hapus' => 'Buku tidak dapat dihapus karena masih memiliki penyaluran aktif.',
            ]);
        }

        $buku->delete();

        return back()->with('status', 'Buku berhasil dihapus.');
    }

    private function validated(Request $request, ?Buku $buku = null): array
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'kategori_id' => ['required', 'exists:kategori,id'],
            'format' => ['required', Rule::in(['PDF', 'EPUB'])],
            'lisensi' => ['required', Rule::in(['Izin Donatur', 'Domain Publik', 'Lisensi Terbuka'])],
            'sumber' => ['nullable', 'string', 'max:255'],
            'berkas' => ['nullable', 'string', 'max:255'],
            'ukuran' => ['nullable', 'string', 'max:32'],
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'penulis.required' => 'Penulis wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
        ]);

        $data['aktif'] = $request->boolean('aktif');

        return $data;
    }
}
