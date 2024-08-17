@props([
    'mode' => 'post',
])

<x-filament::modal
    id="media-modal"
    alignment="center"
    width="2xl"
    class="pt-0"
    @close-modal.window="$dispatch('close-action-modal-callback')"
>
    <x-slot
        name="trigger"
        wire:click="setCurrentAction('media-upload')"
    >
        <x-ui.button.create-post
            label="Photo/Video"
            icon="photograph"
            mountAction="media"
        />
    </x-slot>

    <x-slot name="heading">Upload Media (Video max filesize 50MB)</x-slot>

    <x-slot name="description">
        <div class="text-neutral/50">Upload a photo or video to share with your friends.</div>
    </x-slot>

    @if ($this->currentAction === 'media-upload')
        <x-post.media-upload :mode="$mode" />
    @endif
</x-filament::modal>
