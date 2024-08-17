<?php

declare(strict_types=1);

use App\Livewire\Components\GlobalSearch;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(GlobalSearch::class)
        ->assertSet('dropdownHeight', 'max-h-72')
        ->assertStatus(200);
});
