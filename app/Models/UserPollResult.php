<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<UserFinance>
 */
class UserPollResult extends Model
{
    use BelongsToUser;

    protected $table = 'post_user_poll_results';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Post, UserPollResult>
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
