@props([
    'isHighlighted' => false,
    'hasCaret' => false,
])

<li>
    <span class="{{ $isHighlighted ? 'text-white' : null }}">
        {{ $slot }}
    </span>

    @if ($hasCaret)
        <span class="ml-2">></span>
    @endif
</li>
