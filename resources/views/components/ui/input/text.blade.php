@props([
    "type" => "text",
    "name" => null,
    "label" => null,
    "helperText",
    "placeholder",
    "placeholderColor" => "text-neutral",
    "required" => false,
    "backgroundColor" => "bg-secondary",
    "validationFieldName",
    "backgroundColor" => "bg-brand-secondary",
    "readonly" => false,
])

<x-ui.input.wrapper
    label="{{ $label ?? null }}{{ $required ? '*' : null }}"
    helperText="{{ $helperText ?? null }}"
    validationFieldName="{{ $validationFieldName ?? null }}"
>
    <input
        {{ $attributes }}
        type="{{ $type }}"
        name="{{ $name }}"
        @if($readonly)readonly @endif
        @class([
            "no-border-focus btn-retro _pe-4 _sm:ps-11 mt-2 block w-full py-3 text-sm text-white sm:p-4",
            "disabled:pointer-events-none" => $readonly,
            $backgroundColor . " placeholder:" . $placeholderColor,
        ])
        placeholder="{{ $placeholder ?? null }}"
        @if ($required)
            required="true"
        @endif
    />
</x-ui.input.wrapper>
