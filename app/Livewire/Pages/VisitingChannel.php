<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Feeds;
use App\Livewire\Concerns\CanEditChannel;
use App\Livewire\Concerns\HasPostsFeed;
use App\Livewire\Concerns\InteractsWithFeeds;
use App\Livewire\Concerns\InteractsWithJoinChannel;
use App\Models\Channel;
use App\Support\PagePosts;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class VisitingChannel extends PagePosts
{
    use CanEditChannel;
    use HasPostsFeed;
    use InteractsWithFeeds;
    use InteractsWithJoinChannel;

    public Channel $channel;

    public function mount(): void
    {
        $this->setCurrentFeed(
            feed: 'posts-feed',
        );
    }

    public function init(): void
    {
        $this->totalPosts = $this->loadFeed()
            ->queryBuilder(null, true)
            ->count();

        $this->posts = $this->loadFeed()
            ->queryBuilder(model: $this->channel)
            ->limit($this->limit)
            ->get();

        $this->highlightedPost = $this->channel->posts()
            ->withCount(['replies', 'likes', 'bookmarks'])
            ->firstWhere('is_pinned', true);

        if ($this->highlightedPost && $this->loadFeed()::$allowHighlighted) {
            $this->posts->prepend($this->highlightedPost);
        }

        $this->refreshUserReactions();
    }

    #[On('update-avatar')]
    public function updateAvatar(?string $avatar): void
    {
        $this->channel->update([
            'image' => $avatar,
        ]);

        // @todo set current feed to 1st item as default to avoid mount call
        $this->mount();
    }

    #[On('update-banner')]
    public function updateBanner(?string $banner): void
    {
        $this->channel->update([
            'banner' => $banner,
        ]);
    }

    public function render(): View
    {
        $this->channel->loadCount(['members', 'posts']);

        return view('livewire.pages.visiting-channel');
    }

    /**
     * @return array<string, string>
     */
    protected function feeds(): array
    {
        return [
            'posts-feed' => Feeds\ChannelPosts::class,
            'replies-feed' => Feeds\Replies::class,
            'highlights-feed' => Feeds\Highlights::class,
        ];
    }
}
