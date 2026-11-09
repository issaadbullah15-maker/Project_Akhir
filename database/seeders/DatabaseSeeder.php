<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Permintaan;
use App\Models\TamanBaca;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $taman = [
            ['nama' => 'TBM Pelita Sumba', 'alamat' => 'Jl. Pendidikan No. 8', 'kota' => 'Waingapu, Sumba Timur', 'provinsi' => 'NTT', 'kontak_nama' => 'Afimarsiemo Abdhira', 'kontak_telepon' => '0812 3456 7011'],
            ['nama' => 'TBM Cahaya Wamena', 'alamat' => 'Jl. Yos Sudarso No. 12', 'kota' => 'Wamena, Jayawijaya', 'provinsi' => 'Papua', 'kontak_nama' => 'Yulian Wenda', 'kontak_telepon' => '0813 4567 8022'],
            ['nama' => 'TBM Harapan Nunukan', 'alamat' => 'Jl. Pelajar No. 5', 'kota' => 'Nunukan Selatan, Nunukan', 'provinsi' => 'Kalimantan Utara', 'kontak_nama' => 'Siti Rahma', 'kontak_telepon' => '0812 5678 9033'],
        ];

        foreach ($taman as $item) {
            TamanBaca::create($item);
        }

        $kategori = ['Filsafat', 'Sastra', 'Sastra Anak', 'Sains', 'Ekonomi', 'Komputer', 'Statistika', 'Data', 'Matematika'];

        foreach ($kategori as $nama) {
            Kategori::create(['nama' => $nama]);
        }

        $buku = [
            ['Justice: What\'s the Right Thing to Do?', 'Michael J. Sandel', 'Filsafat', 'PDF', 'Izin Donatur', 'Harvard Library', 'justice.pdf', '2,4 MB'],
            ['Walden', 'Henry David Thoreau', 'Sastra', 'EPUB', 'Domain Publik', 'Harvard Library', 'walden.epub', '1,1 MB'],
            ['Alice\'s Adventures in Wonderland', 'Lewis Carroll', 'Sastra Anak', 'EPUB', 'Domain Publik', 'University of Oxford (Bodleian Libraries)', 'alice.epub', '1,8 MB'],
            ['The Selfish Gene', 'Richard Dawkins', 'Sains', 'PDF', 'Izin Donatur', 'University of Oxford (Bodleian Libraries)', 'selfish-gene.pdf', '3,2 MB'],
            ['The Wealth of Nations', 'Adam Smith', 'Ekonomi', 'EPUB', 'Domain Publik', 'University of Oxford (Bodleian Libraries)', 'wealth-of-nations.epub', '2,6 MB'],
            ['Structure and Interpretation of Computer Programs', 'Harold Abelson, Gerald Jay Sussman', 'Komputer', 'PDF', 'Lisensi Terbuka', 'MIT Libraries', 'sicp.pdf', '5,4 MB'],
            ['Introduction to Algorithms', 'Thomas H. Cormen, dkk.', 'Komputer', 'PDF', 'Izin Donatur', 'MIT Libraries', 'clrs.pdf', '8,1 MB'],
            ['An Introduction to Statistical Learning', 'Gareth James, dkk.', 'Statistika', 'PDF', 'Izin Donatur', 'Stanford Libraries', 'isl.pdf', '6,7 MB'],
            ['Mining of Massive Datasets', 'Jure Leskovec, Anand Rajaraman, Jeff Ullman', 'Data', 'PDF', 'Izin Donatur', 'Stanford Libraries', 'mmds.pdf', '4,9 MB'],
            ['Mathematics for Machine Learning', 'Marc Peter Deisenroth, dkk.', 'Matematika', 'PDF', 'Izin Donatur', 'Imperial College London Library', 'mml.pdf', '5,8 MB'],
            ['On the Origin of Species', 'Charles Darwin', 'Sains', 'EPUB', 'Domain Publik', 'University of Cambridge Libraries', 'origin.epub', '2,1 MB'],
            ['A Brief History of Time', 'Stephen Hawking', 'Sains', 'PDF', 'Izin Donatur', 'University of Cambridge Libraries', 'brief-history.pdf', '3,4 MB'],
        ];

        foreach ($buku as [$judul, $penulis, $namaKategori, $format, $lisensi, $sumber, $berkas, $ukuran]) {
            Buku::create([
                'judul' => $judul,
                'penulis' => $penulis,
                'kategori_id' => Kategori::where('nama', $namaKategori)->value('id'),
                'format' => $format,
                'lisensi' => $lisensi,
                'sumber' => $sumber,
                'berkas' => $berkas,
                'ukuran' => $ukuran,
                'aktif' => true,
            ]);
        }

        $admin = User::create([
            'name' => 'Issa Maulana',
            'email' => 'admin@lenterabaca.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $pengelola = [
            ['Afimarsiemo Abdhira', 'afimarsiemo@lenterabaca.id', 1],
            ['Yulian Wenda', 'yulian@lenterabaca.id', 2],
            ['Siti Rahma', 'siti@lenterabaca.id', 3],
        ];

        foreach ($pengelola as [$nama, $email, $tamanId]) {
            User::create([
                'name' => $nama,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'pengelola',
                'taman_baca_id' => $tamanId,
            ]);
        }

        $afimarsiemo = User::where('email', 'afimarsiemo@lenterabaca.id')->firstOrFail();
        $yulian = User::where('email', 'yulian@lenterabaca.id')->firstOrFail();
        $siti = User::where('email', 'siti@lenterabaca.id')->firstOrFail();

        $permintaan = [
            // [user, buku, status, hari_lalu, alasan, unduhan, sisa_hari]
            [$afimarsiemo, 'Justice: What\'s the Right Thing to Do?', 'diajukan', 0, null, 0, null],
            [$afimarsiemo, 'Walden', 'disetujui', 5, null, 6, 9],
            [$afimarsiemo, 'The Selfish Gene', 'ditolak', 8, 'Izin distribusi dari donatur belum mencakup penyaluran digital.', 0, null],
            [$afimarsiemo, 'Alice\'s Adventures in Wonderland', 'kedaluwarsa', 26, null, 4, -12],
            [$afimarsiemo, 'The Wealth of Nations', 'dibatalkan', 28, null, 0, null],
            [$yulian, 'Structure and Interpretation of Computer Programs', 'diajukan', 1, null, 0, null],
            [$yulian, 'Introduction to Algorithms', 'disetujui', 6, null, 3, 8],
            [$siti, 'An Introduction to Statistical Learning', 'diajukan', 2, null, 0, null],
            [$siti, 'Mining of Massive Datasets', 'disetujui', 9, null, 2, 5],
            [$siti, 'Mathematics for Machine Learning', 'ditolak', 11, 'Kuota penyaluran digital untuk bulan ini sudah terpenuhi.', 0, null],
            [$yulian, 'On the Origin of Species', 'disetujui', 12, null, 5, 2],
            [$siti, 'A Brief History of Time', 'diajukan', 3, null, 0, null],
            [$afimarsiemo, 'Introduction to Algorithms', 'diajukan', 0, null, 0, null],
        ];

        foreach ($permintaan as [$user, $judul, $status, $hariLalu, $alasan, $unduhan, $sisaHari]) {
            $dibuat = Carbon::now()->subDays($hariLalu);

            Permintaan::create([
                'user_id' => $user->id,
                'taman_baca_id' => $user->taman_baca_id,
                'buku_id' => Buku::where('judul', $judul)->value('id'),
                'status' => $status,
                'alasan_penolakan' => $alasan,
                'unduhan' => $unduhan,
                'ditinjau_pada' => in_array($status, ['disetujui', 'ditolak'], true) ? $dibuat->copy()->addDay() : null,
                'berlaku_sampai' => $sisaHari === null ? null : Carbon::now()->addDays($sisaHari),
                'created_at' => $dibuat,
                'updated_at' => $dibuat,
            ]);
        }
    }
}
