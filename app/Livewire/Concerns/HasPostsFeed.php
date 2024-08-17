<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Models\Post;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;

trait HasPostsFeed
{
    public ?Post $pinnedPost = null;

    public ?Post $highlightedPost = null;

    #[Locked]
    public int $totalPosts = 0;

    #[Locked]
    public int $limit = 4;

    /**
     * @var Collection<int, Post>
     */
    public Collection $posts;

    public function hydrate(): void
    {
        $this->init();
    }

    public function loadMore(): void
    {
        $this->limit += 4;

        $this->init();
    }

    #[Computed]
    public function canLoadMore(): bool
    {
        return $this->limit < $this->totalPosts;
    }

    public function init(): void
    {
        $this->totalPosts = $this->loadFeed()
            ->queryBuilder(null, true)
            ->count();

        $this->posts = $this->loadFeed()
            ->queryBuilder()
            ->limit($this->limit)
            ->get();

        $this->pinnedPost = auth()->user()->posts()
            ->withCount(['replies', 'likes', 'bookmarks'])
            ->firstWhere('is_pinned', true);

        if ($this->pinnedPost && $this->loadFeed()::$allowPinned) {
            $this->posts->prepend($this->pinnedPost);
        }

        $this->refreshUserReactions();
    }
}
