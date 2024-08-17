<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class ExploreTopics extends Component
{
    public Collection $topics;

    public function mount(): void
    {
        $this->topics = Tag::query()
            ->withWhereHas('posts', function ($query): void {
                $query->where('depth', 0);
                $query->whereJsonContains('blocks->media->type', 'image');
                $query->withCount('likes');
                $query->orderByDesc('likes_count');
                $query->whereHas('likes');
                $query->take(1);
            })
            ->get()
            ->sortByDesc('type');
    }

    public function render(): View
    {
        return view('livewire.pages.explore-topics');
    }
}
