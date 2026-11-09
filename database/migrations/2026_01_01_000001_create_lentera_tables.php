<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('pengelola')->after('password');
            $table->foreignId('taman_baca_id')->nullable()->after('role');
        });

        Schema::create('taman_baca', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat');
            $table->string('kota');
            $table->string('provinsi');
            $table->string('kontak_nama');
            $table->string('kontak_telepon');
            $table->timestamps();
        });

        Schema::create('kategori', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->foreignId('kategori_id')->constrained('kategori')->cascadeOnDelete();
            $table->string('format')->default('PDF');
            $table->string('lisensi')->default('Izin Donatur');
            $table->string('sumber')->nullable();
            $table->string('berkas')->nullable();
            $table->string('ukuran')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('permintaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('taman_baca_id')->nullable()->constrained('taman_baca')->nullOnDelete();
            $table->foreignId('buku_id')->constrained('buku')->cascadeOnDelete();
            $table->text('catatan')->nullable();
            $table->string('status')->default('diajukan');
            $table->text('alasan_penolakan')->nullable();
            $table->unsignedInteger('unduhan')->default(0);
            $table->timestamp('ditinjau_pada')->nullable();
            $table->timestamp('berlaku_sampai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan');
        Schema::dropIfExists('buku');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('taman_baca');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'taman_baca_id']);
        });
    }
};
