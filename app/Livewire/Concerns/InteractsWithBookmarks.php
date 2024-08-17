<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Livewire\Attributes\Computed;

trait InteractsWithBookmarks
{
    public function toggleBookmark(string $postId): void
    {
        if (auth()->guest()) {
            $this->redirectRoute('login');

            return;
        }

        $this->hasBookmarkedPost($postId)
            ? $this->unBookmarkPost($postId)
            : $this->bookmarkPost($postId);
    }

    public function unBookmarkPost(string $postId): void
    {
        auth()->user()->bookmarks()->detach($postId);

        $this->dispatch('userUnBookmarked', $postId);

        $this->init();
    }

    public function bookmarkPost(string $postId): void
    {
        $bookmarkFolder = auth()->user()->bookmarkFolders()->first();
        auth()->user()->bookmarks()->attach($postId, ['folder_id' => $bookmarkFolder->id]);

        $this->dispatch('userBookmarked', $postId);

        $this->init();
    }

    #[Computed]
    public function hasBookmarkedPost(string $postId): bool
    {
        if (auth()->guest()) {
            return false;
        }

        return collect($this->userReactions['bookmarks'])->contains($postId);
    }
}
