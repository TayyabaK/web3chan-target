@props([
    'model',
    'avatarImageSrc' => 'img/dummy-avatar-48x48.jpg',
    'size' => 'size-12',
    'href' => null,
    'mr' => 'mr-4',
])

<div class="relative z-[5] {{ $mr }} flex-shrink-0 aspect-square {{ $size }}">
    @if ($model?->isOnline())
        <span
            class="absolute bottom-0 right-0 z-10 -mb-0.5 -mr-0.5 size-[11px] border-2 border-brand-darkest bg-accent-green"
        ></span>
    @endif

    <img
        src="{{ asset($model->getAvatar()) }}"
        class="{{ $size }}"
        alt="User Avatar"
    />
</div>
