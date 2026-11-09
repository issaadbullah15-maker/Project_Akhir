{{-- Chip Status — tone: blue | gray --}}
@props(['tone' => 'blue'])

@php
    $toneClass = $tone === 'blue' ? 'bg-brand-soft text-brand' : 'bg-soft text-muted';
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-lg px-2 py-1 text-xs font-medium leading-[1.5] whitespace-nowrap {$toneClass}"]) }}>
    {{ $slot }}
</span>
