<?php

use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PenyaluranController;
use App\Http\Controllers\Admin\PermintaanController as AdminPermintaanController;
use App\Http\Controllers\Admin\TamanBacaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/katalog');

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'create'])->name('login');
    Route::post('/masuk', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/keluar', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');

    Route::get('/ajukan', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/ajukan', [PengajuanController::class, 'store'])->name('pengajuan.store');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::patch('/riwayat/{permintaan}/batalkan', [RiwayatController::class, 'batalkan'])->name('riwayat.batalkan');
    Route::post('/riwayat/{permintaan}/unduh', [RiwayatController::class, 'unduh'])->name('riwayat.unduh');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.permintaan.index'));

    Route::get('/permintaan', [AdminPermintaanController::class, 'index'])->name('permintaan.index');
    Route::patch('/permintaan/{permintaan}/setujui', [AdminPermintaanController::class, 'setujui'])->name('permintaan.setujui');
    Route::patch('/permintaan/{permintaan}/tolak', [AdminPermintaanController::class, 'tolak'])->name('permintaan.tolak');

    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/tambah', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/ubah', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    Route::get('/taman-baca', [TamanBacaController::class, 'index'])->name('taman-baca.index');
    Route::post('/taman-baca', [TamanBacaController::class, 'store'])->name('taman-baca.store');
    Route::put('/taman-baca/{tamanBaca}', [TamanBacaController::class, 'update'])->name('taman-baca.update');
    Route::delete('/taman-baca/{tamanBaca}', [TamanBacaController::class, 'destroy'])->name('taman-baca.destroy');

    Route::get('/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
});
