<?php

declare(strict_types=1);

use App\Livewire\Pages\Bookmarks;
use App\Models\Post;
use Livewire\Livewire;

beforeEach(function () {
    $this->posts = Post::factory(10)->create();

    $bookmarkFolder = auth()->user()->bookmarkFolders()->create([
        'name' => 'Test Folder',
        'slug' => 'test-folder',
    ]);

    auth()->user()->bookmarks()->attach(
        id: $this->posts->take(6)->pluck('id'),
        attributes: ['folder_id' => $bookmarkFolder->id],
    );
});

describe('Bookmarks Page', function () {
    it('renders successfully', function () {
        Livewire::test(Bookmarks::class)
            ->assertContainsBladeComponent('ui.page')
            ->assertContainsBladeComponent('ui.layout')
            ->assertContainsBladeComponent('ui.breadcrumbs')
            ->assertContainsBladeComponent('ui.breadcrumbs.breadcrumb-item')
            ->assertContainsBladeComponent('ui.post')
            ->assertOk();
    });

    it('renders bookmarks menu', function () {
        Livewire::test(Bookmarks::class)
            ->assertSee('Bookmark Folders')
            ->assertSee('Test Folder')
            ->assertOk();
    });

    it('has bookmarks', function () {
        Livewire::withQueryParams(['folder' => 'test-folder'])
            ->test(Bookmarks::class)
            ->assertCount('posts', 6)
            ->assertOk();
    });

    it('doesn\'t have bookmarks', function () {
        auth()->user()->bookmarks()->detach();

        Livewire::withQueryParams(['folder' => 'test-folder'])
            ->test(Bookmarks::class)
            ->assertCount('posts', 0)
            ->assertSee('No bookmarks found for test-folder')
            ->assertOk();
    });
});
