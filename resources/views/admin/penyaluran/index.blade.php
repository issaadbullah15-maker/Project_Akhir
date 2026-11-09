<x-layouts.app title="Riwayat penyaluran">
    <x-page-heading title="Riwayat penyaluran"
        subtitle="Rekap seluruh permintaan yang disetujui dan jumlah unduhan." />

    <div class="flex flex-col gap-3">
        <div class="flex gap-2 border-b border-line pb-2">
            <a href="#per-buku" class="rounded-lg bg-brand-soft px-4 py-2.5 text-sm font-semibold text-brand">Per Buku</a>
            <a href="#per-taman-baca" class="rounded-lg bg-surface px-4 py-2.5 text-sm text-muted hover:bg-soft">Per Taman Baca</a>
        </div>

        <div id="per-buku" class="overflow-x-auto rounded-lg border border-line bg-white">
            <table class="w-full min-w-[720px] table-fixed border-collapse text-left">
                <colgroup>
                <col>
                <col style="width: 136px">
                <col style="width: 160px">
            </colgroup>
            <thead>
                    <tr class="bg-soft text-xs font-semibold leading-[1.5] text-muted">
                        <th class="w-[368px] px-4 py-3">Buku</th>
                        <th class="w-[136px] px-3 py-3">Disetujui</th>
                        <th class="w-[160px] px-3 py-3">Unduhan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perBuku as $item)
                        <tr class="border-t border-line">
                            <td class="px-4 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->judul }}</td>
                            <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->disetujui }}</td>
                            <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ (int) $item->unduhan }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-10 text-center text-sm text-muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div id="per-taman-baca" class="overflow-x-auto rounded-lg border border-line bg-white">
            <table class="w-full min-w-[720px] table-fixed border-collapse text-left">
            <colgroup>
                <col>
                <col style="width: 136px">
                <col style="width: 160px">
            </colgroup>
                            <thead>
                    <tr class="bg-soft text-xs font-semibold leading-[1.5] text-muted">
                        <th class="w-[368px] px-4 py-3">Taman baca</th>
                        <th class="w-[136px] px-3 py-3">Disetujui</th>
                        <th class="w-[160px] px-3 py-3">Unduhan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perTamanBaca as $item)
                        <tr class="border-t border-line">
                            <td class="px-4 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->nama }} · {{ $item->provinsi }}</td>
                            <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ $item->disetujui }}</td>
                            <td class="px-3 py-4 text-[13px] leading-[1.5] text-ink">{{ (int) $item->unduhan }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-10 text-center text-sm text-muted">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-xs leading-[1.5] text-muted">
        Total: {{ $total['disetujui'] }} permintaan disetujui · {{ $total['unduhan'] }} unduhan. Data hingga {{ now()->translatedFormat('j F Y') }}.
    </p>
</x-layouts.app>
