<?php

declare(strict_types=1);

namespace App\Models;

use App\Livewire\Concerns\InteractsWithContentParser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property array $block
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read MessageThread $thread
 * @property-read User $sender
 * @property-read User $receiver
 * @property-read \Illuminate\Support\Collection $blocks
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<Post>
 */
class Message extends Model
{
    use HasFactory;
    use HasUuids;
    use InteractsWithContentParser;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<MessageThread, Message>
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(MessageThread::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Message>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User, Message>
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
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
        ];
    }
}
