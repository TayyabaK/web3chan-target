<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $id
 * @property string $user_id
 * @property string $contact_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $user
 * @property-read User $contact
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<MessageThread>
 */
class MessageThread extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Message>
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Message>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'thread_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Message>
     */
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'thread_id')
            ->where('sender_id', auth()->id())
            ->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Message>
     */
    public function latestMessageFromContact(): HasOne
    {
        return $this->hasOne(Message::class, 'thread_id')
            ->where('receiver_id', auth()->id())
            ->latest();
    }
}
