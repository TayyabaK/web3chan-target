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
    {{-- class="{{ $fillColor }} w-6 bg-pink-200 text-red-500" --}}
>
    <polygon
        class="{{ $fillColor }}"
        points="23 5 23 6 22 6 22 7 21 7 21 8 20 8 20 9 19 9 19 10 18 10 18 11 17 11 17 12 16 12 16 13 15 13 15 14 14 14 14 15 13 15 13 16 12 16 12 17 11 17 11 18 10 18 10 19 8 19 8 18 7 18 7 17 6 17 6 16 5 16 5 15 4 15 4 14 3 14 3 13 2 13 2 12 1 12 1 11 2 11 2 10 3 10 3 9 4 9 4 10 5 10 5 11 6 11 6 12 7 12 7 13 8 13 8 14 10 14 10 13 11 13 11 12 12 12 12 11 13 11 13 10 14 10 14 9 15 9 15 8 16 8 16 7 17 7 17 6 18 6 18 5 19 5 19 4 20 4 20 3 21 3 21 4 22 4 22 5 23 5"
    />
</svg>
