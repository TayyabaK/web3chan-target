<?php

declare(strict_types=1);

namespace App\Enums\Post;

enum PostType: string
{
    case Post = 'post';
    case Reply = 'reply';
}
