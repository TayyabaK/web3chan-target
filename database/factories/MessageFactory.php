<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Database\Factories\Concerns\WithBlocks;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class MessageFactory extends Factory
{
    use WithBlocks;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sender = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'sender_id' => $sender,
            'receiver_id' => User::where('id', '!=', $sender->id)->inRandomOrder()->first() ?? User::factory(),
            'blocks' => $this->faker->boolean() ? $this->defineBlocks() : [
                'content' => $this->faker->realText(random_int(100, 300)),
            ],
        ];
    }
}
