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
    viewBox="0 0 224 224"
>
    <g clip-path="url(#a)">
        <path
            fill="#000"
            d="M203.32 162.36v-20.17H182.7v-82h-19.98V40.03H142.1V20.17h-19.67V0H40.28v20.17h-20.3v20.86H0v81.61h19.98v19.86h19.68v20.17h41.22v20.17h60.91v20.17h20.3v20.48h61.53v-61.13h-20.3Z"
        />
        <path
            class="{{ $fillColor }}"
            d="M162.09 142.5h-19.98v19.86h19.98V142.5ZM182.39 162.67H162.4v19.86h19.99v-19.86ZM121.47 40.65V20.48l-80.87-.3v20.85H20.62v80.99H40.6v20.17h80.89v-20.17h20.29V40.65h-20.31Zm.11 60.51H101.5v21.17H60.27v-21.18H40.6V60.19h19.98V40.34h41.23v19.85l19.77.01v40.96Z"
        />
    </g>
    <defs>
        <clipPath id="a">
            <path
                class="{{ $fillColor }}"
                d="M0 0h223.62v223.49H0z"
            />
        </clipPath>
    </defs>
</svg>
