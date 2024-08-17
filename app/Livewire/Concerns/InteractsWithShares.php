<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

trait InteractsWithShares
{
    public array $sharesCount = [];

    public function sharePost(string $postId): void
    {
        $this->sharesCount[$postId] ??= 0;

        $this->sharesCount[$postId]++;

        $this->success(
            title: 'Post shared successfully!',
            description: __('You shared the post to your followers').' 🎉',
            position: 'toast-bottom toast-center',
            css: 'bg-brand-secondary text-white btn-retro-lg border-0',
            timeout: 10000,
        );
    }
}
