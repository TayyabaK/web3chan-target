<?php

declare(strict_types=1);

use App\Enums\Post\PostStatus;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Collection;

beforeEach(function (): void {
    $this->post = Post::factory()
        ->for(User::factory())
        ->for(Channel::factory())
        ->has(Post::factory()->count(5))
        ->create();
});

it('has a valid factory', function (): void {
    expect($this->post)->toBeInstanceOf(Post::class)
        ->and($this->post->id)->toBeUuid()
        ->and($this->post->user_id)->toBeInt()
        ->and($this->post->channel_id)->toBeInt()
        ->and($this->post->blocks)->toBeInstanceOf(Collection::class)
        ->and($this->post->status)->toBeInstanceOf(PostStatus::class);
});

it('has user', function (): void {
    expect($this->post->user)->toBeInstanceOf(User::class);
});

it('has channel', function (): void {
    expect($this->post->channel)->toBeInstanceOf(Channel::class);
});

it('has replies', function (): void {
    expect($this->post->replies)->toHaveCount(5)
        ->and($this->post->replies->first())->toBeInstanceOf(Post::class);
});

// @adam It's already checked in the previous test, but as this is a seperate relationship, I'm adding it here.
// Agree? If not, I can remove it. If it stays, I'll remove the check from the previous test.
it('has parent', function (): void {
    expect($this->post->replies->first())->toBeInstanceOf(Post::class);
});

it('casts attributes correctly', function (): void {
    $post = new Post;
    $casts = $post->getCasts();

    expect($casts)->toHaveKey('blocks', 'collection')
        ->and($casts)->toHaveKey('is_pinned', 'boolean')
        ->and($casts)->toHaveKey('status', PostStatus::class);
});
