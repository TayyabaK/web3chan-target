<?php

declare(strict_types=1);

namespace Database\Factories\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invite>
 */
class InviteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first() ?? User::factory(),
            'email' => fake()->unique()->safeEmail(),
            'note' => fake()->realText(),
            'accepted_at' => now(),
        ];
    }
}
