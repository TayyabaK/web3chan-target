<?php

declare(strict_types=1);

use App\Enums\User\UserStatus;
use App\Models\BookmarkFolder;
use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use App\Models\User\Invite;
use App\Models\User\Profile;

beforeEach(function (): void {
    $this->user = User::factory()
        ->has(Profile::factory()->count(1))
        ->has(Channel::factory()->count(2))
        ->has(Post::factory()->count(5)->withReplies(1, false))
        ->has(Invite::factory()->count(4))
        ->create();

    $this->firstPost = $this->user->posts->first()->loadMissing('replies');
});

it('has a valid factory', function (): void {
    expect($this->user)->toBeInstanceOf(User::class)
        ->and($this->user->name)->toBeString()
        ->and($this->user->username)->toBeString()
        ->and($this->user->email)->toBeString()
        ->and($this->user->email_verified_at)->toBeInstanceOf(Carbon\Carbon::class)
        ->and($this->user->password)->toBeString()
        ->and($this->user->remember_token)->toBeString()
        ->and($this->user->status)->toBeInstanceOf(UserStatus::class);

    $unverifiedUser = User::factory()->unverified()->create();
    expect($unverifiedUser->email_verified_at)->toBeNull();
});

it('has channels', function (): void {
    expect($this->user->channels)->toHaveCount(2)
        ->and($this->user->channels->first())->toBeInstanceOf(Channel::class);
});

it('has posts', function (): void {
    expect($this->user->posts)->toHaveCount(5)
        ->and($this->user->posts->first())->toBeInstanceOf(Post::class);
});

it('has post replies', function (): void {
    expect($this->firstPost->replies)->toHaveCount(2)
        ->and($this->firstPost->replies->first())->toBeInstanceOf(Post::class);
});

it('has followers', function (): void {
    $follower = User::factory()->create();

    $this->user->followers()->detach();
    $this->user->followers()->attach($follower);

    expect($this->user->followers)->toHaveCount(1)
        ->and($this->user->followers->first())->toBeInstanceOf(User::class);
});

it('has followings', function (): void {
    $following = User::factory()->create();

    $this->user->followings()->detach();
    $this->user->followings()->attach($following);

    expect($this->user->followings)->toHaveCount(1)
        ->and($this->user->followings->first())->toBeInstanceOf(User::class);
});

it('has likes', function (): void {
    $post = Post::factory()->create();

    $this->user->likes()->detach();
    $this->user->likes()->attach($post);

    expect($this->user->likes)->toHaveCount(1)
        ->and($this->user->likes->first())->toBeInstanceOf(Post::class);
});

it('has bookmarks', function (): void {
    $post = Post::factory()->create();
    $folder = BookmarkFolder::factory()->create([
        'user_id' => $this->user->id,
    ]);

    $this->user->bookmarks()->detach();
    $this->user->bookmarks()->attach($post, ['folder_id' => $folder->id]);

    expect($this->user->bookmarks)->toHaveCount(1)
        ->and($this->user->bookmarks->first())->toBeInstanceOf(Post::class);
});

it('casts attributes correctly', function (): void {
    $user = new User;
    $casts = $user->getCasts();

    expect($casts)->toHaveKey('email_verified_at', 'datetime')
        ->and($casts)->toHaveKey('password', 'hashed')
        ->and($casts)->toHaveKey('status', UserStatus::class);
});
