<x-layouts.app :title="$buku->exists ? 'Ubah buku' : 'Tambah buku'">
    <x-page-heading :title="$buku->exists ? 'Ubah buku' : 'Tambah buku'"
        subtitle="Lengkapi data dan unggah berkas buku digital." />

    <form method="POST"
        action="{{ $buku->exists ? route('admin.buku.update', $buku) : route('admin.buku.store') }}"
        class="flex flex-col gap-3 rounded-lg border border-line bg-white p-5">
        @csrf
        @if ($buku->exists)
            @method('PUT')
        @endif

        <x-field label="Judul buku" name="judul" :value="$buku->judul" placeholder="Justice: What's the Right Thing to Do?" required />
        <x-field label="Penulis" name="penulis" :value="$buku->penulis" placeholder="Michael J. Sandel" required />

        <div class="flex flex-col gap-1">
            <label for="kategori_id" class="text-sm font-medium leading-[1.5] text-ink">Kategori</label>
            <select id="kategori_id" name="kategori_id" required
                class="min-h-[40px] w-full rounded-lg border border-line bg-white px-3 py-2 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" @selected(old('kategori_id', $buku->kategori_id) == $item->id)>{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label for="format" class="text-sm font-medium leading-[1.5] text-ink">Format</label>
            <select id="format" name="format" required
                class="min-h-[40px] w-full rounded-lg border border-line bg-white px-3 py-2 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @foreach (['PDF', 'EPUB'] as $format)
                    <option value="{{ $format }}" @selected(old('format', $buku->format) === $format)>{{ $format }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium leading-[1.5] text-ink">Berkas buku (PDF / EPUB)</label>
            <div class="flex items-center gap-3 rounded-lg border border-line p-2">
                <span class="inline-flex h-10 items-center justify-center rounded-lg border border-line bg-white px-[12px] text-[13px] font-semibold text-ink">Pilih berkas</span>
                <input name="berkas" value="{{ old('berkas', $buku->berkas) }}" placeholder="justice.pdf"
                    class="min-w-0 flex-1 border-0 bg-transparent text-[13px] text-ink placeholder:text-muted focus:outline-none">
                <input name="ukuran" value="{{ old('ukuran', $buku->ukuran) }}" placeholder="2,4 MB"
                    class="w-20 border-0 bg-transparent text-right text-[13px] text-muted placeholder:text-muted focus:outline-none">
            </div>
            <p class="text-xs leading-[1.5] text-muted">Isi nama berkas dan ukuran. Unggahan biner belum diaktifkan.</p>
        </div>

        <div class="flex flex-col gap-1">
            <label for="lisensi" class="text-sm font-medium leading-[1.5] text-ink">Lisensi</label>
            <select id="lisensi" name="lisensi" required
                class="min-h-[40px] w-full rounded-lg border border-line bg-white px-3 py-2 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @foreach (['Izin Donatur', 'Domain Publik', 'Lisensi Terbuka'] as $lisensi)
                    <option value="{{ $lisensi }}" @selected(old('lisensi', $buku->lisensi) === $lisensi)>{{ $lisensi }}</option>
                @endforeach
            </select>
        </div>

        <x-field label="Sumber / donatur (opsional)" name="sumber" :value="$buku->sumber" placeholder="Harvard Library" />

        <div class="flex items-center gap-3">
            <label class="relative inline-flex cursor-pointer items-center">
                <input type="checkbox" name="aktif" value="1" class="peer sr-only" @checked(old('aktif', $buku->aktif))>
                <span class="h-6 w-10 rounded-full bg-track transition-colors peer-checked:bg-brand"></span>
                <span class="absolute left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-4"></span>
            </label>
            <p class="text-sm font-medium leading-[1.5] text-ink">Aktif</p>
            <p class="flex-1 text-xs leading-[1.5] text-muted">Tampilkan buku di katalog.</p>
        </div>

        <div class="flex items-center justify-end gap-2">
            <x-button href="{{ route('admin.buku.index') }}" variant="secondary">Batal</x-button>
            <x-button type="submit">Simpan</x-button>
        </div>
    </form>
</x-layouts.app>
