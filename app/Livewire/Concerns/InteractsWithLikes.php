<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

trait InteractsWithLikes
{
    public function toggleLike(string $postId): void
    {
        if (auth()->guest()) {
            $this->redirectRoute('login');

            return;
        }

        $this->hasLikedPost($postId)
            ? $this->unlikePost($postId)
            : $this->likePost($postId);
    }

    public function unlikePost(string $postId): void
    {
        auth()->user()->likes()->detach($postId);

        $this->dispatch('userLiked', $postId);

        $this->init();
    }

    public function likePost(string $postId): void
    {
        auth()->user()->likes()->attach($postId);

        $this->dispatch('userUnliked', $postId);

        $this->init();
    }

    public function hasLikedPost(string $postId): bool
    {
        if (auth()->guest()) {
            return false;
        }

        return collect($this->userReactions['likes'])->contains($postId);
    }
}
