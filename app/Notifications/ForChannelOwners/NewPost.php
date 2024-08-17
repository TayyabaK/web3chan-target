<?php

declare(strict_types=1);

namespace App\Notifications\ForChannelOwners;

use App\Enums\Post\PostType;
use App\Models\Channel;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPost extends Notification
{
    use Queueable;

    public function __construct(private Channel $channel, private Post $post) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail(mixed $notifiable)
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('You have a new post on your channel!')
            ->action('View Post', route('post-thread', [$this->post->user, $this->post]));
    }

    public function toArray(): array
    {
        return [
            'type' => PostType::Post->value,
            'id' => $this->post->id,
            'user_name' => $this->post->user->name,
            'post_content' => $this->post->content,
        ];
    }
}
