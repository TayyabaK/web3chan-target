@props([
    'fill' => null,
])

@php
    $fillColor = match ($fill) {
        'accent' => 'fill-brand-primary',
        default => 'fill-white',
    };
@endphp

<svg
    {{ $attributes->merge(['class' => 'flex-shrink-0']) }}
    width="20"
    height="4"
    xmlns="http://www.w3.org/2000/svg"
>
    <path
        d="M2 4a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM10 4a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM20 2a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"
        class="{{ $fillColor }}"
    />
</svg>
