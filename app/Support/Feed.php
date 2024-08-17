<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Feed
{
    public static string $title = '';

    public static string $description = '';

    public static bool $allowPinned = false;

    public static bool $allowHighlighted = false;

    protected ?User $user = null;

    protected ?Channel $channel = null;

    /**
     * @return \Illuminate\Database\Eloquent\Builder<Post>
     */
    public function queryBuilder(?Model $model = null, bool $onlyCount = false): Builder
    {
        $query = Post::with(['user']);

        match (true) {
            $model instanceof User => $query->where('user_id', $model->id),
            $model instanceof Channel => $query->where('channel_id', $model->id),
            default => null,
        };

        if (! $onlyCount) {
            $query = $query
                ->withCount(['posts', 'replies', 'likes', 'bookmarks'])
                ->with([
                    'user' => fn (BuilderContract $query) => $query->withSum(
                        relation: 'tipsReceived as total_tips',
                        column: 'user_finance.amount',
                    ),
                ]);
        }

        return $query->where('depth', 0);
    }
}
