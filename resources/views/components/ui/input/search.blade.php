@props([
    'type' => 'text',
    'placeholder',
    'placeholderColor' => 'text-neutral',
    'backgroundColor' => 'bg-brand-secondary',
])

<label class="flex-center btn-retro {{ $backgroundColor }} gap-2 px-3">
    <x-icons.magnifier
        class="w-5"
        color
    />
    <input
        {{ $attributes }}
        type="text"
        class="no-border-focus placeholder:{{ $placeholderColor }} w-full rounded-lg bg-transparent text-white placeholder:text-sm"
        placeholder="{{ $placeholder }}"
    />
</label>
