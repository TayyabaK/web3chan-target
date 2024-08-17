<x-mary-modal
    wire:model="showConfirmDeletePostModal"
    class="backdrop-blur"
    box-class="bg-brand-secondary"
    title="Are you sure you want to delete your chant?"
>
    <div>Warning: All replies will be deleted as well.</div>

    <x-slot name="actions">
        <x-ui.button
            type="button"
            label="Cancel"
            color="gray"
            size="sm"
            wire:click="showConfirmDeletePostModal = false"
        />
        <x-ui.button
            type="button"
            label="Confirm"
            color="primary"
            size="sm"
            wire:click="deletePost"
        />
    </x-slot>
</x-mary-modal>
