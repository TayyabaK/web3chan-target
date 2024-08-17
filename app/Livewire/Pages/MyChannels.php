<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Channel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class MyChannels extends Component
{
    /**
     * @var Collection<int, Channel>
     */
    public Collection $channels;

    public function mount(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $this->channels = Channel::where('owner_id', auth()->id())
            ->withCount(['members'])
            ->get();
    }

    public function render(): View
    {
        return view('livewire.pages.my-channels');
    }
}
