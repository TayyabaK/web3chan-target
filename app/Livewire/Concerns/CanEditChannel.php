<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Livewire\Attributes\Computed;

trait CanEditChannel
{
    #[Computed]
    public function isChannelAdmin(): bool
    {
        return $this->channel->owner_id === auth()->id();
    }
}
