<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Feeds;
use App\Livewire\Concerns\HasPostsFeed;
use App\Livewire\Concerns\InteractsWithFeeds;
use App\Models\User;
use App\Support\PagePosts;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;

class Profile extends PagePosts
{
    use HasPostsFeed;
    use InteractsWithFeeds;

    public User $user;

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
            ->queryBuilder(model: $this->user)
            ->limit($this->limit)
            ->get();

        $this->pinnedPost = $this->user->posts()
            ->withCount(['replies', 'likes', 'bookmarks'])
            ->firstWhere('is_pinned', true);

        if ($this->pinnedPost && $this->loadFeed()::$allowPinned) {
            $this->posts->prepend($this->pinnedPost);
        }

        $this->refreshUserReactions();
    }

    #[On('update-avatar')]
    public function updateAvatar(?string $avatar): void
    {
        $this->user->update([
            'image' => $avatar,
        ]);

        $this->mount();
    }

    #[On('update-banner')]
    public function updateBanner(?string $banner): void
    {
        $this->user->update([
            'banner' => $banner,
        ]);

        $this->mount();
    }

    public function directChant(): void
    {
        $thread = auth()->user()->messageThreads()->firstOrCreate([ // @phpstan-ignore-line
            'contact_id' => $this->user->id,
        ]);

        $this->redirectRoute('private-message', ['thread' => $thread]);
    }

    public function render(): View
    {
        return view('livewire.pages.profile');
    }

    /**
     * @return array<string, string>
     */
    protected function feeds(): array
    {
        return [
            'posts-feed' => Feeds\Posts::class,
            'replies-feed' => Feeds\Replies::class,
            'channels-feed' => Feeds\Channels::class,
        ];
    }
}
