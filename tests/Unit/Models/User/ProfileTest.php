<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\User\Profile;

beforeEach(function (): void {
    $this->profile = Profile::factory()
        ->for(User::factory())
        ->create();
});

it('has a valid factory', function (): void {
    expect($this->profile)->toBeInstanceOf(Profile::class)
        ->and($this->profile->user_id)->toBeInt()
        ->and($this->profile->bio)->toBeString()
        ->and($this->profile->date_of_birth)->toBeString()
        ->and($this->profile->location)->toBeString();
});

it('has user', function (): void {
    expect($this->profile->user)->toBeInstanceOf(User::class);
});
