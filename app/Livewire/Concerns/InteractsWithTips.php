<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Livewire\Attributes\On;

trait InteractsWithTips
{
    #[On('tipPostAuthor')]
    public function tipPostAuthor(int $amount, int $senderId, int $receiverId): void
    {
        $this->init();
    }

    public function hasTippedUser(int $receiverId): bool
    {
        if (auth()->guest()) {
            return false;
        }

        return collect($this->userReactions['tips'])->contains($receiverId);
    }
}
