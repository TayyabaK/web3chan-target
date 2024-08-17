@props([
    'isActive' => false,
    'label' => null,
    'href' => null,
    'type' => 'button',
    'color' => 'primary',
    'size' => 'md',
    'font' => 'bold',
    'fullWidth' => false,
])

{{--
    fullWidth:
    Whenever you need to control the width of a button,
    wrap it in a span with the width class (w-32 etc) and set fullWidth to true
--}}

@php
    $tag = filled($href) ? 'a' : 'button';

    $buttonClasses = \Illuminate\Support\Arr::toCssClasses([
        'text-center font-bold',
        'block w-full' => $fullWidth,
        match ($color) {
            'primary' => 'bg-brand-primary text-white hover:bg-brand-accent',
            'secondary' => 'bg-brand-secondary text-white hover:bg-brand-primary',
            'accent' => 'bg-brand-accent text-white hover:bg-brand-primary',
            'white' => 'bg-white text-black hover:bg-brand-primary hover:text-white',
            'gray' => 'bg-gray-600 text-white hover:bg-gray-700',
            'transparent' => 'hover:bg-brand-secondary',
            default => $color,
        },
        match ($size) {
            'xs' => 'btn-retro-sm gap-1 px-3 py-1.5 text-xs',
            'sm' => 'btn-retro gap-1 px-4 py-1.5 text-sm',
            'md' => 'btn-retro gap-1.5 px-6 py-2 text-base',
            'lg' => 'btn-retro gap-1.5 px-8 py-3 text-lg',
            'xl' => 'btn-retro-lg gap-1.5 px-10 py-4 text-xl',
            default => $size,
        },
        match ($font) {
            'bold' => 'font-bold',
            'normal' => 'font-normal',
            default => $font,
        },
    ]);
@endphp

<{{ $tag }}
    {{
        $attributes
            ->merge([
                'type' => $tag === 'button' ? $type : null,
                'href' => $tag === 'a' ? $href : null,
            ])
            ->class([$buttonClasses])
    }}
>
    {{ $label }}
    {{ $slot }}
</{{ $tag }}>
