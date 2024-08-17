<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Post\PostStatus;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Database\Factories\Concerns\WithBlocks;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    use WithBlocks;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'channel_id' => Channel::inRandomOrder()->first() ?? Channel::factory(),
            'blocks' => $this->defineBlocks(),
            'status' => $this->faker->randomElement(array_column(PostStatus::cases(), 'value')),
        ];
    }

    /**
     * @return PostFactory|Factory<Post>
     */
    public function withReplies(int $depth = 3, bool $randomNb = true): PostFactory|Factory
    {
        return $this->afterCreating(function (Post $post) use ($depth, $randomNb): void {
            if ($depth > 0) {
                $count = $randomNb ? random_int(0, 4) : 2;
                Post::factory($count)
                    ->state([
                        'parent_id' => $post->id,
                        'depth' => $post->depth + 1,
                    ])
                    ->withReplies($depth - 1, $randomNb)
                    ->create();
            }
        });
    }
}
