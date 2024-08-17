@props([
    'label' => 'Label',
    'count' => 0,
    'icon' => 'heart',
    'iconSize' => 'w-7',
    'iconClasses' => 'fill-brand-primary/50 stroke-black stroke-1 transition-colors group-hover:fill-brand-accent',
    'selected' => false,
])

<button
    {{ $attributes->merge(['class' => 'flex items-center gap-2 group hover:animate-pulse']) }}
>
    <x-dynamic-component
        component="icons.{{ $icon }}"
        @class([
            $iconSize,
            $iconClasses,
            '!fill-brand-accent saturate-150' => $selected,
        ])
    />
    <div class="text-left">
        <span
            class="text-sm leading-4 text-white/40 group-hover:text-white"
            :class="{ '!text-white': '{{ $selected }} '}"
        >
            {{ $count }}
        </span>
        <span
            @class([
                'hidden text-sm font-semibold leading-tight text-brand-primary transition-colors group-hover:text-brand-accent md:block',
                '!text-white/70' => $selected,
            ])
        >
            {{ $label }}
        </span>
    </div>
</button>
