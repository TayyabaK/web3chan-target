<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Models\Post;
use App\Models\UserPollResult;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Poll extends Component
{
    public ?string $mode = null;

    /**
     * @var array<string, mixed>
     */
    public array $poll;

    public ?Post $post = null;

    public function voteAnswer(mixed $index): void
    {
        if (auth()->guest()) {
            $this->redirectRoute('login');

            return;
        }

        $userVote = $this->post
            ->userPollResults()
            ->firstWhere('user_id', auth()->id());

        if ($userVote || is_string($index)) {
            return;
        }

        $this->poll['answers'][$index]['vote_percentage'] ??= 0;

        $totalVotes = $this->post->userPollResults()->count() + 1;

        $this->post->userPollResults()->updateOrCreate([
            'user_id' => auth()->id(),
        ], [
            'vote_answer_index' => $index,
        ]);

        $totalVotesForAnswer = $this->post->userPollResults()
            ->where('vote_answer_index', $index)
            ->count();

        $votePercentage = round(($totalVotesForAnswer / $totalVotes) * 100);
        $this->poll['answers'][$index]['vote_percentage'] = $votePercentage;
    }

    #[Computed]
    public function totalVotes(): int
    {
        return $this->post->userPollResults()->count();
    }

    #[Computed]
    public function userVotedIndex(): ?int
    {
        return $this->userVote()?->vote_answer_index ?? null;
    }

    #[Computed]
    public function timeLeft(): string
    {
        if ($this->pollEnded) {
            return 'Poll ended';
        }

        return $this->post->created_at->addHours(48)->diffForHumans(syntax: true, short: true).' left';
    }

    #[Computed]
    public function pollEnded(): bool
    {
        return $this->post->created_at->addHours(48)->isPast();
    }

    #[Computed]
    public function highestVotedIndex(): ?int
    {
        return collect($this->results)
            ->sortDesc()
            ->keys()
            ->first();
    }

    /**
     * @return array<int, int>
     */
    #[Computed]
    public function results(): array
    {
        $results = $this->post
            ->loadMissing('userPollResults')
            ->userPollResults;

        $totalVotes = $results->count();

        return $results->groupBy('vote_answer_index')
            ->map(fn ($votes): int => $votes->count())
            ->map(fn ($votes): float => round(($votes / $totalVotes) * 100))
            ->toArray();
    }

    public function render(): View
    {
        return view('livewire.components.poll');
    }

    private function userVote(): ?UserPollResult
    {
        return $this->post->userPollResults()
            ->firstWhere('user_id', auth()->id());
    }
}
