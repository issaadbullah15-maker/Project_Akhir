{{-- Kolom Formulir — label + isian (input / select / textarea / statis) --}}
@props([
    'label',
    'hint' => null,
    'name' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'readonly' => false,
    'required' => false,
])

@php
    $control = 'w-full min-h-[46px] rounded-lg border border-line bg-white px-3 py-[12px] text-sm leading-[1.5] text-ink placeholder:text-muted focus:border-brand focus:outline-none focus:ring-2 focus:ring-brand/20';
    $readonlyControl = 'w-full min-h-[46px] rounded-lg border border-line bg-soft px-3 py-[12px] text-sm leading-[1.5] text-muted';
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col gap-2']) }}>
    <label @if ($name) for="{{ $name }}" @endif class="text-sm font-medium leading-[1.5] text-ink">
        {{ $label }}
    </label>

    @if (isset($slot) && trim($slot) !== '')
        {{ $slot }}
    @elseif ($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="4"
            @if ($required) required @endif
            placeholder="{{ $placeholder }}"
            class="{{ $control }} min-h-[104px] resize-y">{{ old($name, $value) }}</textarea>
    @elseif ($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
            class="{{ $control }} appearance-none bg-[url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%236b7280%22 stroke-width=%222%22><path d=%22M6 9l6 6 6-6%22/></svg>')] bg-[right_12px_center] bg-no-repeat pr-10">
            {{ $slot ?? '' }}
            @foreach ($options ?? [] as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected(old($name, $value) == $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @elseif ($readonly)
        <div class="{{ $readonlyControl }}">{{ $value }}</div>
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @else
        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
            @if ($required) required @endif
            placeholder="{{ $placeholder }}" class="{{ $control }}">
    @endif

    @if ($hint)
        <p class="text-xs leading-[1.5] text-muted">{{ $hint }}</p>
    @endif

    @if ($name && $errors->has($name))
        <p class="text-xs leading-[1.5] text-[#b91c1c]">{{ $errors->first($name) }}</p>
    @endif
</div>
