<?php

declare(strict_types=1);

use App\Livewire\Components\PostDropdownTrigger;
use App\Models\Channel;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Tags\Tag;

beforeEach(function () {
    $this->channels = collect([1, 2])->map(function ($number) {
        return Channel::factory()
            ->create([
                'name' => 'Channel '.$number,
                'slug' => 'channel-'.$number,
            ]);
    });

    $this->topics = collect(range(1, 10))->map(function ($number) {
        return Tag::query()->create([
            'name' => ['en' => 'Topic '.$number],
            'slug' => ['en' => 'topic-'.$number],
            'type' => 'trending',
        ]);
    });

    $this->mentions = collect(range(1, 5))->map(function ($number) {
        return User::factory()
            ->create([
                'name' => 'Niko '.$number,
                'username' => 'niko-'.$number,
            ]);
    });
});

describe('Post Dropdown Triggers', function () {
    it('renders successfully', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->assertContainsBladeComponent('post.post-dropdown')
            ->assertOk();
    });

    it('can render topics dropdown', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'topic')
            ->assertSee(['Topic 1', 'Topic 2', 'Topic 3'])
            ->assertOk();
    });

    it('can render channels dropdown', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'channel')
            ->assertSee(['channel-1', 'channel-2'])
            ->assertOk();
    });

    it('can render users dropdown', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'niko')
            ->assertSee(['Niko 1', 'Niko 2'])
            ->assertOk();
    });

    it('can lookup topics', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'topic')
            ->assertCount('topics', 10)
            ->assertOk();
    });

    it('can lookup channels', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'channel')
            ->assertCount('channels', 2)
            ->assertOk();
    });

    it('can lookup users', function () {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'niko')
            ->assertCount('mentions', 5)
            ->assertOk();
    });

    it('can lookup and return exact match', function (string $lookup) {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', $lookup)
            ->dispatch('lookupValueUpdated', $lookup, $lookup.'-1')
            ->assertOk();

    })->with(['mention', 'channel', 'topic']);

    it('doesn\'t return a match', function (string $lookup) {
        Livewire::test(PostDropdownTrigger::class)
            ->set('lookupValue', 'non-existing')
            ->assertDispatched('lookupNoResults')
            ->assertOk();
    })->with(['mention', 'channel', 'topic']);

    it('doesn\'t return an exact match', function (string $lookup) {
        Livewire::test(PostDropdownTrigger::class)
            ->dispatch('lookupValueUpdated', $lookup, 'non-existing')
            ->assertNotDispatched('lookupExactMatch')
            ->assertDispatched('lookupNoResults')
            ->assertOk();
    })->with(['mention', 'channel', 'topic']);
});
