<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Livewire\Onboarding\Contracts\OnboardingStep;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;

trait InteractsWithOnboardingSteps
{
    #[Locked]
    // public string|Step $currentStep = '';

    abstract protected function steps(): array;

    public function setCurrentStep(string $step): void
    {
        $this->currentStep = $step;

        $this->init();
    }

    #[Computed]
    public function getSteps(): array
    {
        return collect($this->steps())
            ->mapWithKeys(fn (string|OnboardingStep $step, string $key): array => [
                $key => [
                    'position' => $step::$stepPosition,
                    'label' => $step::$stepLabel,
                    'icon' => $step::$stepIcon,
                    'actionType' => $step::$stepActionType,
                    'actionName' => $step::$stepActionName,
                    'sessionName' => $step::$stepSessionName,
                    'earnableTokens' => $step::$earnableTokens,
                    'action' => $step::action(),
                ],
            ])
            ->toArray();
    }
}
