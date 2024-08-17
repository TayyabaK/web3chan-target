<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding\Steps;

use App\Enums\User\OnboardingStepActionType;
use App\Livewire\Onboarding\Contracts\OnboardingStep;

class ConnectWallet implements OnboardingStep
{
    public static int $stepPosition = 1;

    public static string $stepLabel = 'Connect Your Wallet';

    public static string $stepActionName = 'connectWalletAction';

    public static string $stepSessionName = 'step-connect-wallet';

    public static ?string $stepIcon = 'img/dummy-avatar-48x48.jpg';

    public static OnboardingStepActionType $stepActionType = OnboardingStepActionType::Emit;

    public static int $earnableTokens = 500;

    public static function action() {}

    public static function completed() {}
}
