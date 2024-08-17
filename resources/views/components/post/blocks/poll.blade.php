@props([
    'poll' => null,
    'post' => null,
    'mode' => null,
])

@if ($poll && ($poll['answers'] ?? false))
    <!-- Delete action -->
    @if ($mode === 'editor')
        <div class="absolute right-0 top-0 z-50 mr-14 mt-5">
            <button
                type="button"
                wire:click="deletePoll"
                class="flex items-center gap-2 rounded-full bg-black/20 p-3 text-xs text-white hover:opacity-50"
            >
                <x-bx-trash class="w-4 fill-white" />
            </button>
        </div>
    @endif

    <livewire:components.poll
        :mode="$mode"
        :poll="$poll"
        :post="$post"
    />
@endif
