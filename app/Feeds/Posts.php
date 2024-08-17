<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Models\User;
use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Posts extends Feed
{
    public static string $title = 'Chants';

    public static string $description = 'Feed for channel chants';

    public static bool $allowPinned = true;

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = parent::queryBuilder($model, $onlyCount);

        $query->where('is_pinned', false);

        if ($this->user instanceof User) {
            $query->where('user_id', $this->user->id);
        }

        return $query->latest();
    }
}
