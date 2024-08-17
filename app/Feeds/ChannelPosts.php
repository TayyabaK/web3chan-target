<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Models\Channel;
use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ChannelPosts extends Feed
{
    public static string $title = 'Chants';

    public static string $description = 'Feed for channel chants';

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = parent::queryBuilder($model, $onlyCount);

        $query->where('is_highlighted', false);

        if ($this->channel instanceof Channel) {
            $query->where('channel_id', $this->channel->id);
        }

        return $query->latest();
    }
}
