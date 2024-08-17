<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class ExplorePeople extends Component
{
    public Collection $people;

    public function mount(): void
    {
        $this->people = User::where('is_admin', false)->get();
    }

    public function render(): View
    {
        return view('livewire.pages.explore-people');
    }
}
