<?php

declare(strict_types=1);

use App\Livewire\Pages\PrivateMessage;
use App\Models\MessageThread;
use Livewire\Livewire;

beforeEach(function () {
    $this->thread = MessageThread::factory()->create();

    $this->thread->messages()->create([
        'receiver_id' => $this->thread->contact_id,
        'sender_id' => $this->thread->user_id,
        'blocks' => ['content' => 'Hello'],
    ]);

    $this->thread->messages()->create([
        'receiver_id' => $this->thread->user_id,
        'sender_id' => $this->thread->contact_id,
        'blocks' => ['content' => 'Hi'],
    ]);
});

describe('Private Message Page', function () {
    it('renders successfully', function () {
        Livewire::test(PrivateMessage::class, ['thread' => $this->thread])
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.breadcrumbs.breadcrumb-item')
            ->assertDoesNotContainBladeComponent('ui.tabs.item')
            ->assertOk();
    });

    it('has messages', function () {
        Livewire::test(PrivateMessage::class, ['thread' => $this->thread])
            ->assertCount('messages', 2)
            ->assertOk();
    });

    it('sends a message', function () {
        expect(auth()->user()->messages()->count())->toBe(1);

        Livewire::test(PrivateMessage::class, ['thread' => $this->thread])
            ->set('content', 'Hello')
            ->call('send')
            ->assertSet('content', 'Hello')
            ->assertSet('selectedGiphy', null)
            ->assertSet('selectedMedia', null)
            ->assertDispatched('messageSent')
            ->assertOk();

        expect(auth()->user()->messages()->count())->toBe(2);
    });
});
