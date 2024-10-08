@props([
    'fill' => null,
    'size' => 'w-5',
])

@php
    $fillColor = match ($fill) {
        'accent' => 'fill-brand-primary',
        'success' => 'fill-green-600',
        default => 'fill-white',
    };
@endphp

<svg
    {{ $attributes->merge(['class' => "flex-shrink-0 {$size}"]) }}
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 24 24"
>
    <polygon
        class="{{ $fillColor }}"
        points="19 9 19 10 18 10 18 11 17 11 17 12 16 12 16 13 15 13 15 14 14 14 14 15 13 15 13 16 12 16 12 17 10 17 10 16 9 16 9 15 8 15 8 14 7 14 7 13 6 13 6 12 7 12 7 11 8 11 8 12 9 12 9 13 10 13 10 14 12 14 12 13 13 13 13 12 14 12 14 11 15 11 15 10 16 10 16 9 17 9 17 8 18 8 18 9 19 9"
    />
    <path
        class="{{ $fillColor }}"
        d="m22,9v-2h-1v-2h-1v-1h-1v-1h-2v-1h-2v-1h-6v1h-2v1h-2v1h-1v1h-1v2h-1v2h-1v6h1v2h1v2h1v1h1v1h2v1h2v1h6v-1h2v-1h2v-1h1v-1h1v-2h1v-2h1v-6h-1Zm-2,6v2h-1v2h-2v1h-2v1h-6v-1h-2v-1h-2v-2h-1v-2h-1v-6h1v-2h1v-2h2v-1h2v-1h6v1h2v1h2v2h1v2h1v6h-1Z"
    />
</svg>
