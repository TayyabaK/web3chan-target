<?php

declare(strict_types=1);

namespace Database\Factories\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bio' => fake()->realText(),
            'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
            'location' => collect([
                fake()->streetAddress(),
                fake()->city(),
                fake()->country(),
            ])->join(', '),
        ];
    }
}
