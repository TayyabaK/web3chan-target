<x-ui.page>
    <x-ui.layout>
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs hrefBack="{{ route('home') }}">
                <x-ui.breadcrumbs.breadcrumb-item>Bookmarks</x-ui.breadcrumbs.breadcrumb-item>
            </x-ui.breadcrumbs>
        </x-slot>

        <x-slot name="sidebarLeft">
            <x-ui.navigation.main-nav />
            <x-ui.navigation.bookmark-folders />
        </x-slot>

        <x-slot name="navTabs"></x-slot>

        <div class="py-4">
            <div class="space-y-4">
                <div class="mb-4 flex justify-between text-white">
                    <div>
                        <h5 class="font-bold text-white/60">
                            Bookmarks
                            <span class="text-brand-primary">({{ request()->folder }})</span>
                        </h5>
                    </div>
                </div>
                <div class="space-y-4">
                    @forelse ($this->posts as $post)
                        <x-ui.post
                            :post="$post"
                            :isFeed="true"
                            :isUserOnline="true"
                        />
                    @empty
                        <x-ui.empty-state
                            heading="No bookmarks found for {{ request()->folder }} folder"
                            description="Bookmark a post in this folder to see it here."
                        />
                    @endforelse
                </div>
            </div>
        </div>
    </x-ui.layout>
</x-ui.page>
