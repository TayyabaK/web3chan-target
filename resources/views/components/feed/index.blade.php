@props([
    'feedsNav',
    'posts',
    'canPost' => false,
])

<x-slot name="navTabs">
    <x-feed.tabs :feedsNav="$feedsNav" />
</x-slot>

<div class="lg:m-4">
    <div class="space-y-4">
        @if ($canPost)
            <x-ui.post.create-post />
        @endif

        <div class="pt-4">
            @foreach ($feedsNav as $key => [$feedTitle, $feedDescription])
                <div
                    id="{{ $key }}"
                    @class([
                        'hidden' => ! $this->isCurrentFeed($key),
                    ])
                    role="tabpanel"
                    aria-labelledby="{{ $key }}-item"
                >
                    <div class="mb-4 flex justify-between text-white">
                        <div>{{ $feedDescription }}</div>
                    </div>
                    <div class="space-y-4">
                        <div class="space-y-4">
                            @foreach ($posts as $post)
                                <x-ui.post
                                    :currentTab="$key"
                                    :post="$post"
                                    :isFeed="true"
                                />
                            @endforeach
                        </div>
                        @if ($this->canLoadMore)
                            <div
                                x-intersect="$wire.loadMore()"
                                class="h-20"
                            ></div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@if ($canPost)
    <livewire:components.create-post :current-url="url()->current()" />
    <x-ui.post.create-post-trigger />
@endif

<x-ui.post.delete-post-modal />
