@props([
    'state' => 'hover',
    'size' => 'w-6',
    'fillColor' => 'fill-neutral',
])

<svg
    {{ $attributes->merge(['class' => "flex-shrink-0 {$size}"]) }}
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 204 204"
>
    <g clip-path="url(#a)">
        <path
            fill="#08021C"
            d="M182.76 20.78V0H0v183.31h20.3v20.31h182.76V20.78h-20.3Z"
        />
        <path
            class="{{ $fillColor }}"
            d="M20.31 20.31V163h142.14V20.31H20.31Zm121.22 82.39h-40.3v40.31H80.92V102.7H40.61V82.39h40.3v-40.3h20.31v40.3h40.31v20.31Z"
        />
    </g>
    <defs>
        <clipPath id="a">
            <path
                class="{{ $fillColor }}"
                d="M0 0h203.06v203.62H0z"
            />
        </clipPath>
    </defs>
</svg>
