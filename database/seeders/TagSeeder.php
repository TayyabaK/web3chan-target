<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Tags\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setupTrendingTopics();
    }

    private function setupTrendingTopics(): void
    {
        $tags = ['Crypto', 'NFT', 'Solana', '3Chan', 'Asvorian', 'SolGnome', 'Solfluff', 'Solanasaurs', 'Pepissimo', 'Pornopoli'];

        collect($tags)->each(function ($name): void {
            Tag::query()->create([
                'name' => ['en' => $name],
                'slug' => ['en' => Str::slug($name)],
                'type' => 'trending',
            ]);
        });
    }
}
