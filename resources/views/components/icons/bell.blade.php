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
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 130 110"
>
    <path
        d="M120 90V80h10V70h-10V60h-10V30h-10V20H90V10H80V0H40v10H30v10H20v30H10v20H0v10h20v10h20v10h20v10h20v-10h10V90h30Z"
        style="stroke-width: 0; fill: #000"
    />
    <path
        d="M70 10v10h10v10h10v30h10v10H20V60h10V30h10V20h10V10h20ZM50 90V80h20v10H50Z"
        style="stroke-width: 0"
        class="{{ $fillColor }}"
    />
</svg>
