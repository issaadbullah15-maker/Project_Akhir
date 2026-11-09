<x-layouts.app title="Katalog buku">
    <x-page-heading title="Katalog buku"
        subtitle="Temukan buku digital untuk kegiatan belajar di taman baca Anda." />

    <form method="GET" action="{{ route('katalog.index') }}" class="flex flex-col items-stretch gap-4 sm:flex-row sm:items-start">
        <div class="flex-1">
            <x-field label="Cari buku" name="q" placeholder="Cari judul atau penulis" :value="request('q')" />
        </div>
        <div class="sm:w-[240px]">
            <label for="kategori" class="mb-2 block text-sm font-medium leading-[1.5] text-ink">Kategori</label>
            <select id="kategori" name="kategori"
                class="min-h-[46px] w-full rounded-lg border border-line bg-white px-3 py-3 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                <option value="">Semua kategori</option>
                @foreach ($kategori as $item)
                    <option value="{{ $item->id }}" @selected((string) request('kategori') === (string) $item->id)>{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="sm:w-[240px]">
            <label for="sumber" class="mb-2 block text-sm font-medium leading-[1.5] text-ink">Sumber (universitas)</label>
            <select id="sumber" name="sumber"
                class="min-h-[46px] w-full rounded-lg border border-line bg-white px-3 py-3 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                <option value="">Semua sumber</option>
                @foreach ($sumber as $item)
                    <option value="{{ $item }}" @selected(request('sumber') === $item)>{{ $item }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end sm:pt-7">
            <x-button type="submit" variant="secondary">Terapkan</x-button>
        </div>
    </form>

    @if ($buku->isEmpty())
        <x-empty-state message="Tidak ada buku yang cocok dengan pencarian Anda." />
    @else
        <div class="flex flex-col gap-3">
            @foreach ($buku as $item)
                <div class="flex items-center gap-5 rounded-lg border border-line bg-white p-5">
                    <div class="min-w-0 flex-1 leading-[1.5]">
                        <p class="text-base font-semibold text-ink">{{ $item->judul }}</p>
                        <p class="text-sm text-muted">{{ $item->penulis }}</p>
                        <p class="text-xs text-muted">{{ $item->label() }}</p>
                    </div>
                    <x-button href="{{ route('pengajuan.create', ['buku' => $item->id]) }}">Ajukan</x-button>
                </div>
            @endforeach
        </div>

        <p class="text-xs leading-[1.5] text-muted">
            Menampilkan {{ $buku->count() }} buku tersedia. Penyaluran mengikuti ketentuan lisensi setiap buku.
        </p>
    @endif
</x-layouts.app>
