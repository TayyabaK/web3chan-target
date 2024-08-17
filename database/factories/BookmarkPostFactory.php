<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\BookmarkFolder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BookmarkPost>
 */
class BookmarkPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_id' => Post::inRandomOrder()->first() ?? Post::factory(),
            'user_id' => User::inRandomOrder()->first() ?? User::factory(),
            'folder_id' => BookmarkFolder::inRandomOrder()->first() ?? BookmarkFolder::factory(),
        ];
    }
}
