@props([
    'state' => 'hover',
    'size' => 'w-6',
    'fillColor' => 'fill-neutral',
])

<svg
    {{ $attributes->merge(['class' => "flex-shrink-0 {$size}"]) }}
    viewBox="0 0 264 203"
    fill="none"
    xmlns="http://www.w3.org/2000/svg"
>
    <g clip-path="url(#clip0_81_300)">
        <path
            d="M243.3 21.3V0H20V80.7H0V121.3H19.9V182.2H40.2V202.5H263.6V21.3H243.3Z"
            fill="#08021C"
        />
        <path
            d="M80.5999 81.3H20.3999V121.8H80.5999V81.3Z"
            class="{{ $fillColor }}"
        />
        <path
            d="M40.3 20.3V61.2H80.6V81.3H101.2V122H80.9001V141.9H40.3V161.9H223V20.3H40.3Z"
            class="{{ $fillColor }}"
        />
    </g>
    <defs>
        <clipPath id="clip0_81_300">
            <rect
                width="263.6"
                height="202.5"
                fill="white"
            />
        </clipPath>
    </defs>
</svg>
