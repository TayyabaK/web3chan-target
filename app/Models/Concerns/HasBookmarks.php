<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphTo;

trait HasBookmarks
{
    public function bookmarkable(): MorphTo
    {
        return $this->morphTo();
    }
}
