<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding\Steps;

use App\Enums\User\OnboardingStepActionType;
use App\Livewire\Onboarding\Contracts\OnboardingStep;

class InviteFriends implements OnboardingStep
{
    public static int $stepPosition = 2;

    public static string $stepLabel = 'Invite 5 Friends';

    public static string $stepActionName = 'inviteFriendsAction';

    public static string $stepSessionName = 'step-invite-friends';

    public static ?string $stepIcon = 'img/dummy-avatar-48x48.jpg';

    public static OnboardingStepActionType $stepActionType = OnboardingStepActionType::Emit;

    public static int $earnableTokens = 500;

    public static function action() {}

    public static function completed() {}
}
