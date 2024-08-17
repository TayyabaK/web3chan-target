<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

readonly class GlobalSearchController
{
    /**
     * @todo Replace later with service API class
     */
    public function __invoke(): Collection
    {
        if (blank($searchText = request('q'))) {
            $tags = $this->searchTrendingTopics();

            return collect($tags);
        }

        return collect([
            ...$this->searchTrendingTopics(),
            ...$this->searchPosts($searchText),
            ...$this->searchChannels($searchText),
            ...$this->searchProfiles($searchText),
        ]);
    }

    private function searchTrendingTopics($searchText = '')
    {
        $tags = blank($searchText)
            ? Tag::where('type', 'trending')->get()->unique('name')
            : Tag::containing($searchText)->limit(10)->get();

        return $tags
            ->map(fn (Tag $tag): array => [
                'label' => '#'.$tag->name,
                'image' => asset('img/trending-solid.png'),
                'category' => 'Trending',
                'url' => route('topic', $tag),
            ])->all();
    }

    private function searchPosts(string $searchText = '')
    {
        $posts = Post::with('user')->where('blocks->content', 'LIKE', '%'.$searchText.'%')->limit(100)->get();

        return $posts
            ->map(fn (Post $post): array => [
                'label' => Str::limit($post->blocks['content'], 60, '...'),
                'image' => $this->getPostMedia($post),
                'category' => 'Chants',
                'url' => route('post-thread', [$post->user, $post]),
            ])->all();
    }

    private function searchChannels(string $searchText = '')
    {
        $channels = Channel::where('name', 'like', '%'.$searchText.'%')->limit(10)->get();

        return $channels
            ->map(fn (Channel $channel): array => [
                'label' => '/'.$channel->name,
                'image' => 'https://images.unsplash.com/photo-1659482634023-2c4fda99ac0c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fHx8&auto=format&fit=facearea&facepad=2.5&w=320&h=320&q=80',
                'category' => 'Channels',
                'url' => route('channel', $channel),
            ])->all();
    }

    private function searchProfiles(string $searchText = ''): array
    {
        $users = User::where('name', 'like', '%'.$searchText.'%')
            ->where('is_admin', false)
            ->get();

        return $users
            ->map(fn (User $user): array => [
                'label' => '@'.str_replace(' ', '', $user->username),
                'image' => url($user->image) ?? 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fHx8&auto=format&fit=facearea&facepad=2.5&w=320&h=320&q=80',
                'category' => 'People',
                'url' => route('profile', $user),
            ])->all();
    }

    private function getPostMedia(Post $post): string
    {
        if ($post->blocks['giphy'] ?? false) {
            return $post->blocks['giphy'];
        }

        if ($post->blocks['media'] ?? false) {
            return $post->blocks['media']['url'];
        }

        return 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fHx8&auto=format&fit=facearea&facepad=2.5&w=320&h=320&q=80';
    }
}
