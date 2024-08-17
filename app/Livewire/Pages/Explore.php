<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Channel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class Explore extends Component
{
    public Collection $channels;

    public function mount(): void
    {
        $this->channels = Channel::all();
    }

    public function render(): View
    {
        return view('livewire.pages.explore');
    }
}
