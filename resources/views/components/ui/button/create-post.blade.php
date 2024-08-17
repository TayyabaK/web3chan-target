@props([
    'label',
    'icon',
])
<button class="flex items-center gap-2 p-3 text-xs">
    <x-dynamic-component
        component="icons.{{ $icon }}"
        class="w-6"
        color
    />

    <span class="hidden hover:text-white lg:inline">{{ $label }}</span>
</button>
