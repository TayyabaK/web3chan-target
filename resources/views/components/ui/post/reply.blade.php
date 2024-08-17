@props([
    'reply' => null,
    'post' => null,
    'href' => route('profile',
    $reply->loadMissing('user')->user),
    'userName' => '@NikoDJ',
    'datePosted' => '2 days ago',
    'isUserOnline' => $reply->loadMissing('user')->user->isOnline(),
])

@php
    $reply->loadCount(['likes', 'replies', 'bookmarks']);
@endphp

<div
    class="reply relative p-6 hover:cursor-pointer hover:bg-brand-secondary/40"
    data-id="{{ $reply->id }}"
>
    <span
        @class([
            'reply-border pointer-events-none absolute inset-0 ml-12 block border-l border-brand-primary/60',
            'h-10' => $reply->depth > $post->depth + 1,
        ])
    ></span>
    <a
        href="{{ route('post-thread', [$reply->loadMissing('user', 'posts')->user, $reply]) }}"
        wire:navigate
        class="absolute inset-0 z-20"
    ></a>
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <a
                href="{{ $href }}"
                class="z-50"
                wire:navigate
            >
                <x-ui.avatar :model="$reply->user" />
            </a>

            <div>
                <h4 class="text-sm font-semibold text-white">{{ $reply->user->name ?? $userName }}</h4>
                <span class="text-xs">{{ $reply->created_at->diffForHumans() }}</span>

                <div class="mt-6">{{ $slot }}</div>

                <x-ui.post.content-block :post="$reply" />

                <div class="actions relative z-50 mt-6">
                    <x-ui.post.user-reactions :post="$reply" />
                </div>
            </div>
        </div>
    </div>
</div>
