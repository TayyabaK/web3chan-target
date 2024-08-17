<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Replies extends Feed
{
    public static string $title = 'Replies';

    public static string $description = 'Feed for channel replies';

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        return parent::queryBuilder($model);
    }
}
