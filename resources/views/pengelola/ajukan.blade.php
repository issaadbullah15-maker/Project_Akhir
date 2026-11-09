<x-layouts.app title="Ajukan buku">
    <x-page-heading title="Ajukan buku" subtitle="Lengkapi kebutuhan buku untuk taman baca Anda." />

    <form method="POST" action="{{ route('pengajuan.store') }}" class="flex flex-col gap-5 rounded-lg border border-line bg-white p-6">
        @csrf

        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium leading-[1.5] text-ink">Taman Baca</label>
            <div class="min-h-[46px] rounded-lg border border-line bg-soft px-3 py-3 text-sm text-muted">
                {{ auth()->user()->tamanBaca?->nama ?? 'Belum terhubung ke taman baca' }}
            </div>
            @if (auth()->user()->tamanBaca)
                <p class="text-xs leading-[1.5] text-muted">{{ auth()->user()->tamanBaca->lokasi() }}</p>
            @endif
        </div>

        <div class="flex flex-col gap-2">
            <label class="text-sm font-medium leading-[1.5] text-ink">Pengaju</label>
            <div class="min-h-[46px] rounded-lg border border-line bg-soft px-3 py-3 text-sm text-muted">
                {{ auth()->user()->name }}
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <label for="buku_id" class="text-sm font-medium leading-[1.5] text-ink">Buku yang dibutuhkan</label>
            <select id="buku_id" name="buku_id" required
                class="min-h-[46px] w-full rounded-lg border border-line bg-white px-3 py-3 text-sm text-ink focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20">
                @foreach ($buku as $item)
                    <option value="{{ $item->id }}" data-detail="{{ $item->labelLengkap() }}"
                        @selected($dipilih && $dipilih->id === $item->id)>{{ $item->judul }}</option>
                @endforeach
            </select>

            <div class="rounded-lg border border-line bg-white p-3">
                <p id="buku-terpilih" class="text-sm font-semibold leading-[1.5] text-ink">{{ $dipilih?->judul }}</p>
                <p id="buku-detail" class="text-xs leading-[1.5] text-muted">{{ $dipilih?->labelLengkap() }}</p>
            </div>

            @if ($aktif->isNotEmpty())
                <div class="rounded-lg border-l-[3px] border-brand bg-brand-soft p-4 text-sm leading-[1.5] text-brand">
                    Taman baca Anda sudah memiliki {{ $aktif->count() }} permintaan aktif. Pilih buku lain jika permintaan masih aktif.
                </div>
            @endif
        </div>

        <x-field label="Catatan keperluan (opsional)" name="catatan" type="textarea"
            placeholder="Untuk sesi membaca bersama anak kelas 3–5 di TBM."
            hint="Maksimal 255 karakter." />

        <div class="flex items-center justify-end">
            <x-button type="submit" variant="muted">Kirim</x-button>
        </div>
    </form>

    <p class="text-xs leading-[1.5] text-muted">
        Permintaan ditinjau oleh admin. Pilih buku lain jika permintaan masih aktif.
    </p>
</x-layouts.app>
