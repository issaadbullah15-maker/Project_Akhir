{{-- Kartu — panel putih dengan border tipis --}}
@props(['padded' => true])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-line bg-white ' . ($padded ? 'p-5' : '')]) }}>
    {{ $slot }}
</div>
