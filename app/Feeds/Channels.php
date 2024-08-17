<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Channels extends Feed
{
    public static string $title = 'Channels';

    public static string $description = 'Feeds for channels you are following';

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = parent::queryBuilder($model, $onlyCount);

        $query->whereHas('channel.members', function (Builder $query): void {
            $query->where('user_id', auth()->id());
        });

        return $query;
    }
}
