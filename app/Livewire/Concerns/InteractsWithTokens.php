<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

trait InteractsWithTokens
{
    public static int $tokensEarned = 0;

    public static function getTokensEarned(): int
    {
        return static::$tokensEarned;
    }
}
