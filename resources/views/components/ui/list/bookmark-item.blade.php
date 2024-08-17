@props([
    'label',
    'labelColor' => 'text-white',
    'icon' => 'bookmark',
    'iconColor' => 'text-brand-accent',
    'iconClasses' => 'fill-brand-primary/50 stroke-black stroke-2 drop-shadow-2xl transition-colors group-hover:fill-brand-accent',
    'routeName',
    'href' => null,
    'isActive' => false,
])

@isset($href)<a href="{{ $href }}" wire:navigate>@endisset
    <div @class([
        'btn-retro flex gap-2 p-4',
        'bg-brand-secondary' => $isActive,
    ])>
        <div class="flex w-8 justify-center">
            <x-dynamic-component
                @class([
                    $iconSize,
                    $iconClasses,
                    '!fill-brand-accent saturate-150' => $selected,
                ])
                component="icons.{{ $icon }}"
                class="w-6"
            />
        </div>
        <span class="{{ $labelColor }} truncate font-bold">
            {{ $label }}
        </span>
    </div>
@isset($href)</a>@endisset
