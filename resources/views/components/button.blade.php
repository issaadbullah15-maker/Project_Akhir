{{-- Tombol — varian: primary | secondary | muted | danger --}}
@props(['variant' => 'primary', 'type' => 'button', 'href' => null, 'size' => 'md'])

@php
    $base = 'inline-flex items-center justify-center rounded-lg font-semibold whitespace-nowrap border border-solid transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40 disabled:opacity-60 disabled:cursor-not-allowed';

    $sizes = [
        'md' => 'h-11 px-5 text-sm',
        'sm' => 'h-10 px-3 text-[13px]',
    ];

    $variants = [
        'primary' => 'bg-brand border-brand text-white hover:bg-[#1d4ed8] hover:border-[#1d4ed8]',
        'secondary' => 'bg-white border-line text-ink hover:bg-soft',
        'muted' => 'bg-soft border-line text-muted hover:bg-track',
        'danger' => 'bg-white border-line text-[#b91c1c] hover:bg-[#fef2f2]',
    ];

    $classes = $base . ' ' . $sizes[$size] . ' ' . $variants[$variant];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
