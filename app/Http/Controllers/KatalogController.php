<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $buku = Buku::query()
            ->with('kategori')
            ->where('aktif', true)
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->string('q')->toString();
                $query->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")->orWhere('penulis', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('kategori'), fn ($query) => $query->where('kategori_id', $request->integer('kategori')))
            ->when($request->filled('sumber'), fn ($query) => $query->where('sumber', $request->string('sumber')->toString()))
            ->orderBy('judul')
            ->get();

        return view('pengelola.katalog', [
            'buku' => $buku,
            'kategori' => Kategori::orderBy('nama')->get(),
            'sumber' => Buku::query()->whereNotNull('sumber')->distinct()->orderBy('sumber')->pluck('sumber'),
        ]);
    }
}
