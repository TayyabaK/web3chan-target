<?php

declare(strict_types=1);

use App\Livewire\Pages\PostThread;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(function () {
    $this->post = Post::factory()
        ->withReplies(2, false)
        ->create();
});

describe('Post Thread Page', function () {
    it('renders successfully', function () {
        Livewire::test(PostThread::class, ['post' => $this->post])
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.breadcrumbs.breadcrumb-item')
            ->assertContainsBladeComponent('ui.post')
            ->assertContainsBladeComponent('ui.post.reply')
            ->assertOk();
    });

    it('has replies', function () {
        Livewire::test(PostThread::class, ['post' => $this->post->loadMissing('replies')])
            ->assertCount('post.replies', 2)
            ->assertOk();
    });
});
