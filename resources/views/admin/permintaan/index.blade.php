<x-layouts.app title="Daftar permintaan">
    <x-page-heading title="Daftar permintaan"
        subtitle="Tinjau kebutuhan buku dari taman baca dan sekolah mitra." />

    <form method="GET" action="{{ route('admin.permintaan.index') }}" class="flex items-end justify-between gap-4">
        <div class="w-full sm:w-[240px]">
            <label for="status" class="mb-2 block text-sm font-medium leading-[1.5] text-ink">Status permintaan</label>
            <select id="status" name="status" onchange="this.form.submit()"
                class="min-h-[46px] w-full rounded-lg border border-line bg-white px-3 py-3 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                <option value="">Semua status</option>
                @foreach (\App\Models\Permintaan::STATUS as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>
        <p class="pb-3 text-xs leading-[1.5] text-muted">
            {{ $ringkasan['total'] }} permintaan · {{ $ringkasan['perlu_ditinjau'] }} perlu ditinjau
        </p>
    </form>

    <div class="overflow-x-auto rounded-lg border border-line bg-white">
        <table class="w-full min-w-[720px] table-fixed border-collapse text-left">
            <colgroup>
                <col style="width: 148px">
                <col style="width: 120px">
                <col>
                <col style="width: 96px">
                <col style="width: 92px">
                <col style="width: 104px">
            </colgroup>
            <thead>
                <tr class="bg-soft text-xs font-semibold leading-[1.5] text-muted">
                    <th class="px-4 py-3 font-semibold">Taman baca</th>
                    <th class="px-3 py-3 font-semibold">Pengaju</th>
                    <th class="px-3 py-3 font-semibold">Buku</th>
                    <th class="px-3 py-3 font-semibold">Tanggal</th>
                    <th class="px-3 py-3 font-semibold">Status</th>
                    <th class="px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($permintaan as $item)
                    <tr class="border-t border-line align-middle">
                        <td class="px-4 py-4">
                            <p class="text-[13px] font-medium leading-[1.5] text-ink">{{ $item->tamanBaca?->nama ?? '—' }}</p>
                            <p class="text-xs leading-[1.5] text-muted">{{ $item->tamanBaca?->provinsi }}</p>
                        </td>
                        <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->user->name }}</td>
                        <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->buku->judul }}</td>
                        <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->tanggalAjuan() }}</td>
                        <td class="px-3 py-4">
                            <x-chip :tone="$item->toneStatus()">{{ $item->labelStatus() }}</x-chip>
                        </td>
                        <td class="px-4 py-4">
                            @if ($item->status === 'diajukan')
                                <div class="flex flex-col gap-2">
                                    <form method="POST" action="{{ route('admin.permintaan.setujui', $item) }}">
                                        @csrf
                                        @method('PATCH')
                                        <x-button size="sm" type="submit" class="w-full">Setujui</x-button>
                                    </form>
                                    <button type="button" data-open-modal="tolak-{{ $item->id }}"
                                        class="inline-flex h-10 w-full items-center justify-center rounded-lg border border-line bg-white px-[12px] text-[13px] font-semibold text-ink hover:bg-soft">
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <span class="text-[13px] leading-[1.5] text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-muted">Belum ada permintaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach ($permintaan as $item)
        @if ($item->status === 'diajukan')
            <x-modal :id="'tolak-'.$item->id" title="Tolak permintaan"
                :description="'Tolak permintaan '.$item->buku->judul.' dari '.$item->tamanBaca?->nama.'.'">
                <form method="POST" action="{{ route('admin.permintaan.tolak', $item) }}" class="flex flex-col gap-4">
                    @csrf
                    @method('PATCH')
                    <x-field label="Alasan penolakan" name="alasan_penolakan" type="textarea"
                        placeholder="Izin distribusi dari donatur belum mencakup penyaluran digital."
                        hint="Alasan akan ditampilkan kepada pengelola." />
                    <div class="flex items-center justify-end gap-2">
                        <x-button variant="secondary" size="sm" type="button" data-close-modal>Tutup</x-button>
                        <x-button size="sm" type="submit">Tolak permintaan</x-button>
                    </div>
                </form>
            </x-modal>
        @endif
    @endforeach

    <div>{{ $permintaan->links() }}</div>

    <p class="text-xs leading-[1.5] text-muted">Persetujuan akan membuka tautan unduhan selama 14 hari.</p>
</x-layouts.app>
