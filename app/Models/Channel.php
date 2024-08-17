<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Channel\ChannelStatus;
use App\Models\Concerns\HasManyPosts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $owner_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property bool $is_private
 * @property ChannelStatus $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $owner
 * @property \Illuminate\Support\Collection<User> $members
 * @property \Illuminate\Support\Collection<Post> $posts
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<Channel>
 */
class Channel extends Model
{
    use HasFactory;
    use HasManyPosts;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Channel>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Post>
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'channel_member',
            foreignPivotKey: 'channel_id',
            relatedPivotKey: 'user_id',
        )->withPivot('role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Post
     */
    public function moderators(): HasMany
    {
        return $this->hasMany(ChannelMember::class);
    }

    // Convenience methods

    public function getSlugPrepended(): string
    {
        return '/'.$this->slug;
    }

    public function getAvatar(): string
    {
        return $this->image ?? 'https://ui-avatars.com/api/?'.http_build_query([
            'name' => str($this->name)->replace(' ', '+')->__toString(),
            'background' => '8125ff',
            'color' => 'fff',
        ]);
    }

    public function scopeWhereActive(Builder $query): Builder
    {
        return $query->whereStatus(ChannelStatus::Active->value);
    }

    public function scopeWhereInactive(Builder $query): Builder
    {
        return $query->whereStatus(ChannelStatus::Inactive->value);
    }

    public function scopeWhereReported(Builder $query): Builder
    {
        return $query->whereStatus(ChannelStatus::Reported->value);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_private' => 'boolean',
            'rules' => 'collection',
            'status' => ChannelStatus::class,
        ];
    }
}
