<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Highlights extends Feed
{
    public static string $title = 'Highlights';

    public static string $description = 'Feeds for channel highlights';

    public static bool $allowHighlighted = true;

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = parent::queryBuilder($model, $onlyCount);

        $query->where('is_highlighted', true);

        if ($this->channel instanceof \App\Models\Channel) {
            $query->where('channel_id', $this->channel->id);
        }

        return $query->latest();
    }
}
