<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Post;
use App\Support\PagePosts;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;

class Bookmarks extends PagePosts implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    /**
     * @var Collection<int, Post>
     */
    public Collection $posts;

    public function mount(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $this->posts = Post::with(['user', 'replies'])
            ->withCount(['replies', 'likes', 'bookmarks'])
            ->whereIn('id', $this->getUsersBookmarks())
            ->latest()
            ->get();

        $this->refreshUserReactions();
    }

    #[Computed]
    public function bookmarkFolders(): Collection
    {
        return auth()->user()->bookmarkFolders->map(function ($folder): array {
            $slug = Str::slug($folder->name);

            return [
                'label' => $folder->name,
                'route' => route('bookmarks', $slug),
                'active' => request()->routeIs('bookmarks', $slug) && request('folder') === $slug,
            ];
        });
    }

    public function render(): View
    {
        return view('livewire.pages.bookmarks');
    }

    /**
     * @return Collection<int, string>
     */
    private function getUsersBookmarks(): Collection
    {
        return auth()->user()
            ->bookmarks
            ->filter(fn (Post $post): bool => $post->pivot->folder_id === $this->lookupFolderId())
            ->pluck('id');
    }

    private function lookupFolderId(): int
    {
        return auth()->user()->bookmarkFolders
            ->firstWhere('slug', request('folder'))
            ->id ?? 0;
    }
}
