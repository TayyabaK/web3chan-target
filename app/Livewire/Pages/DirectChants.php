<?php

declare(strict_types=1);

namespace App\Livewire\Pages;

use App\Models\MessageThread;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class DirectChants extends Component
{
    /**
     * @var Collection<int, MessageThread>
     */
    public Collection $messageThreads;

    public function mount(): void
    {
        $this->init();
    }

    public function init(): void
    {
        $messageThreadsQuery = auth()->user()->messageThreads()->count() > 0
            ? auth()->user()->messageThreads()->whereHas('latestMessage')
            : auth()->user()->messageThreadsForContact()->whereHas('latestMessageFromContact');

        $this->messageThreads = $messageThreadsQuery // @phpstan-ignore-line
            ->latest()
            ->get()
            ->map(function (MessageThread $messageThread) {
                $messageThread->loadMissing(['contact', 'latestMessage', 'latestMessageFromContact']);

                return (object) [
                    'id' => $messageThread->id,
                    'contact' => $messageThread->contact,
                    'latestMessage' => $messageThread->latestMessageFromContact,
                    'created_at' => $messageThread->created_at,
                ];
            });
    }

    public function render(): View
    {
        return view('livewire.pages.direct-chants');
    }
}
