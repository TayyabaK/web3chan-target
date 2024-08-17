<x-filament::modal
    id="poll-modal"
    alignment="center"
    width="2xl"
    class="pt-0"
    @close-modal.window="$dispatch('close-action-modal-callback')"
>
    <x-slot
        name="trigger"
        wire:click="setCurrentAction('poll')"
    >
        <button class="flex items-center gap-2 p-3 text-xs">
            <x-dynamic-component
                component="icons.poll"
                class="w-6"
                color
            />

            <span class="hidden hover:text-white lg:inline">Poll</span>
        </button>
    </x-slot>

    <x-slot name="heading">Create a Poll</x-slot>

    <x-slot name="description">
        <div class="text-neutral/50">Ask a question and get your friends' opinions.</div>
    </x-slot>

    @if ($this->currentAction === 'poll')
        <x-post.poll />
    @endif
</x-filament::modal>
