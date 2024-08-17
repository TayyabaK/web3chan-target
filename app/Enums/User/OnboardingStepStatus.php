<?php

declare(strict_types=1);

namespace App\Enums\User;

enum OnboardingStepStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function getDescription(): ?string
    {
        return match ($this) {
            self::Pending => __('Pending'),
            self::InProgress => __('In Progress'),
            self::Completed => __('Completed'),
        };
    }
}
