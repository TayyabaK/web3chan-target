<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Support\Feed;
use Exception;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;

trait InteractsWithFeeds
{
    #[Locked]
    public string|Feed $currentFeed = '';

    abstract protected function feeds(): array;

    abstract public function init(): void;

    public function setCurrentFeed(string $feed): void
    {
        $this->currentFeed = $feed;

        $this->init();
    }

    /**
     * @throws Exception
     */
    public function loadFeed(): Feed
    {
        if (! $this->currentFeed) {
            throw new Exception('No feed selected');
        }

        return resolve($this->feeds()[$this->currentFeed]);
    }

    public function isCurrentFeed(string $feed): bool
    {
        return $feed === $this->currentFeed;
    }

    #[Computed]
    public function feedsNav(): Collection
    {
        return collect($this->feeds())
            ->mapWithKeys(fn (string|Feed $feed, string $key): array => [
                $key => [
                    $feed::$title,
                    $feed::$description,
                ],
            ]);
    }
}
