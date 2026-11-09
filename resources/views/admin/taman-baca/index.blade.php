<x-layouts.app title="Kelola taman baca">
    <x-page-heading title="Kelola taman baca" subtitle="Kelola identitas dan kontak taman baca mitra di wilayah 3T.">
        <x-slot:actions>
            <button type="button" data-open-modal="taman-baru"
                class="inline-flex h-11 items-center justify-center rounded-lg border border-brand bg-brand px-5 text-sm font-semibold text-white hover:bg-[#1d4ed8]">
                Tambah
            </button>
        </x-slot:actions>
    </x-page-heading>

    <div class="overflow-x-auto rounded-lg border border-line bg-white">
        <table class="w-full min-w-[720px] table-fixed border-collapse text-left">
            <colgroup>
                <col style="width: 168px">
                <col>
                <col style="width: 168px">
                <col style="width: 104px">
            </colgroup>
            <thead>
                <tr class="bg-soft text-xs font-semibold leading-[1.5] text-muted">
                    <th class="w-[160px] px-4 py-3">Nama</th>
                    <th class="w-[222px] px-3 py-3">Alamat</th>
                    <th class="w-[166px] px-3 py-3">Kontak</th>
                    <th class="w-[104px] px-3 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tamanBaca as $item)
                    <tr class="border-t border-line align-middle">
                        <td class="px-4 py-4 text-sm font-medium leading-[1.5] text-ink">{{ $item->nama }}</td>
                        <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->alamat }}, {{ $item->lokasi() }}</td>
                        <td class="px-3 py-4 leading-[1.5]">
                            <p class="text-[13px] text-ink">{{ $item->kontak_nama }}</p>
                            <p class="text-xs text-muted">{{ $item->kontak_telepon }}</p>
                        </td>
                        <td class="px-3 py-4">
                            <div class="flex flex-col gap-2">
                                <button type="button" data-open-modal="ubah-taman-{{ $item->id }}"
                                    class="inline-flex h-10 w-[58px] items-center justify-center rounded-lg border border-line bg-white text-[13px] font-semibold text-ink hover:bg-soft">
                                    Ubah
                                </button>
                                <button type="button" data-open-modal="hapus-taman-{{ $item->id }}"
                                    class="inline-flex h-10 w-[65px] items-center justify-center rounded-lg border border-line bg-white text-[13px] font-semibold text-ink hover:bg-soft">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-10 text-center text-sm text-muted">Belum ada taman baca.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-modal id="taman-baru" title="Tambah taman baca" description="Lengkapi identitas dan kontak penanggung jawab.">
        <form method="POST" action="{{ route('admin.taman-baca.store') }}" class="flex flex-col gap-4">
            @csrf
            <x-field label="Nama taman baca" name="nama" placeholder="TBM Pelita Sumba" required />
            <x-field label="Alamat" name="alamat" placeholder="Jl. Pendidikan No. 8, Waingapu" required />
            <div class="grid grid-cols-2 gap-3">
                <x-field label="Kota" name="kota" placeholder="Sumba Timur" required />
                <x-field label="Provinsi" name="provinsi" placeholder="Nusa Tenggara Timur" required />
            </div>
            <x-field label="Nama kontak" name="kontak_nama" placeholder="Afimarsiemo Abdhira" required />
            <x-field label="Nomor kontak" name="kontak_telepon" placeholder="0812 3456 7011" required />
            <div class="flex items-center justify-end gap-2">
                <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                <x-button size="sm" type="submit">Simpan</x-button>
            </div>
        </form>
    </x-modal>

    @foreach ($tamanBaca as $item)
        <x-modal :id="'ubah-taman-'.$item->id" title="Ubah taman baca" :description="'Perbarui data '.$item->nama.'.'">
            <form method="POST" action="{{ route('admin.taman-baca.update', $item) }}" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                <x-field label="Nama taman baca" name="nama" :value="$item->nama" required />
                <x-field label="Alamat" name="alamat" :value="$item->alamat" required />
                <div class="grid grid-cols-2 gap-3">
                    <x-field label="Kota" name="kota" :value="$item->kota" required />
                    <x-field label="Provinsi" name="provinsi" :value="$item->provinsi" required />
                </div>
                <x-field label="Nama kontak" name="kontak_nama" :value="$item->kontak_nama" required />
                <x-field label="Nomor kontak" name="kontak_telepon" :value="$item->kontak_telepon" required />
                <div class="flex items-center justify-end gap-2">
                    <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                    <x-button size="sm" type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        <x-modal :id="'hapus-taman-'.$item->id" title="Hapus taman baca"
            :description="'Data '.$item->nama.' akan dihapus dari daftar mitra.'">
            <form method="POST" action="{{ route('admin.taman-baca.destroy', $item) }}" class="flex items-center justify-end gap-2">
                @csrf
                @method('DELETE')
                <x-button variant="secondary" size="sm" type="button" data-close-modal>Batal</x-button>
                <x-button variant="danger" size="sm" type="submit">Hapus taman baca</x-button>
            </form>
        </x-modal>
    @endforeach

    <p class="text-xs leading-[1.5] text-muted">{{ $tamanBaca->count() }} taman baca terdaftar.</p>
</x-layouts.app>
