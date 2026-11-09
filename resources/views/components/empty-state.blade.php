@props(['message'])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-line bg-white p-8 text-center text-sm leading-[1.5] text-muted']) }}>
    {{ $message }}
</div>
