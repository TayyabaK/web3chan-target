<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();

        $users->each(function (User $user) use ($users): void {
            for ($i = 0; $i < random_int(5, 10); $i++) {
                $threadCreatedAt = now()->subDays(random_int(1, 30));
                $contact = $users->where('id', '!=', $user->id)->random();
                $thread = $user->messageThreads()->create([
                    'contact_id' => $contact->id,
                    'created_at' => $threadCreatedAt,
                ]);

                for ($j = 0; $j < random_int(1, 3); $j++) {
                    $lastMessageAt = $user->messages()->latest()->value('created_at') ?? $threadCreatedAt;
                    $userMessagedAt = $lastMessageAt->addMinutes(random_int(1, 5));
                    $user->messages()->create(
                        Message::factory()->make([
                            'thread_id' => $thread->id,
                            'sender_id' => $user->id,
                            'receiver_id' => $contact->id,
                            'created_at' => $userMessagedAt,
                        ])->toArray(),
                    );

                    $contact->messages()->create(
                        Message::factory()->make([
                            'thread_id' => $thread->id,
                            'sender_id' => $contact->id,
                            'receiver_id' => $user->id,
                            'created_at' => $userMessagedAt->addHours(random_int(1, 6)),
                        ])->toArray(),
                    );
                }
            }
        });
    }
}
