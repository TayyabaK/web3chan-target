<?php

declare(strict_types=1);

namespace App\Enums\Channel;

enum ChannelStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Reported = 'reported';
}
