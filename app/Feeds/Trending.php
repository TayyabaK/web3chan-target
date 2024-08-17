<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Trending extends Feed
{
    public static string $title = 'Trending';

    public static string $description = 'Feeds for topics that are trending';

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        return parent::queryBuilder($model)
            ->where('likes_count', '>', 0)
            ->orderBy('likes_count', 'desc');
    }
}
