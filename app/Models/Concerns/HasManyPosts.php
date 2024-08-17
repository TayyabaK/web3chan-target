<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyPosts
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->whereNull('parent_id');
    }
}
