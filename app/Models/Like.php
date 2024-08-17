<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Maize\Markable\Mark;

class Like extends Mark
{
    use HasFactory;

    public static function markableRelationName(): string
    {
        return 'likers';
    }

    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'markable');
    }
}
