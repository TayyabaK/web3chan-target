<div>
    <x-filament::modal
        id="profile-edit-avatar-modal"
        alignment="center"
        width="{{ $this->hasDefaultSelection ? '3xl' : 'sm' }}"
        class="pt-0"
    >
        <x-slot name="heading">{{ $this->hasDefaultSelection ? 'Select' : 'Upload' }} Avatar</x-slot>
        <x-slot name="description">
            <p class="text-gray-400">{{ $this->hasDefaultSelection ? 'Or upload your own' : null }} (600x600)</p>
        </x-slot>

        <x-profile.avatar-selector :withDefaultSelector="$this->hasDefaultSelection" />
    </x-filament::modal>
</div>
