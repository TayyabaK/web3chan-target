<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding\Steps;

use App\Enums\User\OnboardingStepActionType;
use App\Livewire\Onboarding\Contracts\OnboardingStep;

class ReactToChant implements OnboardingStep
{
    public static int $stepPosition = 4;

    public static string $stepLabel = 'React To Chant';

    public static string $stepActionName = 'reactToChantAction';

    public static string $stepSessionName = 'step-react-to-chant';

    public static ?string $stepIcon = 'img/dummy-avatar-48x48.jpg';

    public static OnboardingStepActionType $stepActionType = OnboardingStepActionType::Emit;

    public static int $earnableTokens = 500;

    public static function action() {}

    public static function completed() {}
}
