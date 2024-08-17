<?php

declare(strict_types=1);

use App\Livewire\Onboarding\Steps;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(Steps::class)
        ->assertStatus(200);
});
