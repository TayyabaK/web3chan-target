<?php

declare(strict_types=1);

use App\Livewire\Pages\MyChannels;
use App\Models\Channel;
use Livewire\Livewire;

beforeEach(function () {
    $this->channels = Channel::factory(5)
        ->for(auth()->user(), 'owner') // @phpstan-ignore-line
        ->create();
});

describe('My Channels Page', function () {
    it('renders successfully', function () {
        Livewire::test(MyChannels::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertDoesNotContainBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.card.channel')
            ->assertOk();
    });

    it('has channels', function () {
        Livewire::test(MyChannels::class)
            ->assertCount('channels', 5)
            ->assertViewHas('channels', $this->channels)
            ->assertOk();
    });

    it('doesn\'t have channels', function () {
        Channel::query()->delete();
        Livewire::test(MyChannels::class)
            ->assertCount('channels', 0)
            ->assertSee(['No channels', 'Create a channel to get started!'])
            ->assertOk();
    });
});
