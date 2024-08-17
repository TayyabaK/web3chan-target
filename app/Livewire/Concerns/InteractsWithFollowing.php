<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

trait InteractsWithFollowing
{
    public function followUser(int $userId): void
    {
        if (auth()->guest()) {
            $this->redirectRoute('login');

            return;
        }

        auth()->user()->followings()->attach($userId);

        $this->dispatch('userFollowed', $userId);

        $this->init();
    }

    public function unfollowUser(int $userId): void
    {
        auth()->user()->followings()->detach($userId);

        $this->dispatch('userUnfollowed', $userId);

        $this->init();
    }

    public function isFollowingUser(int $userId): bool
    {
        if (auth()->guest()) {
            return false;
        }

        return collect($this->userReactions['followings'])->contains($userId);
    }
}
