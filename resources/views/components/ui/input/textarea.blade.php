@props([
    "name" => null,
    "label" => null,
    "helperText",
    "placeholder",
    "placeholderColor" => "text-neutral",
    "rows" => "5",
    "required" => false,
    "backgroundColor" => "bg-brand-secondary",
])

<x-ui.input.wrapper
    label="{{ $label ?? null }}{{ $required ? '*' : null }}"
    helperText="{{ $helperText ?? null }}"
>
    <textarea
        {{ $attributes }}
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="{{ $backgroundColor }} btn-retro placeholder:{{ $placeholderColor }} no-border-focus _pe-4 _sm:pe-11 mt-2 block w-full py-3 text-sm text-white sm:p-4"
        placeholder="{{ $placeholder ?? null }}"
        @if ($required)
            required
        @endif
    ></textarea>
</x-ui.input.wrapper>
