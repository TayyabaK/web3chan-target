<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding;

use App\Livewire\Concerns\InteractsWithOnboardingSteps;
use App\Livewire\Onboarding\Steps\ConnectWallet;
use App\Livewire\Onboarding\Steps\CreateChannel;
use App\Livewire\Onboarding\Steps\CreateChant;
use App\Livewire\Onboarding\Steps\InviteFriends;
use App\Livewire\Onboarding\Steps\ReactToChant;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Steps extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithOnboardingSteps;

    #[On('close-modal-callback')]
    public function handleCloseModal(string $id): void
    {
        if ($id === 'onboarding-modal') {
            session()->put('onboarding-modal', 'dismissed');
        }
    }

    #[On('connectWalletAction')]
    public function handleConnectWalletAction(): void
    {
        $this->tempPrototypeAction('step-connect-wallet');
    }

    #[On('inviteFriendsAction')]
    public function handleInviteFriendsAction(): void
    {
        if (! session()->has('invited_friends')) {
            session()->put(
                key: 'invited_friends',
                value: 1,
            );
        } elseif (session('invited_friends') < 5) {
            session()->increment('invited_friends');

            if (session('invited_friends') === 5) {
                $this->tempPrototypeAction('step-invite-friends');
            }
        }
    }

    #[On('createChannelAction')]
    public function handleCreateChannelAction(): void
    {
        $this->tempPrototypeAction('step-create-channel');
        redirect()->route('edit-channel');
    }

    #[On('reactToChantAction')]
    public function handleReactToChantAction(): void
    {
        $this->tempPrototypeAction('step-react-to-chant');
        redirect()->route('home');
    }

    #[On('createFirstChantAction')]
    public function handleCreateFirstChantAction(): void
    {
        $this->tempPrototypeAction('step-create-chant');
        redirect()->route('home');
    }

    public function tempPrototypeAction(string $action, int $numberOfTokens = 500): void
    {
        if (! session()->has($action)) {
            session()->put(
                key: 'user-tokens-total',
                value: session('user-tokens-total') + $numberOfTokens,
            );

            session()->put(
                key: $action,
                value: 'completed',
            );
        }
    }

    public function render(): View
    {
        // @todo Remove when done
        // session()->flush();
        return view('livewire.onboarding.steps');
    }

    protected function steps(): array
    {
        return [
            'connect_wallet' => ConnectWallet::class,
            'invite_friends' => InviteFriends::class,
            'create_chant' => CreateChant::class,
            'react_to_chant' => ReactToChant::class,
            'create_channel' => CreateChannel::class,
        ];
    }
}
