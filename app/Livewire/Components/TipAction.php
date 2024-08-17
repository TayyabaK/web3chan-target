<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Mary\Traits\Toast;

class TipAction extends Component
{
    use Toast;

    public int $amount = 0;

    public bool $showModal = false;

    #[Locked]
    public int $userId = 0;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        'open-modal' => 'openModal',
        'close-modal' => 'closeModal',
    ];

    public function openModal(?string $id, int $userId = 0): void
    {
        if ($id === 'tip-modal' && $userId > 0) {
            $this->userId = $userId;
            $this->showModal = true;
        }
    }

    public function closeModal(?string $id = null): void
    {
        if ($id === 'tip-modal') {
            $this->showModal = false;
        }
    }

    public function tip(): void
    {
        $user = User::find($this->userId);

        auth()->user()->finances()->attach($user->id, [ // @phpstan-ignore-line
            'amount' => $this->amount,
            'type' => 'tip',
        ]);

        $this->closeModal('tip-modal');

        $this->success(
            title: 'Tip sent successfully!',
            description: __('You send :amount to :user', [
                'amount' => $this->amount,
                'user' => $user->name,
            ]).' 🎉',
            position: 'toast-bottom toast-center',
            css: 'bg-brand-secondary text-white btn-retro-lg border-0',
            timeout: 10000,
        );

        $this->dispatch('tipPostAuthor', ...[
            'amount' => $this->amount,
            'senderId' => auth()->id(),
            'receiverId' => $user->id,
        ]);
    }

    public function render(): View
    {
        return view('livewire.components.tip-action');
    }
}
