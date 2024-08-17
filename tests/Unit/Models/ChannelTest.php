<?php

declare(strict_types=1);

use App\Enums\Channel\ChannelStatus;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;

beforeEach(function (): void {
    $this->channel = Channel::factory()
        ->for(User::factory(), 'owner')
        ->has(User::factory()->count(3), 'members')
        ->has(Post::factory()->count(5), 'posts')
        ->create();
});

it('has a valid factory', function (): void {
    expect($this->channel)->toBeInstanceOf(Channel::class)
        ->and($this->channel->owner_id)->toBeInt()
        ->and($this->channel->name)->toBeString()
        ->and($this->channel->slug)->toBeString()
        ->and($this->channel->description)->toBeString()
        ->and($this->channel->is_private)->toBeBool()
        ->and($this->channel->status)->toBeInstanceOf(ChannelStatus::class);
});

it('has an owner', function (): void {
    expect($this->channel->owner)->toBeInstanceOf(User::class);
});

it('has members', function (): void {
    expect($this->channel->members)->toHaveCount(3)
        ->and($this->channel->members->first())->toBeInstanceOf(User::class);
});

it('has posts', function (): void {
    expect($this->channel->posts)->toHaveCount(5)
        ->and($this->channel->posts->first())->toBeInstanceOf(Post::class);
});

it('casts attributes correctly', function (): void {
    $channel = new Channel;
    $casts = $channel->getCasts();

    expect($casts)->toHaveKey('is_private', 'boolean')
        ->and($casts)->toHaveKey('is_private', 'boolean')
        ->and($casts)->toHaveKey('status', ChannelStatus::class);
});
