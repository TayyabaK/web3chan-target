<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Models\Channel;
use Livewire\Attributes\Computed;

trait InteractsWithJoinChannel
{
    public function toggleJoinChannel(?int $channelId = null): void
    {
        if (auth()->guest()) {
            $this->redirectRoute('login');

            return;
        }

        if ($channelId !== null && $channelId !== 0) {
            $this->channel = Channel::findOrFail($channelId);
        }

        $this->isChannelMember($this->channel)
            ? $this->leaveChannel()
            : $this->joinChannel();

        if ($channelId !== null && $channelId !== 0) {
            $this->redirectRoute('channel', ['channel' => $this->channel]);
        }
    }

    public function joinChannel(): void
    {
        $this->channel->members()->attach(auth()->id());

        $this->dispatch('joinedChannel', $this->channel->id);
    }

    public function leaveChannel(): void
    {
        $this->channel->members()->detach(auth()->id());

        $this->dispatch('leftChannel', $this->channel->id);
    }

    #[Computed]
    public function isChannelMember(Channel $channel): bool
    {
        return $channel->refresh()->members->contains(auth()->id());
    }
}
