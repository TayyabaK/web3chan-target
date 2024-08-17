<div>
    <x-filament::modal
        id="profile-edit-modal"
        alignment="center"
        width="3xl"
        class="pt-0"
    >
        <x-slot name="heading">Update Profile</x-slot>
        <x-slot name="description">
            <p class="text-gray-400">Update your profile information</p>
        </x-slot>

        <form wire:submit="save">
            <div class="px-4 py-6 sm:p-6">
                {{ $this->form }}
            </div>
            <div class="px-4 py-3 text-right sm:px-6">
                <x-ui.button
                    type="submit"
                    color="primary"
                    label="Save"
                    size="lg"
                    :fullWidth="true"
                />
            </div>
        </form>
    </x-filament::modal>
</div>
