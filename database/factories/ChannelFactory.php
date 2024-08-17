<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Channel\ChannelStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Channel>
 */
class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;

        return [
            'owner_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence,
            'is_private' => $this->faker->boolean,
            'status' => $this->faker->randomElement(array_column(ChannelStatus::cases(), 'value')),
            'image' => collect(
                File::files(database_path('seeders/images/channels'))
            )->map(fn (string $path): string => str_replace(base_path('database/seeders/'), '', $path))->random(),
        ];
    }
}
