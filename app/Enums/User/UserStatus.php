<?php

declare(strict_types=1);

namespace App\Enums\User;

enum UserStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Reported = 'reported';
    case Banned = 'banned';
}
