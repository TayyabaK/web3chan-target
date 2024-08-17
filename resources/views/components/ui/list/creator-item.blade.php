@props([
    'model' => null,
    'name' => 'user',
    'avatarImageSrc' => 'img/dummy-avatar-25x25.jpg',
    'href' => '#',
])

<a
    href="{{ $href }}"
    wire:navigate
    @class([
        'flex items-center gap-3 pl-4 font-bold text-white',
    ])
>
    <div class="size-6">
        <x-ui.avatar :model="$model" size="size-6" mr="mr-0" />
    </div>
    <span class="text-white">{{ $name }}</span>
</a>
