<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<Bookmark> $bookmarks
 * @property-read User $user
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<BookmarkFolder>
 */
class BookmarkFolder extends Model
{
    use BelongsToUser;
    use HasFactory;
}
