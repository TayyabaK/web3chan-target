<?php

declare(strict_types=1);

namespace App\Enums\Post;

enum PostStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Reported = 'reported';
}
