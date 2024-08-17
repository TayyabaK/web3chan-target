<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ForYou extends Feed
{
    public static string $title = 'Latest';

    public static string $description = 'Latest posts on this platform';

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = parent::queryBuilder($model, $onlyCount);

        return $query->latest();
    }
}
