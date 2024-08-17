<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\User\FinanceType;
use App\Enums\User\UserStatus;
use App\Models\Concerns\HasManyPosts;
use App\Models\User\Invite;
use App\Models\User\Profile;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_admin
 * @property string|null $image
 * @property string|null $banner
 * @property string $remember_token
 * @property UserStatus $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $last_activity_at
 * @property-read \Illuminate\Database\Eloquent\Collection<Channel> $channels
 * @property-read \Illuminate\Database\Eloquent\Collection<Post> $posts
 * @property-read \Illuminate\Database\Eloquent\Collection<Post> $replies
 * @property-read \Illuminate\Database\Eloquent\Collection<User> $followers
 * @property-read \Illuminate\Database\Eloquent\Collection<User> $followings
 * @property-read \Illuminate\Database\Eloquent\Collection<Invite> $invites
 * @property-read Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<Post> $likes
 * @property-read \Illuminate\Database\Eloquent\Collection<Post> $bookmarks
 * @property-read \Illuminate\Database\Eloquent\Collection<User> $finances
 * @property-read \Illuminate\Database\Eloquent\Collection<User> $tips
 * @property-read \Illuminate\Database\Eloquent\Collection<Message> $messages
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<User>
 */
class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasManyPosts;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
    ];

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Post>
     */
    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'bookmark_post', 'user_id', 'post_id')
            ->withPivot('folder_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<BookmarkFolder>
     */
    public function bookmarkFolders(): HasMany
    {
        return $this->hasMany(BookmarkFolder::class, 'user_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Channel>
     */
    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class, 'owner_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, User>
     */
    public function finances(): BelongsToMany
    {
        return $this->belongsToMany(
            related: self::class,
            table: 'user_finance',
            foreignPivotKey: 'receiver_id',
            relatedPivotKey: 'sender_id',
        )
            ->withPivot('amount', 'description', 'reference')
            ->using(UserFinance::class)
            ->withTimestamps();
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, User>
     */
    public function tips(): BelongsToMany
    {
        return $this->finances()
            ->wherePivot('type', FinanceType::Tip);
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User, User>
     */
    public function tipsReceived(): BelongsToMany
    {
        return $this->belongsToMany(
            related: self::class,
            table: 'user_finance',
            foreignPivotKey: 'sender_id',
            relatedPivotKey: 'receiver_id',
        )
            ->withPivot('amount', 'description', 'reference')
            ->using(UserFinance::class)
            ->withTimestamps();
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Invite>
     */
    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'follower_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<User>
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'followers', 'follower_id', 'user_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Post>
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Profile>
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    /**
     * @return HasMany<Post>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Post::class)->whereNotNull('parent_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<MessageThread>
     */
    public function messageThreads(): HasMany
    {
        return $this->hasMany(MessageThread::class, 'user_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<MessageThread>
     */
    public function messageThreadsForContact(): HasMany
    {
        return $this->hasMany(MessageThread::class, 'contact_id');
    }

    /*
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function isOnline(): bool
    {
        return $this->last_activity_at > now()->subMinutes(5);
    }

    public function getAvatar(): string
    {
        return $this->image ?? 'http://www.gravatar.com/avatar/'.md5($this->email);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin && $this->hasVerifiedEmail();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'is_admin' => 'boolean',
        ];
    }
}
