<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Lentera Baca' }} · Lentera Baca</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-surface">
    @php
        $menu = auth()->user()->isAdmin()
            ? [
                ['label' => 'Permintaan', 'route' => 'admin.permintaan.index', 'active' => request()->routeIs('admin.permintaan.*')],
                ['label' => 'Buku', 'route' => 'admin.buku.index', 'active' => request()->routeIs('admin.buku.*')],
                ['label' => 'Kategori', 'route' => 'admin.kategori.index', 'active' => request()->routeIs('admin.kategori.*')],
                ['label' => 'Taman Baca', 'route' => 'admin.taman-baca.index', 'active' => request()->routeIs('admin.taman-baca.*')],
                ['label' => 'Penyaluran', 'route' => 'admin.penyaluran.index', 'active' => request()->routeIs('admin.penyaluran.*')],
            ]
            : [
                ['label' => 'Katalog', 'route' => 'katalog.index', 'active' => request()->routeIs('katalog.*')],
                ['label' => 'Ajukan', 'route' => 'pengajuan.create', 'active' => request()->routeIs('pengajuan.*')],
                ['label' => 'Riwayat Saya', 'route' => 'riwayat.index', 'active' => request()->routeIs('riwayat.*')],
            ];
    @endphp

    <header class="border-b border-line bg-white">
        <div class="mx-auto flex h-20 w-full max-w-[720px] items-center justify-between px-4 sm:px-0">
            <a href="{{ auth()->user()->isAdmin() ? route('admin.permintaan.index') : route('katalog.index') }}"
               class="text-[22px] font-bold text-ink">Lentera Baca</a>

            <div class="flex items-center gap-5">
                <div class="text-right leading-[1.5]">
                    <p class="text-[13px] font-medium text-ink">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-muted">{{ auth()->user()->labelRole() }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-button variant="secondary" size="sm" type="submit">Keluar</x-button>
                </form>
            </div>
        </div>

        <nav class="mx-auto flex h-[52px] w-full max-w-[720px] items-center gap-2 overflow-x-auto px-4 sm:px-0">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="shrink-0 rounded-lg px-[14px] py-[10px] text-sm whitespace-nowrap {{ $item['active'] ? 'bg-brand-soft font-semibold text-brand' : 'bg-white font-normal text-muted hover:bg-soft' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </header>

    <main class="flex flex-col items-center px-4 pt-9 sm:px-0">
        <div class="w-full max-w-[720px] flex flex-col gap-6">
            @if (session('status'))
                <div class="rounded-lg border-l-[3px] border-brand bg-brand-soft p-4 text-sm leading-[1.5] text-brand">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any() && ! $errors->has('alasan_penolakan') && ! $errors->has('unduh') && ! $errors->has('hapus'))
                <div class="rounded-lg border-l-[3px] border-[#b91c1c] bg-[#fef2f2] p-4 text-sm leading-[1.5] text-[#b91c1c]">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($errors->has('hapus'))
                <div class="rounded-lg border-l-[3px] border-[#b91c1c] bg-[#fef2f2] p-4 text-sm leading-[1.5] text-[#b91c1c]">
                    {{ $errors->first('hapus') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <div class="h-16"></div>
</body>
</html>
