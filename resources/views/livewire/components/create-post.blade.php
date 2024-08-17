<div>
    @if ($this->showModal)
        <x-filament::modal
            x-init="$dispatch('open-modal', { id: 'post-modal' })"
            id="post-modal"
            alignment="center"
            class="pt-0"
            :sticky-footer="$this->modalStickyFooter"
            :slide-over="$this->modalSlideover"
            :width="$this->modalWidth"
            @close-modal.window="$wire.closeModal()"
        >
            <x-slot name="heading">Create a Chant</x-slot>

            <div class="bg-brand-darkest">
                <x-post.blocks.content />

                <div class="relative">
                    <x-post.blocks.media
                        :media="$this->selectedMedia"
                        mode="editor"
                    />
                </div>

                <div class="relative">
                    <x-post.blocks.giphy
                        :giphy="$this->selectedGiphy"
                        mode="editor"
                    />
                </div>

                <div class="relative">
                    <x-post.blocks.poll
                        :poll="$this->poll"
                        mode="editor"
                    />
                </div>
            </div>

            <x-slot name="footer">
                <livewire:components.post-dropdown-trigger />
                <livewire:components.post-actions />
                <button
                    type="button"
                    wire:click="create"
                    class="btn-retro my-6 hidden w-full gap-1 bg-brand-accent p-4 text-center text-sm font-bold text-white hover:bg-brand-primary md:block"
                >
                    Create Chant
                </button>
            </x-slot>
        </x-filament::modal>
    @endif
</div>
