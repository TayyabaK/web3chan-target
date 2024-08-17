<?php

declare(strict_types=1);

use App\Livewire\Pages\Home;
use App\Models\Channel;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(function () {
    $this->channel = Channel::factory()->create();
    $this->channel->members()->attach(auth()->id());

    $this->posts = Post::factory(10)
        ->hasLikes(1)
        ->create([
            'depth' => 0,
        ]);

    $this->posts->take(4)->each(function (Post $post) {
        $post->update([
            'channel_id' => $this->channel->id,
        ]);
    });

    auth()->user()->followings()->detach();
    auth()->user()->followings()->attach($this->posts->pluck('user_id')->toArray());
});

describe('Home Page', function () {
    it('renders successfully', function () {
        Livewire::test(Home::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('feed')
            ->assertSee(['Latest', 'Following', 'Channels', 'Trending'])
            ->assertSet('currentFeed', 'for-you-feed')
            ->assertOk();
    });

    it('page render successfully with posts feed', function () {
        Livewire::test(Home::class)
            ->assertSet('limit', 4)
            ->assertSet('totalPosts', 10)
            ->assertCount('posts', 4)
            ->assertViewHas('posts', $this->posts->take(4))
            ->assertOk();
    });

    it('changes feed', function (string $feed) {
        Livewire::test(Home::class)
            ->call('setCurrentFeed', $feed)
            ->assertSet('currentFeed', $feed)
            ->assertSet('limit', 4)
            ->assertSet('totalPosts', 10)
            ->assertCount('posts', 4)
            ->assertOk();
    })->with([
        'for-you-feed',
        'following-feed',
        'channels-feed',
        'trending-feed',
    ]);

    it('loads more posts', function () {
        Livewire::test(Home::class)
            ->call('loadMore')
            ->assertCount('posts', 8)
            ->call('loadMore')
            ->assertCount('posts', 10)
            ->assertOk();
    });
});
