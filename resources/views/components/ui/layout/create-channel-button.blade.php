<x-ui.button
    @click="$dispatch('open-modal', { id: 'channel-create-modal' })"
    color="transparent"
    :fullWidth="true"
>
    <div class="flex-center gap-4">
        <x-icons.plus state="active" />
        <span class="font-bold text-brand-accent">Create Channel</span>
    </div>
</x-ui.button>
