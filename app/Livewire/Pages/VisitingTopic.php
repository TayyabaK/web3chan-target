<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Post;
use App\Support\PagePosts;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class VisitingTopic extends PagePosts
{
    public string $topic;

    /**
     * @var Collection<int, Post>
     */
    public Collection $posts;

    public function mount(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $this->posts = Post::with(['user', 'replies', 'tags', 'likes'])
            ->withCount(['replies', 'tags', 'likes', 'bookmarks'])
            ->where('depth', 0)
            ->whereHas('tags', fn ($query) => $query->where('slug->en', $this->topic))
            // @todo most popular posts should be displayed first
            ->inRandomOrder()
            ->get();

        $this->refreshUserReactions();
    }

    public function render(): View
    {
        return view('livewire.pages.visiting-topic');
    }
}
