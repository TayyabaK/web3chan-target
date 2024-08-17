@props([
    'fill' => 'accent',
])

@php
    $fillColor = match ($fill) {
        'accent' => 'fill-brand-primary',
        default => 'fill-white',
    };
@endphp

<svg
    {{ $attributes->merge(['class' => 'flex-shrink-0']) }}
    viewBox="0 0 56 80"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
>
    <g clip-path="url(#clip0_82_334)">
        <path
            d="M56 71.349V62.1117H51.2663V57.7619H46.614V53.2955H38.0881V48.8389H32.7256V44.4405H28.0342V31.1773H32.7191V26.7336H46.5814V22.2769H51.2728V17.8105H55.7426V7.89312H51.2728V4.39838H46.614V0H32.5855V4.39838H27.9332L27.9919 22.264H23.3005V26.6591L4.65228 26.6235V31.0899H0V44.4988H4.65228V48.8972H9.37623L9.48374 53.2923H27.9332V71.1579H32.5855V75.5563H37.2378V80H46.5782V75.6923H51.2695V75.6534L51.263 75.647V71.3393H55.9967V71.349H56Z"
            fill="#08021C"
        />
        <path
            d="M46.5814 4.57327H32.7256V17.9044H46.5814V4.57327Z"
            class="{{ $fillColor }}"
        />
        <path
            d="M18.6482 31.0121H4.79236V44.3433H18.6482V31.0121Z"
            class="{{ $fillColor }}"
        />
        <path
            d="M46.5814 57.6713H32.7256V71.0024H46.5814V57.6713Z"
            class="{{ $fillColor }}"
        />
    </g>
    <defs>
        <clipPath id="clip0_82_334">
            <rect
                width="56"
                height="80"
                class="{{ $fillColor }}"
            />
        </clipPath>
    </defs>
</svg>
