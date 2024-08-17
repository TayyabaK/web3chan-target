@props([
    'label' => 'Label',
    'count' => 0,
    'icon' => 'bell',
    'iconSize' => 'w-7',
    'selected' => false,
])

<button
    {{ $attributes }}
    class="flex w-full items-center gap-x-3.5 rounded px-3 py-2 text-sm text-neutral hover:bg-brand-darkest/50 focus:outline-none"
    type="button"
>
    <div class="flex w-8 justify-center">
        <x-dynamic-component
            component="icons.{{ $icon }}"
            class="w-4"
        />
    </div>
    {{ $label }}
</button>
