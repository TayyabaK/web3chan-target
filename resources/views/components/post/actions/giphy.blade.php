@props([
    'mode' => 'post',
])

<x-filament::modal
    id="giphy-modal"
    alignment="center"
    width="2xl"
    class="pt-0"
    @close-modal.window="$dispatch('close-action-modal-callback')"
>
    <x-slot
        name="trigger"
        wire:click="setCurrentAction('giphy')"
    >
        <x-ui.button.create-post
            label="Animated Gif"
            icon="gif"
        />
    </x-slot>

    <x-slot name="heading">Search for a Gif</x-slot>

    <x-slot name="description">
        <div class="text-neutral/50">Search for a gif to share with your friends.</div>
    </x-slot>

    @if ($this->currentAction === 'giphy')
        <x-post.giphy :mode="$mode" />
    @endif
</x-filament::modal>
