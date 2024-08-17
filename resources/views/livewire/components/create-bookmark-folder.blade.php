<div class="relative">
    <div class="fixed -left-10 bottom-10 h-20 w-full">
        @if ($this->bookmarkFolderNotification)
            <div
                x-data="initBookmarkFolderNotification"
                class="btn-retro-lg mx-auto flex h-full w-[400px] items-center justify-center gap-x-4 bg-brand-secondary"
                x-show="show"
                x-transition.duration.500ms.opacity
            >
                @if ($this->userBookmarked)
                    <span>Added to bookmarks</span>
                    <x-ui.button
                        color="accent"
                        label="Add to folder"
                        size="sm"
                        @click="$dispatch('open-modal', { id: 'bookmark-folder-modal' })"
                    />
                @else
                    <span>Removed from bookmarks</span>
                @endif
            </div>
        @endif
    </div>

    <x-filament::modal
        id="bookmark-folder-modal"
        alignment="center"
        width="2xl"
        class="pt-0"
    >
        <x-slot name="heading">Add to folder</x-slot>

        <x-slot name="description">Or create a new folder then select it to add the bookmark.</x-slot>

        <div
            id="createFolders"
            class="px-4"
        >
            {{ $this->form }}
        </div>

        <x-slot name="footer">
            <div class="mb-2 px-4">
                <button
                    type="button"
                    wire:click="saveToFolder"
                    class="btn-retro block w-full gap-1 bg-brand-primary p-4 text-center text-sm font-bold text-white hover:bg-brand-primary"
                >
                    Confirm
                </button>
            </div>
        </x-slot>
    </x-filament::modal>

    @script
        <script>
            Alpine.data('initBookmarkFolderNotification', () => ({
                show: $wire.entangle('bookmarkFolderNotification').live,
                init() {
                    if (this.show) {
                        this.removeNotification();
                    }
                },
                removeNotification() {
                    setTimeout(() => {
                        this.show = false;
                    }, 10000);
                },
            }));
        </script>
    @endscript
</div>
