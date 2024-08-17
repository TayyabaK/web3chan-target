<?php

declare(strict_types=1);

use App\Livewire\Components\TipAction;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(TipAction::class)
        ->assertStatus(200);
});
