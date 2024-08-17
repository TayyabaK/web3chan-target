<?php

declare(strict_types=1);

use App\Livewire\Components\CreatePost;
use App\Models\Channel;
use Livewire\Livewire;

beforeEach(function () {
    $this->channel = Channel::factory()
        ->create([
            'slug' => 'somechannel',
        ]);
});

describe('CreatePost Component', function () {
    it('renders modal', function () {
        Livewire::test(CreatePost::class)
            ->assertContainsBladeComponent('filament::modal')
            ->assertContainsBladeComponent('post.blocks.content')
            ->assertContainsLivewireComponent('components.post-dropdown-trigger')
            ->assertContainsBladeComponent('post.blocks.media')
            ->assertContainsBladeComponent('post.blocks.giphy')
            ->assertContainsLivewireComponent('components.post-actions')
            ->assertStatus(200);
    });

    it('can open post modal', function () {
        Livewire::test(CreatePost::class)
            ->dispatch('open-modal', 'post-modal')
            ->assertSet('showModal', true);
    });

    it('can close post modal', function () {
        Livewire::test(CreatePost::class)
            ->dispatch('close-modal', 'post-modal')
            ->assertSet('showModal', false);
    });

    it('can not open or close post modal if we have wrong modal id', function () {
        Livewire::test(CreatePost::class)
            ->dispatch('open-modal', 'wrong-modal')
            ->assertSet('showModal', false)
            ->dispatch('close-modal', 'wrong-modal')
            ->assertSet('showModal', false);
    });

    it('can create post', function () {
        Livewire::test(CreatePost::class)
            ->set('currentUrl', '/channel/somechannel')
            ->set('content', '...')
            ->call('create')
            ->assertRedirect('/channel/somechannel');
    });
});
