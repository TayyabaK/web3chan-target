<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $dropdownHeight = 'max-h-72';

    public function render(): View
    {
        return view('livewire.components.global-search');
    }
}
