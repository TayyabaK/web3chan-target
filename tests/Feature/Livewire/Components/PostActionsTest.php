<?php

declare(strict_types=1);

use App\Livewire\Components\PostActions;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(PostActions::class)
        ->assertContainsBladeComponent('post.actions.media-upload')
        ->assertContainsBladeComponent('post.actions.giphy')
        ->assertContainsBladeComponent('post.actions.poll')
        ->assertStatus(200);

    // We will extend this test with more assertions later but currently using alpine for these modals so more complex to test
});
