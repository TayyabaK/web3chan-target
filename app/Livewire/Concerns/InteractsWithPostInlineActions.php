<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use App\Models\Post;
use Livewire\Attributes\On;

trait InteractsWithPostInlineActions
{
    public bool $showConfirmDeletePostModal = false;

    public bool $showInlinePostActions = false;

    public ?Post $currentPost = null;

    #[On('hydrateCurrentPost')]
    public function setCurrentPost(string $postId): void
    {
        $this->currentPost = Post::findOrFail($postId);

        $this->showInlinePostActions = true;

        $this->skipRender();
    }

    #[On('showDeletePostModal')]
    public function showDeletePostModal(): void
    {
        $this->showConfirmDeletePostModal = true;
    }

    public function deletePost(): void
    {
        $this->currentPost->delete();

        $this->error(
            title: 'Chant deleted',
            position: 'toast-bottom toast-center',
            css: 'btn-retro-lg border-0 alert-error',
            timeout: 5000,
            redirectTo: route('home'),
        );
    }

    public function togglePin(): void
    {
        $isPinned = $this->currentPost->refresh()->is_pinned;

        $isPinned
            ? $this->unpinPost()
            : $this->pinPost();

        $title = $isPinned
            ? 'Chant unpinned'
            : 'Chant pinned';

        $this->fireToast(title: $title);

        $this->init();
    }

    public function toggleHighlight(): void
    {
        $isHighlighted = $this->currentPost->refresh()->is_highlighted;

        $isHighlighted
            ? $this->unHighlightPost()
            : $this->highlightPost();

        $title = $isHighlighted
            ? 'Chant removed from highlights'
            : 'Chant added to highlights';

        $this->fireToast(title: $title);

        $this->init();
    }

    public function fireToast($title = ''): void
    {
        $this->info(
            title: $title,
            position: 'toast-bottom toast-center',
            css: 'bg-brand-secondary text-white btn-retro-lg border-0',
            timeout: 10000,
        );
    }

    private function unpinPost(): void
    {
        $this->currentPost->update([
            'is_pinned' => false,
        ]);
    }

    private function pinPost(): void
    {
        Post::where('user_id', $this->currentPost->user_id)
            ->where('is_pinned', true)
            ->update([
                'is_pinned' => false,
            ]);
        $this->currentPost->update([
            'is_pinned' => true,
        ]);
    }

    private function unHighlightPost(): void
    {
        $this->currentPost->update([
            'is_highlighted' => false,
        ]);
    }

    private function highlightPost(): void
    {
        $this->currentPost->update([
            'is_highlighted' => true,
        ]);
    }
}
