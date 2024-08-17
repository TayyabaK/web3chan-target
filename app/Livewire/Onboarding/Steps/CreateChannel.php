<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding\Steps;

use App\Enums\User\OnboardingStepActionType;
use App\Livewire\Onboarding\Contracts\OnboardingStep;
use Illuminate\View\View;
use Livewire\Component;

class CreateChannel extends Component implements OnboardingStep
{
    public static int $stepPosition = 5;

    public static string $stepLabel = 'Create a Channel';

    public static string $stepActionName = 'createChannelAction';

    public static string $stepSessionName = 'step-create-channel';

    public static ?string $stepIcon = 'img/dummy-avatar-48x48.jpg';

    public static OnboardingStepActionType $stepActionType = OnboardingStepActionType::Emit;

    public static int $earnableTokens = 500;

    public static function action() {}

    public static function completed() {}

    public function render(): View
    {
        return view('livewire.onboarding.steps.create-channel');
    }
}
