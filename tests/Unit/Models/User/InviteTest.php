<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\User\Invite;

beforeEach(function (): void {
    $this->invite = Invite::factory()
        ->for(User::factory())
        ->create();
});

it('has a valid factory', function (): void {
    expect($this->invite)->toBeInstanceOf(Invite::class)
        ->and($this->invite->user_id)->toBeInt()
        ->and($this->invite->email)->toBeString()
        ->and($this->invite->note)->toBeString()
        ->and($this->invite->accepted_at)->toBeInstanceOf(Carbon\Carbon::class);
});

it('has user', function (): void {
    expect($this->invite->user)->toBeInstanceOf(User::class);
});
