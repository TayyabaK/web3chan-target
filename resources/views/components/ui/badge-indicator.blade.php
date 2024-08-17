@props([
    'text' => '9',
])

<div
    {{ $attributes->merge(['class' => 'bg-brand-accent w-4 h-4 text-xs font-semibold text-white grid justify-center align-center']) }}
>
    {{ $text }}
</div>
