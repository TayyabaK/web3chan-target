@props([
    'heading',
    'showMoreLinkText' => 'Show More',
    'hasBackground' => false,
    'hasPadding' => true,
    'isCollapsible' => false,
    'spacingY' => '2',
])

<div
    {{-- {{ $attributes->merge(['class']) }} --}}
    @class([
        'btn-retro block',
        'p-6' => $hasPadding,
        'bg-brand-secondary' => $hasBackground,
    ])
>
    @isset($heading)
        <div class="flex items-center justify-between">
            <span class="mb-2 block font-bold text-white">{{ $heading }}</span>

            @if ($isCollapsible)
                <x-icons.caret-down />
            @endif
        </div>
    @endisset

    <div @class([
        "space-y-{$spacingY}" => isset($spacingY),
    ])>
        {{ $slot }}
    </div>

    @isset($showMoreLink)
        <a
            href="{{ $showMoreLink }}"
            class="mt-4 inline-block text-xs text-brand-accent hover:text-white"
            wire:navigate
        >
            {{ $showMoreLinkText }}
        </a>
    @endisset
</div>
