<?php

declare(strict_types=1);

use App\Livewire\Pages\ExplorePeople;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    $this->people = User::factory(10)
        ->create();
});

describe('Explore People Page', function () {
    it('renders successfully', function () {
        Livewire::test(ExplorePeople::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertDoesNotContainBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.tabs.item')
            ->assertContainsBladeComponent('ui.card.people')
            ->assertSee(['Channels', 'Chansters', 'Topics'])
            ->assertOk();
    });

    it('has people', function () {
        Livewire::test(ExplorePeople::class)
            ->assertCount('people', 11)
            ->assertOk();
    });
});
