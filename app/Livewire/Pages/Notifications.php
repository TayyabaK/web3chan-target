<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Enums\Post\PostType;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Notifications extends Component
{
    /**
     * @var Collection<int, DatabaseNotification>
     */
    public Collection $notifications;

    public function mount(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $this->notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get();
    }

    #[On('clickNotification')]
    public function handleClickNotification(string $postId): void
    {
        auth()->user() // @phpstan-ignore-line
            ->unreadNotifications()
            ->where('id', $postId)
            ->get()
            ->markAsRead();
    }

    #[Computed]
    public function notificationData(): string
    {
        $keyedPosts = $this->getPostsKeyedByNotificationId();

        return auth()->user()
            ->notifications
            ->filter(fn (DatabaseNotification $item) => filled($keyedPosts[$item->id]))
            ->map(function ($item) use ($keyedPosts): array {
                $post = $keyedPosts[$item->id];

                return [
                    'id' => $item->id,
                    'type' => $item->data['type'],
                    'user_name' => $post->user->name,
                    'content' => $post->blocks['content'],
                    'url' => route('post-thread', [$post->user, $post]),
                    'profile_image' => $post->getUserImage(),
                    'date' => $item->created_at->diffForHumans(),
                    'read' => filled($item->read_at),
                ];
            })->toJson();
    }

    public function render(): View
    {
        return view('livewire.pages.notifications');
    }

    /**
     * @return Collection<string, mixed>
     */
    private function getPostsKeyedByNotificationId(): Collection
    {
        return auth()->user()
            ->notifications
            ->mapWithKeys(function (DatabaseNotification $item) {
                if ($item['data']['type'] === PostType::Post->value) {
                    return [$item->id => Post::find($item['data']['id'])];
                }
                if ($item['data']['type'] === PostType::Reply->value) {
                    return [$item->id => Post::find($item['data']['id'])];
                }
                if ($item['data']['type'] === 'like') {
                    return [$item->id => Post::find($item['data']['id'])];
                }

                return [$item->id => null];
            });
    }
}
