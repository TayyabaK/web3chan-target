<?php

declare(strict_types=1);

use App\Livewire\Pages\Profile;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->channel = Channel::factory()->create();
    $this->channel->members()->attach(auth()->id());

    $this->authUser = auth()->user();
    $this->user = User::factory()->create();

    $this->posts = Post::factory(10)
        ->for($this->authUser)
        ->create([
            'depth' => 0,
        ]);

    $this->posts->take(4)->each(function (Post $post) {
        $post->update([
            'channel_id' => $this->channel->id,
        ]);
    });
});

describe('Profile Page', function () {
    it('renders successfully', function () {
        Livewire::test(Profile::class, ['user' => $this->authUser])
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('ui.layout.user-content-header')
            ->assertContainsBladeComponent('ui.stats-item')
            ->assertSee(['Following', 'Followers', 'Chants'])
            ->assertContainsBladeComponent('feed')
            ->assertSee(['Chants', 'Replies', 'Channels'])
            ->assertSet('currentFeed', 'posts-feed')
            ->assertOk();
    });

    it('renders authenticated users profile successfully', function () {
        Livewire::test(Profile::class, ['user' => $this->authUser])
            ->assertSee($this->authUser->name)
            ->assertSee($this->authUser->username)
            ->assertSee('Edit Profile')
            ->assertOk();
    });

    it('renders users profile successfully', function () {
        Livewire::test(Profile::class, ['user' => User::factory()->create()])
            ->assertSee($this->user->name)
            ->assertSee($this->user->username)
            ->assertSee(['Direct chant', 'Follow'])
            ->assertDontSee('Edit Profile')
            ->assertOk();
    });

    it('changes feed', function (string $feed) {
        Livewire::test(Profile::class, ['user' => $this->authUser])
            ->call('setCurrentFeed', $feed)
            ->assertSet('currentFeed', $feed)
            ->assertSet('limit', 4)
            ->assertSet('totalPosts', 10)
            ->assertCount('posts', 4)
            ->assertOk();
    })->with([
        'posts-feed',
        'replies-feed',
        'channels-feed',
    ]);
});
