<?php

declare(strict_types=1);

namespace App\Livewire\Components\Concerns;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Spatie\Tags\Tag;

trait InteractsWithSearchableDropdown
{
    public string $lookup = '';

    public string $lookupValue = '';

    #[On('lookupValueUpdated')]
    public function lookupValueUpdated(string $lookup, string $value): void
    {
        $this->lookup = $lookup;
        $this->lookupValue = substr($value, 1);

        $this->checkForExactMatch($value);
    }

    private function checkForExactMatch(string $value): void
    {
        $model = match ($this->lookup) {
            'mention' => User::query()
                ->where('is_admin', false)
                ->where('username', $this->lookupValue)
                ->first(),
            'topic' => Tag::where('slug', $this->lookupValue)->first(),
            'channel' => Channel::where('slug', $this->lookupValue)->first(),
        };

        if ($model) {
            $this->dispatch('lookupExactMatch', ['lookup' => $this->lookup, 'value' => $value]);
        }
    }

    #[Computed]
    private function channels()
    {
        $channels = Channel::where('name', 'like', '%'.$this->lookupValue.'%')->get();

        if ($channels->isEmpty()) {
            $this->dispatch('lookupNoResults', ['lookup' => 'channel']);
        }

        return $channels
            ->map(fn (Channel $channel): array => [
                'label' => $channel->name,
                'slug' => '/'.$channel->slug,
                'image' => $channel->image ?? 'https://images.unsplash.com/photo-1659482634023-2c4fda99ac0c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fHx8&auto=format&fit=facearea&facepad=2.5&w=320&h=320&q=80',
                'url' => route('channel', $channel),
            ])->all();
    }

    #[Computed]
    private function mentions(): array
    {
        $users = User::where('is_admin', false)
            ->where('username', 'like', '%'.$this->lookupValue.'%')
            ->get();

        if ($users->isEmpty()) {
            $this->dispatch('lookupNoResults', ['lookup' => 'mention']);
        }

        return $users
            ->map(fn (User $user): array => [
                'label' => $user->name,
                'slug' => '@'.str_replace(' ', '', $user->username),
                'image' => url($user->image ?? '') ?? 'https://images.unsplash.com/photo-1659482633369-9fe69af50bfb?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fHx8&auto=format&fit=facearea&facepad=2.5&w=320&h=320&q=80',
                'category' => 'People',
                'url' => route('profile', $user),
            ])->all();
    }

    #[Computed]
    private function topics(): array
    {
        $topics = Tag::where('slug', 'like', '%'.$this->lookupValue.'%')->get();

        $isNewTopic = false;
        if ($topics->isEmpty()) {
            $topics = collect([
                [
                    'name' => Str::headline($this->lookupValue),
                    'slug' => $this->lookupValue,
                ],
            ])->mapInto(Tag::class);
            $isNewTopic = true;
        }

        return $topics
            ->map(fn (Tag $tag): array => [
                'slug' => '#'.$tag->slug,
                'label' => $tag->name,
                'image' => asset('img/trending-solid.png'),
                'category' => 'Trending',
                'url' => route('topic', $tag),
                'isNew' => $isNewTopic,
            ])->all();
    }
}
