<?php

declare(strict_types=1);

use App\Livewire\Pages\ExploreTopics;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Spatie\Tags\Tag;

beforeEach(function () {
    $this->posts = Post::factory(10)
        ->for(auth()->user()) // @phpstan-ignore-line
        ->hasLikes(1)
        ->create([
            'depth' => 0,
            'blocks' => [
                'type' => 'media',
                'media' => [
                    'type' => 'image',
                    'url' => 'https://example.com/image.jpg',
                ],
            ],
        ]);

    Tag::query()->delete();
    $tags = ['Crypto', 'NFT', 'Solana', '3Chan', 'Asvorian', 'SolGnome', 'Solfluff', 'Solanasaurs', 'Pepissimo', 'Pornopoli'];

    $this->topics = collect($tags)->each(function ($name): void {
        Tag::query()->create([
            'name' => ['en' => $name],
            'slug' => ['en' => Str::slug($name)],
            'type' => 'trending',
        ]);
    });

    $this->posts->each(function (Post $post, $index) use ($tags): void {
        $post->tags()->attach(Tag::query()->where('name->en', $tags[$index])->first());
    });
});

describe('Explore Topics Page', function () {
    it('renders successfully', function () {
        Livewire::test(ExploreTopics::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertDoesNotContainBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.tabs.item')
            ->assertContainsBladeComponent('ui.card.topics')
            ->assertSee('Channels')
            ->assertSee('Chansters')
            ->assertSee('Topics')
            ->assertOk();
    });

    it('has topics', function () {
        Livewire::test(ExploreTopics::class)
            ->assertCount('topics', 10)
            ->assertOk();
    });

    it('doesn\'t have channels', function () {
        Tag::query()->delete();

        Livewire::test(ExploreTopics::class)
            ->assertCount('topics', 0)
            ->assertSee('No topics found.')
            ->assertOk();
    });
});
