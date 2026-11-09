<x-layouts.app title="Kelola buku">
    <x-page-heading title="Kelola buku" subtitle="Kelola data dan berkas buku digital di katalog.">
        <x-slot:actions>
            <x-button href="{{ route('admin.buku.create') }}">Tambah</x-button>
        </x-slot:actions>
    </x-page-heading>

    <div class="overflow-x-auto rounded-lg border border-line bg-white">
        <table class="w-full min-w-[720px] table-fixed border-collapse text-left">
            <colgroup>
                <col style="width: 148px">
                <col style="width: 86px">
                <col style="width: 68px">
                <col style="width: 48px">
                <col style="width: 84px">
                <col style="width: 56px">
                <col style="width: 82px">
                <col>
            </colgroup>
            <thead>
                <tr class="bg-soft text-xs font-semibold leading-[1.5] text-muted">
                    <th class="py-3 pl-3 pr-1 font-semibold">Judul</th>
                    <th class="px-1 py-3 font-semibold">Penulis</th>
                    <th class="px-1 py-3 font-semibold">Kategori</th>
                    <th class="px-1 py-3 font-semibold">Format</th>
                    <th class="px-1 py-3 font-semibold">Lisensi</th>
                    <th class="px-1 py-3 font-semibold">Status</th>
                    <th class="px-1 py-3 font-semibold">Aksi</th>
                    <th class="py-3 pl-1 pr-3 font-semibold">Sumber</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $item)
                    <tr class="border-t border-line align-middle">
                        <td class="py-4 pl-3 pr-1">
                            <p class="text-[13px] font-medium leading-[1.5] text-ink">{{ $item->judul }}</p>
                            <p class="text-xs leading-[1.5] text-muted">{{ $item->created_at->format('Y') }}</p>
                        </td>
                        <td class="px-1 py-4 text-xs leading-[1.5] text-ink">{{ $item->penulis }}</td>
                        <td class="px-1 py-4 text-xs leading-[1.5] text-ink">{{ $item->kategori->nama }}</td>
                        <td class="px-1 py-4 text-xs leading-[1.5] text-ink">{{ $item->format }}</td>
                        <td class="px-1 py-4 text-xs leading-[1.5] text-ink">{{ $item->lisensi }}</td>
                        <td class="px-1 py-4 text-xs leading-[1.5] text-ink">{{ $item->aktif ? 'Aktif' : 'Nonaktif' }}</td>
                        <td class="px-1 py-4">
                            <div class="flex flex-col gap-2">
                                <x-button href="{{ route('admin.buku.edit', $item) }}" variant="secondary" size="sm" class="w-[58px] px-0">Ubah</x-button>
                                <button type="button" data-open-modal="hapus-{{ $item->id }}"
                                    class="inline-flex h-10 w-[65px] items-center justify-center rounded-lg border border-line bg-white text-[13px] font-semibold text-ink hover:bg-soft">
                                    Hapus
                                </button>
                            </div>
                        </td>
                        <td class="py-4 pl-1 pr-3 text-xs leading-[1.5] text-muted">{{ $item->sumber ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-10 text-center text-sm text-muted">Belum ada buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach ($buku as $item)
        <x-modal :id="'hapus-'.$item->id" title="Hapus buku"
            :description="'Buku '.$item->judul.' akan dihapus dari katalog. Tindakan ini tidak dapat dibatalkan.'">
            <form method="POST" action="{{ route('admin.buku.destroy', $item) }}" class="flex items-center justify-end gap-2">
                @csrf
                @method('DELETE')
                <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                <x-button variant="danger" size="sm" type="submit">Hapus buku</x-button>
            </form>
        </x-modal>
    @endforeach

    <div>{{ $buku->links() }}</div>

    <p class="text-xs leading-[1.5] text-muted">{{ $buku->total() }} buku terdaftar di katalog.</p>
</x-layouts.app>
