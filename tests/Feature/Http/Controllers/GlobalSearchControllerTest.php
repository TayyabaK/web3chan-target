<?php

declare(strict_types=1);

use App\Models\Post;

it('it can call search api url', function () {

    $response = $this->get(route('global-search'));

    $response->assertStatus(200);
});

it('it can search posts', function () {
    Post::factory()->create([
        'blocks' => [
            'content' => 'aabb',
        ],
    ]);

    $response = $this->get(route('global-search', ['q' => 'aabb']));

    $response->assertJson([
        [
            'label' => 'aabb',
        ],
    ]);
});
