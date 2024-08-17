<div>
    @if ($this->showModal)
        <x-filament::modal
            x-init="$dispatch('open-modal', { id: 'edit-banner-modal' })"
            id="edit-banner-modal"
            alignment="center"
            width="3xl"
            class="pt-0"
        >
            <x-slot name="heading">
                {{ $this->hasDefaultSelection ? 'Select' : 'Upload' }} a banner for your channel
            </x-slot>

            <x-slot name="description">
                <p class="text-gray-400">{{ $this->hasDefaultSelection ? 'Or upload your own' : null }} (1280x420)</p>
            </x-slot>

            <div class="flex flex-col gap-y-4">
                <x-profile.banner-selector :withDefaultSelector="$this->hasDefaultSelection" />
            </div>
        </x-filament::modal>
    @endif
</div>
