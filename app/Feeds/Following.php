<?php

declare(strict_types=1);

namespace App\Feeds;

use App\Support\Feed;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Following extends Feed
{
    public static string $title = 'Following';

    public static string $description = 'Feed for users your following';

    /**
     * {@inheritDoc}
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = parent::queryBuilder($model, $onlyCount);

        $query->whereIntegerInRaw('user_id', $this->getFollowingIds());

        return $query;
    }

    /**
     * @return array<int>
     */
    protected function getFollowingIds(): array
    {
        return auth()->user()->followings->pluck('id')->toArray() ?? [];
    }
}
