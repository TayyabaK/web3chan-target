<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\DB;

trait WithUserReactions
{
    public array $userReactions;

    protected function refreshUserReactions(): void
    {
        if (! auth()->user()) {
            return;
        }

        // @todo Refactor this to use Eloquent relationships after optimizing the queries to support eager loading correctly
        $this->userReactions = [
            'followings' => DB::table('followers')
                ->where('follower_id', auth()->id())
                ->pluck('user_id'),
            'likes' => DB::table('likes')
                ->where('user_id', auth()->id())
                ->pluck('post_id'),
            'bookmarks' => DB::table('bookmark_post')
                ->where('user_id', auth()->id())
                ->pluck('post_id'),
            'tips' => DB::table('user_finance')
                ->where('sender_id', auth()->id())
                ->pluck('receiver_id'),
        ];
    }
}
