<?php

declare(strict_types=1);

namespace App\Notifications\ForUsers;

use App\Enums\Post\PostType;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMention extends Notification
{
    use Queueable;

    public function __construct(private Post $post) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(mixed $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('You have a new mention!')
            ->line('Hi '.$notifiable->name.', you have a new mention in a post.')
            ->action('View Post', route('post-thread', [$this->post->user, $this->post]));
    }

    public function toArray(): array
    {
        return [
            'type' => PostType::Post->value,
            'id' => $this->post->id,
            'user_name' => $this->post->user->name,
            'post_content' => $this->post->blocks['content'],
        ];
    }
}
