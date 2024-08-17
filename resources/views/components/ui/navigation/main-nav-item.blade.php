@props([
    "label",
    "icon" => "user",
    "itemCount",
    "routeName",
    "routeParams" => [],
    "isActive" => isset($routeName)?request()->routeIs($routeName):false,
    "isDisabled" => false,
    "wireNavigate" => true,
    "iconSize" => "w-6",
])

<a
    {{ $attributes }}
    href="{{ isset($routeName) && ! $isDisabled ? route($routeName, $routeParams) : '#' }}"
    @if ($wireNavigate)
        wire:navigate
    @endif
    @class([
        "btn-retro group relative block w-auto px-3 py-3 text-center text-neutral hover:bg-brand-secondary",
        "group-active bg-brand-primary" => $isActive,
        "bg-brand-darkest" => ! $isActive,
        "disabled" => $isDisabled,
    ])
>
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <div class="flex w-8 justify-center">
                <x-dynamic-component
                    component="icons.{{ $icon }}"
                    @class([
                        $iconSize,
                        "group-hover:fill-white fill-neutral stroke-black stroke-2",
                        "!fill-brand-accent" => $isActive,
                    ])
                />
            </div>
            <span
                @class([
                    "truncate font-bold",
                    "text-white group-hover:text-white" => $isActive,
                    "text-neutral group-hover:text-white" => ! $isActive,
                ])
            >
                {{ $label }}
            </span>
        </div>

        @isset($itemCount)
            <span class="block bg-brand-accent px-1.5 py-1 text-center text-xs font-bold text-white">
                {{ $itemCount }}
            </span>
        @endisset
    </div>
</a>
