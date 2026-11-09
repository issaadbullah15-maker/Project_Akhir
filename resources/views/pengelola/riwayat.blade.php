<x-layouts.app title="Riwayat permintaan saya">
    <x-page-heading title="Riwayat permintaan saya"
        subtitle="Pantau pengajuan dan unduh buku yang telah disetujui untuk {{ auth()->user()->tamanBaca?->nama ?? 'taman baca Anda' }}." />

    @if ($permintaan->isEmpty())
        <x-empty-state message="Belum ada permintaan. Mulai dari katalog buku." />
    @else
        <div class="flex flex-col gap-3">
            @foreach ($permintaan as $item)
                <div class="flex flex-col gap-[10px] rounded-lg border border-line bg-white p-5">
                    <div class="flex items-start gap-4">
                        <div class="min-w-0 flex-1 leading-[1.5]">
                            <p class="text-base font-semibold text-ink">{{ $item->buku->judul }}</p>
                            <p class="text-xs text-muted">
                                Diajukan {{ $item->tanggalAjuan() }} · {{ $item->user->name }}
                            </p>
                        </div>
                        <x-chip :tone="$item->toneStatus()">{{ $item->labelStatus() }}</x-chip>
                    </div>

                    @if ($item->status === 'ditolak' && $item->alasan_penolakan)
                        <p class="text-[13px] leading-[1.5] text-muted">Alasan admin: {{ $item->alasan_penolakan }}</p>
                    @endif

                    @if ($item->status === 'diajukan')
                        <div class="flex items-center gap-2">
                            <x-button href="{{ route('pengajuan.create', ['buku' => $item->buku_id]) }}" variant="secondary" size="sm">Ubah</x-button>
                            <form method="POST" action="{{ route('riwayat.batalkan', $item) }}">
                                @csrf
                                @method('PATCH')
                                <x-button variant="secondary" size="sm" type="submit">Batalkan</x-button>
                            </form>
                        </div>
                    @endif

                    @if ($item->status === 'disetujui')
                        <div class="flex items-center gap-3">
                            <form method="POST" action="{{ route('riwayat.unduh', $item) }}">
                                @csrf
                                <x-button size="sm" type="submit">Unduh</x-button>
                            </form>
                            <p class="flex-1 text-xs leading-[1.5] text-brand">
                                Berlaku {{ $item->sisaHari() }} hari lagi
                            </p>
                        </div>
                    @endif

                    @if ($item->status === 'kedaluwarsa')
                        <div class="flex items-center gap-3">
                            <x-button variant="muted" size="sm" disabled>Unduh</x-button>
                            <p class="flex-1 text-xs leading-[1.5] text-muted">Tautan sudah tidak berlaku</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</x-layouts.app>
