<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Components\Concerns\InteractsWithSearchableDropdown;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostDropdownTrigger extends Component
{
    use InteractsWithSearchableDropdown;

    public function render(): View
    {
        return view('livewire.components.post-dropdown-trigger');
    }
}
