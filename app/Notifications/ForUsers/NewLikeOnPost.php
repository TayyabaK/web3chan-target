<?php

declare(strict_types=1);

namespace App\Notifications\ForUsers;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewLikeOnPost extends Notification
{
    use Queueable;

    public function __construct(private Post $post) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['database'];
    }

    public function toArray(): array
    {
        return [
            'type' => 'like',
            'id' => $this->post->id,
            'user_name' => $this->post->user->name,
            'post_content' => $this->post->content,
        ];
    }
}
