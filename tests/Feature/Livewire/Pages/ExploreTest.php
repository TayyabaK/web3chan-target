<?php

declare(strict_types=1);

use App\Livewire\Pages\Explore;
use App\Models\Channel;
use Livewire\Livewire;

beforeEach(function () {
    $this->channels = Channel::factory(5)
        ->create();
});

describe('Explore Channels Page', function () {
    it('renders successfully', function () {
        Livewire::test(Explore::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertDoesNotContainBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.tabs.item')
            ->assertContainsBladeComponent('ui.card.channel')
            ->assertSee(['Channels', 'Chansters', 'Topics'])
            ->assertOk();
    });

    it('has channels', function () {
        Livewire::test(Explore::class)
            ->assertCount('channels', 5)
            ->assertOk();
    });

    it('doesn\'t have channels', function () {
        Channel::query()->delete();

        Livewire::test(Explore::class)
            ->assertCount('channels', 0)
            ->assertSee('No channels found.')
            ->assertOk();
    });
});
