<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Livewire\Concerns\InteractsWithContentParser;
use App\Models\Post;
use App\Models\User;
use App\Notifications\ForAdmins;
use App\Notifications\ForChannelOwners;
use App\Notifications\ForUsers;

class PostCreated
{
    use InteractsWithContentParser;

    protected Post $post;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(\App\Events\PostCreated $event): void
    {
        $this->post = $event->post;

        if (filled($this->post->channel)) {
            $this->notifyChannelOwner();
        } else {
            $this->notifyAdmins();
        }

        if ($mentions = $this->extractLookups($this->post->blocks['content'])->get('mention')) {
            $this->notifyMentions($mentions);
        }
    }

    private function notifyChannelOwner(): void
    {
        $channel = $this->post->channel;

        $channel->owner->notify(new ForChannelOwners\NewPost(
            channel: $channel,
            post: $this->post
        ));
    }

    private function notifyAdmins(): void
    {
        User::query()
            ->where('is_admin', true)
            ->get()
            ->each(function ($admin): void {
                $admin->notify(new ForAdmins\NewPost(
                    post: $this->post
                ));
            });
    }

    private function notifyMentions($mentions): void
    {
        User::query()
            ->whereIn('username', $mentions)
            ->get()
            ->each(function ($user): void {
                $user->notify(new ForUsers\NewMention(
                    post: $this->post
                ));
            });
    }
}
