<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Concerns\WithPollForm;
use App\Livewire\Concerns\WithPostActions;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class PostActions extends Component implements HasForms
{
    use WithPollForm;
    use WithPostActions;

    public ?string $currentAction = null;

    /** @var array<string, mixed> */
    public ?array $data = [];

    #[On('close-action-modal-callback')]
    public function handleCloseModal(): void
    {
        $this->currentAction = $this->setPollCurrentAction() ?? null;
    }

    public function setCurrentAction(string $action): void
    {
        $this->currentAction = $action;
    }

    public function render(): View
    {
        return view('livewire.components.post-actions');
    }
}
