<x-layouts.app title="Kelola kategori">
    <x-page-heading title="Kelola kategori" subtitle="Kelompokkan buku agar mudah ditemukan oleh pengelola.">
        <x-slot:actions>
            <button type="button" data-open-modal="kategori-baru"
                class="inline-flex h-11 items-center justify-center rounded-lg border border-brand bg-brand px-5 text-sm font-semibold text-white hover:bg-[#1d4ed8]">
                Tambah
            </button>
        </x-slot:actions>
    </x-page-heading>

    <div class="overflow-x-auto rounded-lg border border-line bg-white">
        <table class="w-full min-w-[720px] table-fixed border-collapse text-left">
            <colgroup>
                <col style="width: 300px">
                <col style="width: 172px">
                <col style="width: 192px">
            </colgroup>
            <thead>
                <tr class="bg-soft text-xs font-semibold leading-[1.5] text-muted">
                    <th class="w-[300px] px-4 py-3">Nama kategori</th>
                    <th class="w-[172px] px-3 py-3">Jumlah buku</th>
                    <th class="w-[192px] px-3 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategori as $item)
                    <tr class="border-t border-line align-middle">
                        <td class="px-4 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->nama }}</td>
                        <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->buku_count }} buku</td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col gap-2">
                                <button type="button" data-open-modal="ubah-kategori-{{ $item->id }}"
                                    class="inline-flex h-10 w-[58px] items-center justify-center rounded-lg border border-line bg-white text-[13px] font-semibold text-ink hover:bg-soft">
                                    Ubah
                                </button>
                                <button type="button" data-open-modal="hapus-kategori-{{ $item->id }}"
                                    class="inline-flex h-10 w-[65px] items-center justify-center rounded-lg border border-line bg-white text-[13px] font-semibold text-ink hover:bg-soft">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-10 text-center text-sm text-muted">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-modal id="kategori-baru" title="Tambah kategori" description="Kategori baru akan langsung tersedia di katalog.">
        <form method="POST" action="{{ route('admin.kategori.store') }}" class="flex flex-col gap-4">
            @csrf
            <x-field label="Nama kategori" name="nama" placeholder="Cerita Anak" required />
            <div class="flex items-center justify-end gap-2">
                <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                <x-button size="sm" type="submit">Simpan</x-button>
            </div>
        </form>
    </x-modal>

    @foreach ($kategori as $item)
        <x-modal :id="'ubah-kategori-'.$item->id" title="Ubah kategori" :description="'Perbarui nama kategori '.$item->nama.'.'">
            <form method="POST" action="{{ route('admin.kategori.update', $item) }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <x-field label="Nama kategori" name="nama" :value="$item->nama" required />
                <div class="flex items-center justify-end gap-2">
                    <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                    <x-button size="sm" type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        <x-modal :id="'hapus-kategori-'.$item->id" title="Hapus kategori"
            :description="'Kategori '.$item->nama.' akan dihapus dari daftar.'">
            <form method="POST" action="{{ route('admin.kategori.destroy', $item) }}" class="flex items-center justify-end gap-2">
                @csrf
                @method('DELETE')
                <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                <x-button variant="danger" size="sm" type="submit">Hapus kategori</x-button>
            </form>
        </x-modal>
    @endforeach

    <p class="text-xs leading-[1.5] text-muted">{{ $kategori->count() }} kategori untuk {{ $kategori->sum('buku_count') }} buku.</p>
</x-layouts.app>
