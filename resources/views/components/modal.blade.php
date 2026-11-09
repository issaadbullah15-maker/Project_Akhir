@props(['id', 'title', 'description' => null])

<div id="{{ $id }}" data-modal hidden class="fixed inset-0 z-50 flex items-center justify-center bg-[#111827]/40 p-4">
    <div class="w-full max-w-[480px] rounded-lg border border-line bg-white p-6">
        <h2 class="text-[20px] font-semibold leading-[1.5] text-ink">{{ $title }}</h2>
        @if ($description)
            <p class="mt-2 text-sm leading-[1.5] text-muted">{{ $description }}</p>
        @endif
        <div class="mt-5">{{ $slot }}</div>
    </div>
</div>
