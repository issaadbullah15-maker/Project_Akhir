@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}>
    <div class="flex items-center gap-4">
        <h1 class="flex-1 text-[28px] leading-[1.5] text-ink">{{ $title }}</h1>
        {{ $actions ?? '' }}
    </div>
    @if ($subtitle)
        <p class="text-sm leading-[1.5] text-muted">{{ $subtitle }}</p>
    @endif
</div>
