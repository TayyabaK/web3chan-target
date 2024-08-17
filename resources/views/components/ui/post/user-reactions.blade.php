@props([
    'post' => null,
    'likesCount' => $post->likes_count ?? 0,
    'repliesCount' => $post->replies_count,
    'bookmarksCount' => $post->bookmarks_count,
    'sharesCount' => '52',
    'tipsCount' => $post->user->total_tips ?? 0,
])

<div class="flex justify-center gap-4 !text-xs font-semibold text-white md:gap-10">
    <x-ui.post.action-link
        class="group"
        label="Like"
        count="{{ $likesCount }}"
        icon="heart"
        iconSize="w-7"
        :selected="$this->hasLikedPost($post->id)"
        wire:click="toggleLike('{{ $post->id }}')"
    />

    <x-ui.post.action-link
        class="group"
        label="Reply"
        count="{{ $repliesCount }}"
        icon="reply"
        iconSize="w-6"
        @click="$dispatch('open-modal', { id: 'post-modal', parentId: '{{ $post->id }}' })"
    />

    <x-ui.post.action-link
        label="Bookmark"
        count="{{ $bookmarksCount }}"
        icon="bookmark"
        iconSize="w-5"
        :selected="$this->hasBookmarkedPost($post->id)"
        wire:click="toggleBookmark('{{ $post->id }}')"
    />
    <x-ui.post.action-link
        label="Tip"
        count="{{ $tipsCount }}"
        icon="tip"
        iconSize="w-7"
        :selected="$this->hasTippedUser($post->user_id)"
        @click="$dispatch('open-modal', { id: 'tip-modal', userId: '{{ $post->user_id }}' })"
    />
    <x-ui.post.action-link
        :count="$this->sharesCount[$post->id] ?? 0"
        label="Share"
        icon="share"
        iconSize="w-7"
        @click="navigator.clipboard.writeText('{{ route('post-thread', ['user' => $post->user, 'post' => $post]) }}');"
        wire:click="sharePost('{{ $post->id }}')"
    />
</div>
