@props([
    'avatarImageSrc' => 'img/dummy-avatar-25x25.jpg',
    'username' => 'niko',
])

<div class="flex items-start gap-4">
    <a
        href="{{ route('profile', $username) }}"
        class="flex-shrink-0"
        wire:navigate
    >
        <img
            src="{{ asset($avatarImageSrc) }}"
            class="size-10"
        />
    </a>
    <div class="flex">
        <div class="max-w-xs bg-brand-primary p-4 text-white lg:max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
