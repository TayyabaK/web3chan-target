<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $accepted_at
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<Invite>
 */
class Invite extends Model
{
    use BelongsToUser;
    use HasFactory;
}
