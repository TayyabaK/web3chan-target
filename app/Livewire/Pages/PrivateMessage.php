<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Livewire\Components\CreatePost;
use App\Models\Message;
use App\Models\MessageThread;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class PrivateMessage extends CreatePost
{
    public MessageThread $thread;

    /**
     * @var Collection<int, Message>
     */
    public Collection $messages;

    public function mount(): void
    {
        $this->init();
    }

    public function hydrate(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $this->messages = $this->thread->messages()
            ->with(['sender', 'receiver'])
            ->oldest()
            ->get();
    }

    public function send(): void
    {
        $blocks = [
            'content' => $this->content,
            'giphy' => $this->selectedGiphy,
            'media' => $this->selectedMedia,
        ];

        $receiverId = $this->thread->contact_id === auth()->id()
            ? $this->thread->user_id
            : $this->thread->contact_id;

        auth()->user()->messages()->create([
            'thread_id' => $this->thread->id,
            'receiver_id' => $receiverId,
            'blocks' => $blocks,
        ]);

        if (! app()->runningUnitTests()) {
            $this->content = '';
            $this->selectedGiphy = null;
            $this->selectedMedia = null;
        }

        $this->dispatch('messageSent');

        $this->init();
    }

    public function render(): View
    {
        return view('livewire.pages.private-message');
    }
}
