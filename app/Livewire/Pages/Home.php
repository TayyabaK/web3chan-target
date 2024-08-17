<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Feeds;
use App\Livewire\Concerns\HasPostsFeed;
use App\Livewire\Concerns\InteractsWithFeeds;
use App\Support\PagePosts;
use Illuminate\Contracts\View\View;

class Home extends PagePosts
{
    use HasPostsFeed;
    use InteractsWithFeeds;

    public function mount(): void
    {
        $this->setCurrentFeed(
            feed: 'for-you-feed',
        );
    }

    public function render(): View
    {
        return view('livewire.pages.home');
    }

    /**
     * @return array<string, string>
     */
    protected function feeds(): array
    {
        return [
            'for-you-feed' => Feeds\ForYou::class,
            'following-feed' => Feeds\Following::class,
            'channels-feed' => Feeds\Channels::class,
            'trending-feed' => Feeds\Trending::class,
        ];
    }
}
