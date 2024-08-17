<?php

declare(strict_types=1);

use App\Livewire\Pages\VisitingTopic;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(function () {
    $this->posts = Post::factory(3)
        ->for(auth()->user()) // @phpstan-ignore-line
        ->withReplies(1)
        ->create();

    $this->posts->each(function (Post $post) {
        $post->attachTags(['solsolana']);
    });

    $this->posts->loadMissing(['user', 'replies', 'tags']);
});

describe('Topic Page', function () {
    it('renders successfully', function () {
        Livewire::test(VisitingTopic::class, ['topic' => 'solsolana'])
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertSee('#solsolana')
            ->assertOk();
    });
});
