<?php

declare(strict_types=1);

use App\Livewire\Widgets\FeaturedBlock;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(FeaturedBlock::class)
        ->assertStatus(200);
});
