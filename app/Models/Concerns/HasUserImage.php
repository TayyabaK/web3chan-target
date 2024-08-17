<?php

declare(strict_types=1);

namespace App\Models\Concerns;

trait HasUserImage
{
    public function getUserImage(): string
    {
        return $this->user->image ?? 'http://www.gravatar.com/avatar/'.md5($this->user->email);
    }
}
