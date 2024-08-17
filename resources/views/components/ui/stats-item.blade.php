@props([
    'label' => 'DEFAULT LABEL',
    'itemCount' => '0',
])
<div class="relative block w-20 border-b-2 border-transparent p-2 lg:flex lg:w-auto lg:p-0">
    <span class="block font-bold text-white lg:mr-2">{{ $itemCount }}</span>

    <span class="block text-sm text-brand-primary hover:underline lg:mr-6 lg:flex lg:text-base lg:text-neutral">
        {{ $label }}
    </span>
</div>
