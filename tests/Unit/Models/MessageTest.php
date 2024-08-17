<?php

declare(strict_types=1);

use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Support\Collection;

beforeEach(function (): void {
    $this->message = Message::factory()
        ->for(MessageThread::factory(), 'thread')
        ->for(User::factory(), 'sender')
        ->for(User::factory(), 'receiver')
        ->create();
});

it('has a valid factory', function (): void {
    expect($this->message)->toBeInstanceOf(Message::class)
        ->and($this->message->id)->toBeUuid()
        ->and($this->message->sender_id)->toBeInt()
        ->and($this->message->receiver_id)->toBeInt()
        ->and($this->message->blocks)->toBeInstanceOf(Collection::class);
});

it('has thread', function (): void {
    expect($this->message->thread)->toBeInstanceOf(MessageThread::class);
});

it('has sender', function (): void {
    expect($this->message->sender)->toBeInstanceOf(User::class);
});

it('has receiver', function (): void {
    expect($this->message->receiver)->toBeInstanceOf(User::class);
});

it('casts attributes correctly', function (): void {
    $message = new Message;
    $casts = $message->getCasts();

    expect($casts)->toHaveKey('blocks', 'collection');
});
