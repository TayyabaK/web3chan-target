<?php

declare(strict_types=1);

namespace App\Enums\User;

enum OnboardingStepActionType: string
{
    case Modal = 'modal';
    case Route = 'route';
    case Emit = 'emit';
}
