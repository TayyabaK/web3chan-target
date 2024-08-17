<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\User\UserStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password = null;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => $this->faker->randomElement(array_column(UserStatus::cases(), 'value')),
            'image' => collect(
                File::files(database_path('seeders/images/people'))
            )->map(fn (string $path): string => str_replace(base_path('database/seeders/'), '', $path))->random(),
            'is_admin' => false,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user): void {
            $number = mt_rand(0, 30);
            $users = User::whereNotIn('id', [$user->id])->inRandomOrder()->take($number)->get();
            $users->each(function ($follower) use ($user): void {
                $user->followers()->attach($follower);
                $user->bookmarkFolders()->create([
                    'name' => 'Default',
                    'slug' => 'default',
                ]);
                // $user->finances()->attach($follower, [
                //     'amount' => mt_rand(0, 1000),
                //     'type' => $this->faker->randomElement(array_column(FinanceType::cases(), 'value')),
                // ]);
            });
        });
    }
}
