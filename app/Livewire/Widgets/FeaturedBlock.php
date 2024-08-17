<?php

declare(strict_types=1);

namespace App\Livewire\Widgets;

use App\Livewire\Concerns\InteractsWithFollowing;
use App\Livewire\Concerns\InteractsWithJoinChannel;
use App\Livewire\Concerns\WithUserReactions;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class FeaturedBlock extends Component
{
    use InteractsWithFollowing;
    use InteractsWithJoinChannel;
    use WithUserReactions;

    public ?User $authenticatedUser = null;

    public string $type;

    public function mount(): void
    {
        $this->refreshUserReactions();
    }

    public function init(): void
    {
        $this->refreshUserReactions();
    }

    public function render(): View
    {
        return view('livewire.widgets.featured-block');
    }
}
