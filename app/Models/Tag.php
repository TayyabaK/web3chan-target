<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\Tag as SpatieTag;

/**
 * @property \Illuminate\Support\Collection<Post> $posts
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<Post>
 */
class Tag extends SpatieTag
{
    public function posts(): MorphToMany
    {
        return $this->morphedByMany(
            Post::class,
            'taggable',
        );
    }
}
