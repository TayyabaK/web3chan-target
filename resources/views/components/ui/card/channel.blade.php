@props([
    'channel' => null,
    'routeName' => null,
    'routeParams' => null,
    'userCount' => rand(1, 100),
    'imageSrc' => 'img/dummy-card.jpg',
])

<a
    href="{{ isset($routeName) ? route($routeName, $routeParams) : null }}"
    wire:navigate
>
    <div class="relative">
        <div class="absolute bottom-2 left-2 bg-brand-primary px-1 text-sm font-bold text-white">
            {{ $channel->name }}
        </div>

        <div>
            <img
                src="{{ asset($channel->getAvatar()) }}"
                alt="Channel Image"
                class="h-48 w-96 object-cover"
            />
        </div>
    </div>

{{--    <div class="mt-4 line-clamp-1 text-sm text-neutral">{{ $channel->name }}</div>--}}
    <div class="mt-2 line-clamp-2 text-sm text-brand-primary">{{ $channel->description }}</div>
    <div class="font-bold text-white">Users: {{ $userCount }}</div>
</a>
