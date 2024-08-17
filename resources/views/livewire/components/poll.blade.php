<div class="btn-retro-lg m-6 flex flex-col gap-4 bg-brand-secondary p-6">
    <div class="flex flex-col gap-2">
        <div class="text-lg font-semibold">Poll</div>
        <div class="text-neutral/50">Ask a question and get your friends' opinions.</div>
    </div>

    <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <h4 class="font-semibold">{{ $poll['question'] }}</h4>
        </div>

        <div class="flex flex-col gap-2">
            <ul class="flex flex-col gap-2">
                @foreach ($poll['answers'] as $index => $answer)
                    @if ($mode === 'editor')
                        <li class="flex items-center gap-2 rounded-lg bg-brand-primary/50 px-4 py-2 font-semibold">
                            {{ $answer['answer'] }}
                        </li>
                    @else
                        <li
                            @class([
                                'flex cursor-pointer items-center justify-between gap-2 rounded-lg bg-brand-primary/50 py-2 pl-4 pr-2 font-semibold hover:bg-brand-primary',
                                'pointer-events-none' => $this->pollEnded || $this->userVotedIndex > -1,
                                '!bg-brand-accent !text-white' => $this->highestVotedIndex === $index && $this->pollEnded,
                            ])
                            wire:click="voteAnswer('{{ $index }}')"
                        >
                            <div class="flex items-center gap-x-2">
                                @if ($this->userVotedIndex === $index)
                                    <x-icons.check-circle
                                        class="size-6 opacity-50"
                                        fill="white"
                                    />
                                @endif

                                <span>{{ $answer['answer'] }}</span>
                            </div>
                            @if ($this->userVotedIndex > -1 && ($this->results[$index] ?? false))
                                <span class="rounded-md bg-brand-secondary/50 px-2 py-1">
                                    {{ $this->results[$index] }}%
                                </span>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
            @unless ($mode === 'editor')
                <p
                    @class([
                        'mt-2 text-center text-sm text-neutral/50',
                        '!text-white' => ! $this->pollEnded,
                    ])
                >
                    {{ $this->totalVotes }} votes -
                    {{ $this->timeLeft }}
                </p>
            @endunless
        </div>
    </div>
</div>
