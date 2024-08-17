<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Post\PostStatus;
use App\Livewire\Concerns\InteractsWithContentParser;
use App\Models\Concerns\BelongsToUser;
use App\Models\Concerns\HasUserImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\Tags\HasTags;

/**
 * @property string $id
 * @property string $parent_id
 * @property int $user_id
 * @property int $channel_id
 * @property int $depth
 * @property array $block
 * @property string $title
 * @property bool $is_pinned
 * @property bool $is_highlighted
 * @property PostStatus $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $user
 * @property Channel $channel
 * @property \Illuminate\Support\Collection<Post> $replies
 * @property \Illuminate\Support\Collection<User> $likes
 * @property \Illuminate\Support\Collection<User> $bookmarks
 * @property \Illuminate\Support\Collection<Tag> $tags
 * @property \Illuminate\Support\Collection<UserPollResult> $userPollResults
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<Post>
 */
class Post extends Model
{
    use BelongsToUser;
    use HasFactory;
    use HasTags;
    use HasUserImage;
    use HasUuids;
    use InteractsWithContentParser;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Channel, Post>
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'parent_id')->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Post::class, 'parent_id')
            ->with('posts')
            ->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Post, Post>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, Post>
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'post_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, Post>
     */
    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmark_post', 'post_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<UserPollResult>
     */
    public function userPollResults(): HasMany
    {
        return $this->hasMany(UserPollResult::class);
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::of($this->blocks['content'] ?? '...')->words(16),
        );
    }

    protected function content(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->tempContentAccessor($this->blocks['content'] ?? ''),
        );
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'blocks' => 'collection',
            'is_pinned' => 'boolean',
            'status' => PostStatus::class,
        ];
    }
}
