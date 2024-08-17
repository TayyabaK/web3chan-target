@props([
    'asButton' => false,
    'label',
    'key' => null,
    'isActive' => false,
    'hasIndicator' => false,
    'routeName' => null,
    'isActive' => isset($routeName)?request()->routeIs($routeName):false,
    'defaultClasses' => 'relative block w-20 border-b-2 border-transparent p-2 text-sm font-bold hover:text-white lg:w-24 lg:text-base',
    'activeClasses' => 'active border-b-brand-accent text-white',
    'indicatorClasses' => 'absolute right-0 top-2 h-1.5 w-1.5 rounded-full bg-accent-magenta',
])

@if ($asButton)
    <button
        type="button"
        wire:click="setCurrentFeed('{{ $key }}')"
        @class([
            $defaultClasses,
            $activeClasses => $isActive,
        ])
        id="{{ $key }}-item"
        data-hs-tab="#{{ $key }}"
        aria-controls="{{ $key }}"
        role="tab"
    >
        @if ($hasIndicator)
            <div class="{{$indicatorClasses}}"></div>
        @endif

        {{ $label }}
    </button>
@else
    <a
        href="{{ isset($routeName) ? route($routeName) : null }}"
        wire:navigate
        @class([
            $defaultClasses,
            $activeClasses => $isActive,
        ])
    >
        @if ($hasIndicator)
            <div class="{{$indicatorClasses}}"></div>
        @endif

        @isset($label)
            {{ $label }}
        @endisset

        {{ $slot }}
    </a>
@endif
