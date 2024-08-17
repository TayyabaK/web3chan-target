<?php

declare(strict_types=1);

use App\Livewire\Forms\ChannelForm;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

describe('ChannelForm', function () {
    it('renders successfully', function () {
        Livewire::test(ChannelForm::class)
            ->assertOk();
    });

    it('can create a channel', function () {
        Livewire::test(ChannelForm::class)
            ->set('data', [
                'name' => 'Channel Name',
                'slug' => 'channel-name',
                'description' => 'Channel Description',
                'is_private' => false,
                'status' => 'active',
            ])
            ->call('save');

        assertDatabaseHas('channels', [
            'name' => 'Channel Name',
            'slug' => 'channel-name',
            'description' => 'Channel Description',
            'is_private' => false,
            'status' => 'active',
        ]);
    });

    it('can save moderators', function () {
        User::factory()->count(2)->create();
        Livewire::test(ChannelForm::class)
            ->set('data', [
                'name' => 'Channel Name',
                'slug' => 'channel-name',
                'description' => 'Channel Description',
                'is_private' => false,
                'status' => 'active',
                'moderators' => [
                    ['user_id' => 1],
                    ['user_id' => 2],
                ],
            ])
            ->call('save');

        assertDatabaseHas('channel_member', [
            'channel_id' => 1,
            'user_id' => 1,
        ]);

        assertDatabaseHas('channel_member', [
            'channel_id' => 1,
            'user_id' => 2,
        ]);
    });

});
