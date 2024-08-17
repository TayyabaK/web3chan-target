<?php

declare(strict_types=1);

namespace App\Livewire\Onboarding\Contracts;

interface OnboardingStep
{
    public static function action();

    public static function completed();
}
