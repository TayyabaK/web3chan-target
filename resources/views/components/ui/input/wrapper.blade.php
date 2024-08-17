@props([
    'label' => 'Label goes here',
    'helperText',
    'validationFieldName',
])

<div>
    <label class="flex items-center justify-between text-sm">
        {{ $label }}

        @isset($hint)
            {{ $hint }}
        @endif
    </label>

    {{ $slot }}

    @isset($helperText)
        <div class="mt-2 text-right text-xs font-bold">{{ $helperText }}</div>
    @endisset

    @isset($validationFieldName)
        <x-ui.input.error
            :messages="$errors->get($validationFieldName)"
            class="mt-2"
        />
    @endisset
</div>
