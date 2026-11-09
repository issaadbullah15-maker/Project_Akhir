# Lentera Baca

Aplikasi web perpustakaan digital untuk taman baca dan sekolah di wilayah 3T (terdepan, terluar, tertinggal).
Dibangun dengan **Laravel 12 + Blade + Tailwind CSS 4 (Vite)**, mengimplementasikan design Figma "Lentera Baca".

## Menjalankan

```bash
cd C:\xampp\htdocs\lentera-baca
composer install          # jika vendor belum ada
npm install && npm run build
php artisan migrate:fresh --seed
php artisan serve
```

Buka http://127.0.0.1:8000

## Akun demo

| Peran | Email | Kata sandi |
| --- | --- | --- |
| Admin | admin@lenterabaca.id | password |
| Pengelola (TBM Pelita Sumba) | afimarsiemo@lenterabaca.id | password |
| Pengelola (TBM Cahaya Wamena) | yulian@lenterabaca.id | password |
| Pengelola (TBM Harapan Nunukan) | siti@lenterabaca.id | password |

## Peta layar (Figma → route)

| Figma | Route | Keterangan |
| --- | --- | --- |
| 01 - Login | `GET /masuk` | Autentikasi email + kata sandi |
| 02 - Pengelola / Katalog Buku | `GET /katalog` | Pencarian judul/penulis, filter kategori & sumber |
| 03 - Pengelola / Formulir Pengajuan | `GET /ajukan` | Pilih buku, catatan keperluan, guard permintaan ganda |
| 04 - Pengelola / Riwayat Permintaan Saya | `GET /riwayat` | Status chip, unduh (14 hari), ubah, batalkan |
| 05 - Admin / Daftar Permintaan | `GET /admin/permintaan` | Filter status, setujui, tolak (modal alasan) |
| 06 - Admin / Kelola Buku | `GET /admin/buku` | CRUD buku + guard hapus |
| 07 - Admin / Tambah Ubah Buku | `GET /admin/buku/tambah`, `GET /admin/buku/{id}/ubah` | Formulir buku, unggah berkas, sakelar aktif |
| 08 - Admin / Kelola Kategori | `GET /admin/kategori` | CRUD kategori + jumlah buku |
| 09 - Admin / Kelola Taman Baca | `GET /admin/taman-baca` | CRUD mitra taman baca |
| 10 - Admin / Riwayat Penyaluran | `GET /admin/penyaluran` | Rekap per buku & per taman baca |

## Design token

Diambil dari Figma dan didefinisikan di `resources/css/app.css` (`@theme`):

| Token | Nilai | Pemakaian |
| --- | --- | --- |
| `brand` | `#2563EB` | Tombol utama, menu aktif, chip aktif |
| `brand-soft` | `#EFF6FF` | Latar chip, latar menu aktif, pemberitahuan |
| `ink` | `#111827` | Teks utama |
| `muted` | `#6B7280` | Teks sekunder |
| `line` | `#DDE1E6` | Border kartu, tabel, input |
| `surface` | `#F9FAFB` | Latar halaman |
| `soft` | `#F3F4F6` | Latar kepala tabel, tombol sekunder |
| Font | Inter 400/500/600/700 | Seluruh teks |
| Radius | 8px | Kartu, tombol, input, chip |
| Container | 720px | Lebar konten utama |

## Komponen Blade

- `x-button` — varian `primary`, `secondary`, `muted`, `danger`; ukuran `md` (44px) & `sm` (40px)
- `x-chip` — tone `blue` (aktif/positif) & `gray` (final negatif)
- `x-field` — label + isian (input/textarea/select/readonly) + hint + pesan error
- `x-card`, `x-page-heading`, `x-modal`, `x-empty-state`
- `x-layouts.app` (dalam aplikasi), `x-layouts.guest` (login)

## Aturan bisnis

- Permintaan berstatus `diajukan` → `disetujui` membuka tautan unduhan selama **14 hari**.
- Satu taman baca tidak boleh punya dua permintaan aktif untuk buku yang sama.
- Kategori yang masih dipakai buku tidak dapat dihapus.
- Buku dengan penyaluran aktif tidak dapat dihapus.
- Taman baca dengan permintaan aktif tidak dapat dihapus.
- Semua route `/admin/*` dilindungi middleware `admin` (403 untuk pengelola).

## Struktur

```
app/Http/Controllers/          AuthController, KatalogController, PengajuanController, RiwayatController
app/Http/Controllers/Admin/    PermintaanController, BukuController, KategoriController, TamanBacaController, PenyaluranController
app/Http/Middleware/           EnsureUserIsAdmin
app/Models/                    User, Buku, Kategori, TamanBaca, Permintaan
resources/views/               auth, pengelola, admin, components
resources/css/app.css          design token Tailwind 4
database/seeders/              data demo 3 taman baca, 12 buku, 13 permintaan
```
