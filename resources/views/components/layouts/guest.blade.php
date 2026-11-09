<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Masuk' }} · Lentera Baca</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col items-center justify-center gap-7 bg-surface px-4 py-10">
    <div class="flex w-full max-w-[420px] flex-col items-center gap-2 text-center">
        <h1 class="text-[28px] font-bold text-ink">Lentera Baca</h1>
        <p class="text-sm leading-[1.5] text-muted">Buku digital untuk taman baca dan sekolah di wilayah 3T.</p>
    </div>

    {{ $slot }}

    <p class="w-full max-w-[420px] text-center text-xs leading-[1.5] text-muted">
        Mendukung SDG 4 · Pendidikan berkualitas dan merata.
    </p>
</body>
</html>
