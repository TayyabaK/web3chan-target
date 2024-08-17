@props([
    'post' => null,
    'href' => route('profile',
    $post->user),
    'userName' => $post->user->name??'@NikoDJ',
    'avatarImageSrc' => $post->getUserImage(),
    'isUserOnline' => $post->user->isOnline(),
    'datePosted' => $post->created_at->diffForHumans(),
    'showFollowButton' => true,
    'showMoreButton' => false,
    'isFeed' => false,
    'currentTab' => null,
])

@php
    $componentKey = 'post-' . $post->id . '-' . $currentTab;
@endphp

<div
    wire:key="{{ $componentKey }}"
    @class([
        'btn-retro cursor-pointer bg-brand-secondary p-[0.15rem] transition-colors duration-700 hover:bg-brand-primary/40' => $isFeed,
    ])
>
    <div class="relative mx-[0.225rem] bg-brand-darkest p-[0.775rem] text-xs text-white">
        <a
            href="{{ route('post-thread', [$post->user, $post]) }}"
            wire:navigate
            class="absolute inset-0 z-20"
        ></a>
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div class="flex w-full">
                    <a
                        href="{{ $href }}"
                        class="z-50"
                        wire:navigate
                    >
                        <x-ui.avatar :model="$post->user" />
                    </a>

                    <div class="flex w-full items-center justify-between">
                        <div class="flex flex-col">
                            <a
                                href="{{ route('profile', $post->user) }}"
                                class="z-50 text-sm font-semibold text-white"
                                wire:navigate
                            >
                                {{ $userName }}
                            </a>
                            <span class="text-xs">{{ $datePosted }}</span>
                        </div>

                        <div class="relative z-[100] flex items-center gap-4">
                            @if ($showFollowButton)
                                @cannot('update', $post->user)
                                    <x-ui.post.follow :user="$post->user" />
                                @endcan
                            @endif

                            @can('update', $post)
                                @if ($post->is_pinned && auth()->check())
                                    <div class="flex items-center gap-x-2">
                                        <x-icons.pin size="w-2.5" />
                                        <span class="text-sm font-semibold text-brand-primary">Pinned</span>
                                    </div>
                                @endif

                                @if ($post->is_highlighted && auth()->check())
                                    <div class="flex items-center gap-x-2">
                                        <x-icons.pin size="w-2.5" />
                                        <span class="text-sm font-semibold text-brand-primary">Highlighted</span>
                                    </div>
                                @endif

                                @auth
                                    <x-ui.post.inline-actions
                                        :post="$post"
                                        :key="$componentKey"
                                    />
                                @endauth
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{ $slot }}

        <x-ui.post.content-block :post="$post" />
    </div>

    <div class="p-4">
        <x-ui.post.user-reactions :post="$post" />
    </div>
</div>
