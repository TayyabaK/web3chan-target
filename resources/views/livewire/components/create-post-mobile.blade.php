<div>
    <div class="relative pt-4">
        <div class="mt-4">
            <div class="relative text-white">
                <div class="absolute right-0 top-0 mr-2 mt-2 pb-2 text-right text-xs text-brand-primary">
                    (redirect /channel)
                </div>
                <x-filament::modal
                    id="post-modal"
                    alignment="center"
                    width="2xl"
                    class="pt-0"
                    @close-modal.window="$wire.closeModal()"
                >
                    <x-slot
                        name="trigger"
                        wire:click="openModal"
                    >
                        <div class="group flex min-h-12 items-center">
                            <div
                                class="ms-4 block w-full cursor-pointer font-semibold text-neutral group-hover:text-neutral"
                            >
                                Anything new to share?
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="heading">Reply on {{ $this->post }}</x-slot>

                    <div class="bg-brand-darkest">
                        <x-post.blocks.content />
                        <x-post.blocks.media :media="$this->selectedMedia" />
                        <x-post.blocks.giphy :giphy="$this->selectedGiphy" />
                    </div>

                    <x-post.actions />

                    <x-slot name="footer">
                        <button
                            type="button"
                            wire:click="create"
                            class="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-brand-accent px-4 py-3 text-sm font-semibold text-white hover:bg-brand-accent disabled:pointer-events-none disabled:opacity-50 sm:p-4"
                        >
                            Create Chant
                        </button>
                    </x-slot>
                </x-filament::modal>
            </div>
        </div>

        {{-- @todo: Fix overflow on lg caused by fixed position --}}
        <div class="fixed bottom-0 -mx-4 w-full bg-brand-secondary lg:hidden">
            <div class="px-6 py-2">
                <div class="flex items-center justify-around font-semibold text-white">

                    <x-post.actions.media-upload />

                    <x-ui.divider-vertical />

                    <x-post.actions.giphy />

                    <x-ui.divider-vertical />

                    <x-post.actions.poll />
                </div>
            </div>
        </div>
    </div>
</div>
