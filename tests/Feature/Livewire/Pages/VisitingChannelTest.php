<?php

declare(strict_types=1);

use App\Livewire\Pages\VisitingChannel;
use App\Models\Channel;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(function () {
    $this->channel = Channel::factory()->create();
    $this->channel->members()->attach(auth()->id(), ['role' => 'member']);

    $this->posts = Post::factory(10)
        ->create([
            'depth' => 0,
        ]);

    $this->posts->toQuery()->update([
        'channel_id' => $this->channel->id,
    ]);
});

describe('Channel Page', function () {
    it('renders successfully', function () {
        Livewire::test(VisitingChannel::class, ['channel' => $this->channel])
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('ui.layout.user-content-header')
            ->assertContainsBladeComponent('ui.stats-item')
            ->assertSee(['Donate', 'Join'])
            ->assertSee(['Tips', 'Members', 'Chants'])
            ->assertSet('currentFeed', 'posts-feed')
            ->assertOk();
    });

    it('renders as owner', function () {
        $this->channel->owner()->associate(auth()->user());

        Livewire::test(VisitingChannel::class, ['channel' => $this->channel])
            ->assertContainsLivewireComponent('forms.channel-form')
            ->assertContainsLivewireComponent('forms.edit-banner')
            ->assertContainsLivewireComponent('forms.edit-avatar')
            ->assertSee('Edit Channel')
            ->assertOk();
    });

    it('page render successfully with posts feed', function () {
        Livewire::test(VisitingChannel::class, ['channel' => $this->channel])
            ->assertSee(['Donate', 'Leave'])
            ->assertSet('limit', 4)
            ->assertSet('totalPosts', 10)
            ->assertCount('posts', 4)
            ->assertViewHas('posts', $this->posts->take(4))
            ->assertOk();
    });

    it('changes feed', function (string $feed) {
        Livewire::test(VisitingChannel::class, ['channel' => $this->channel])
            ->call('setCurrentFeed', $feed)
            ->assertSet('currentFeed', $feed)
            ->assertSet('limit', 4)
            ->assertSet('totalPosts', 10)
            ->assertCount('posts', 4)
            ->assertOk();
    })->with([
        'posts-feed',
        'replies-feed',
    ]);

    it('sets current feed to highlights', function () {
        $this->posts->take(2)->each->update([
            'is_highlighted' => true,
        ]);

        Livewire::test(VisitingChannel::class, ['channel' => $this->channel])
            ->call('setCurrentFeed', 'highlights-feed')
            ->assertSet('currentFeed', 'highlights-feed')
            ->assertSet('limit', 4)
            ->assertSet('totalPosts', 2)
            ->assertCount('posts', 2)
            ->assertOk();
    });
});
