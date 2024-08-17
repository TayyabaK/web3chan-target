<?php

declare(strict_types=1);

use App\Livewire\Pages\Notifications;
use App\Models\Post;
use App\Notifications\ForUsers\NewCommentOnPost;
use App\Notifications\ForUsers\NewLikeOnPost;
use App\Notifications\ForUsers\NewMention;
use Livewire\Livewire;

beforeEach(function () {
    auth()->user()->notify(new NewLikeOnPost(Post::factory()->create()));
    auth()->user()->notify(new NewMention(Post::factory()->create()));
    auth()->user()->notify(new NewCommentOnPost(Post::factory()->create()));
});

describe('Notifications Page', function () {
    it('renders successfully', function () {
        Livewire::test(Notifications::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.breadcrumbs.breadcrumb-item')
            ->assertContainsBladeComponent('ui.input.search')
            ->assertContainsBladeComponent('ui.list.notification-template-item')
            ->assertOk();
    });

    it('has notifications', function () {
        Livewire::test(Notifications::class)
            ->assertCount('notifications', 3)
            ->assertOk();
    });

    it('marks a notification as read', function () {
        $notification = auth()->user()->notifications()->first();

        Livewire::test(Notifications::class)
            ->call('handleClickNotification', $notification->id)
            ->assertOk();

        expect($notification->fresh()->read_at)->not->toBeNull();
    });

    it('doesn\'t have notifications', function () {
        auth()->user()->notifications()->delete();

        Livewire::test(Notifications::class)
            ->assertSee('No notifications')
            ->assertSee('Your notifications will appear here.')
            ->assertOk();
    });
});
