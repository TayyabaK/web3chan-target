<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Post;
use App\Models\User;
use App\Support\PagePosts;
use Illuminate\Contracts\View\View;

class PostThread extends PagePosts
{
    public Post $post;

    public User $user;

    public function mount(): void
    {
        $this->init();
    }

    public function hydrate(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $this->post = $this->post->loadCount([
            'likes',
            'replies',
            'bookmarks',
        ]);

        if (auth()->check()) {
            $this->refreshUserReactions();
        }
    }

    public function render(): View
    {
        return view('livewire.pages.post-thread');
    }
}
