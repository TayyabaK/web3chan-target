<?php

declare(strict_types=1);

namespace App\Models\User;

use App\Models\Concerns\BelongsToUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $bio
 * @property string $date_of_birth
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property User $user
 *
 * @mixin \Illuminate\Database\Eloquent\Builder<Profile>
 */
class Profile extends Model
{
    use BelongsToUser;
    use HasFactory;
}
