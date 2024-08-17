@props([
    'person' => null,
    'routeName' => null,
    'routeParams' => null,
    'followingSystem' => false,
])

<a
    href="{{ isset($routeName) ? route($routeName, $routeParams) : null }}"
    wire:navigate
>
    <div class="relative">
        {{-- <div class="absolute bottom-2 left-2 bg-brand-primary px-1 text-sm font-bold text-white">{{ $channelName }}</div> --}}

        <div class="relative">
            @if ($person->isOnline())
                <span
                    class="absolute bottom-0 right-0 z-10 -mb-0.5 -mr-0.5 size-[11px] border-2 border-brand-darkest bg-accent-green"
                ></span>
            @endif
            <img
                src="{{ asset($person->getAvatar()) }}"
                alt="Channel Image"
                @class([
                    'h-48 w-96 object-cover',
                    '!h-28' => $followingSystem,
                ])
            />
        </div>
    </div>

    @unless ($followingSystem)
        <div class="mt-4 text-sm text-neutral">{{ $person->username }}</div>
    @endunless
</a>
