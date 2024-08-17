<?php

declare(strict_types=1);

use App\Livewire\Pages\DirectChants;
use App\Models\MessageThread;
use Livewire\Livewire;

beforeEach(function () {
    MessageThread::factory(6)
        ->for(auth()->user()) // @phpstan-ignore-line
        ->create([
            'user_id' => auth()->id(),
        ]);

    $this->messageThreads = auth()->user()
        ->messageThreads()
        ->get();

    $this->messageThreads->each(function (MessageThread $messageThread) {
        $messageThread->messages()->create([
            'receiver_id' => $messageThread->contact_id,
            'sender_id' => $messageThread->user_id,
            'blocks' => ['content' => 'Hello'],
        ]);
    });
});

describe('Direct Messages Page', function () {
    it('renders successfully', function () {
        Livewire::test(DirectChants::class)
            ->assertContainsBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.breadcrumbs.breadcrumb-item')
            ->assertContainsBladeComponent('ui.input.search')
            ->assertContainsBladeComponent('ui.list.chant-item')
            ->assertDoesNotContainBladeComponent('ui.tabs.item')
            ->assertOk();
    });

    it('has message threads', function () {
        Livewire::test(DirectChants::class)
            ->assertCount('messageThreads', 6)
            ->assertOk();
    });

    it('doesn\'t have message threads', function () {
        auth()->user()->messageThreads()->delete();

        Livewire::test(DirectChants::class)
            ->assertSee('No messages')
            ->assertSee('Start a conversation it will appear here!')
            ->assertOk();
    });
});
