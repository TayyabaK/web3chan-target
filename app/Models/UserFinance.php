<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\User\FinanceType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property FinanceType $status
 * @property int $amount
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read User $sender
 * @property-read User $receiver
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<UserFinance>
 */
class UserFinance extends Pivot
{
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => FinanceType::class,
        ];
    }
}
