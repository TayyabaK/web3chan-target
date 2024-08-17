<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use App\Models\User\Invite;
use App\Models\User\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setupTrendingTopics();
        $this->setupDemoUsers();
        $this->setupUsers();
    }

    private function setupAdmins(): void
    {
        collect([
            [
                'name' => 'Niko De Jonghe',
                'username' => 'niko',
                'email' => 'de.jonghe.niko@icloud.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
            [
                'name' => 'Adam Lee',
                'username' => 'adam_clx',
                'email' => 'adam@codelabx.ltd',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
            [
                'name' => 'Gavin Hewitt',
                'username' => 'gav_dev',
                'email' => 'gavin@instructo.nl',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
        ])->each(fn ($user) => User::create($user));
    }

    private function setupDemoUsers(): void
    {
        collect([
            [
                'name' => 'Niko De Jonghe',
                'username' => 'niko_demo',
                'email' => 'niko@web3chan.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'image' => 'img/demo_users/niko.jpeg',
            ],
            [
                'name' => 'Adam Lee',
                'username' => 'adam_demo',
                'email' => 'adam@web3chan.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'image' => 'img/demo_users/adam_400x400.jpg',
            ],
            [
                'name' => 'Gavin Hewitt',
                'username' => 'gav_demo',
                'email' => 'gavin@web3chan.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'image' => 'img/demo_users/gav_400x400.jpg',
            ],
            [
                'name' => 'Phil Verheyen',
                'username' => 'phil_demo',
                'email' => 'phil@web3chan.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'image' => 'img/demo_users/phil.png',
            ],
            [
                'name' => 'Steven Goens',
                'username' => 'steven_demo',
                'email' => 'steven@web3chan.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'image' => 'img/demo_users/steven.png',
            ],
            [
                'name' => 'Daniel Chavero',
                'username' => 'daniel_demo',
                'email' => 'daniel@web3chan.com',
                'password' => Hash::make('secret20'),
                'email_verified_at' => now(),
                'is_admin' => false,
                'image' => fake()->imageUrl(400, 400),
            ],
        ])->each(function (array $user): void {
            $newUser = User::create($user);

            $newUser->profile()->create([
                'bio' => fake()->text(),
                'date_of_birth' => fake()->date('Y-m-d', '-18 years'),
                'location' => collect([
                    fake()->streetAddress(),
                    fake()->city(),
                    fake()->country(),
                ])->join(', '),
            ]);

            $newUser->bookmarkFolders()->createMany([
                ['name' => 'Default', 'slug' => 'default'],
                ['name' => 'Crypto', 'slug' => 'crypto'],
                ['name' => 'NFT', 'slug' => 'nft'],
                ['name' => 'Solana', 'slug' => 'solana'],
                ['name' => '3Chan', 'slug' => '3chan'],
                ['name' => 'Asvoria', 'slug' => 'asvoria'],
            ]);
        });
    }

    private function setupUsers(): void
    {
        User::factory(24)
            ->has(Profile::factory(1))
            ->has(Channel::factory(2))
            ->has(Post::factory(1)->withReplies(2))
            ->has(Invite::factory(2))
            ->create();
    }

    private function setupTrendingTopics(): void
    {
        $replacements = ['Crypto', 'NFT', 'Solana', '3Chan', 'Asvorian', 'SolGnome', 'Solfluff', 'Solanasaurs', 'Pepissimo', 'Pornopoli'];

        $tags = Tag::orderByDesc('id')->limit(10)->get();

        $tags->each(function ($tag, $index) use ($replacements): void {
            $name = $replacements[$index];
            $tag->update([
                'name' => ['en' => $name],
                'slug' => ['en' => Str::slug($name)],
                'type' => 'trending',
            ]);
        });
    }
}
