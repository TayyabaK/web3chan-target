<x-ui.page>
    <x-ui.layout>
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs hrefBack="{{ route('home') }}">
                <x-ui.breadcrumbs.breadcrumb-item>Notifications</x-ui.breadcrumbs.breadcrumb-item>
            </x-ui.breadcrumbs>
        </x-slot>
        <div
            x-data="loadNotifications()"
            class="py-4"
        >
            <div
                x-show="filteredNotifications.length > 0"
                class="flex-shrink-1 block w-full"
            >
                <x-ui.input.search
                    type="search"
                    x-ref="searchField"
                    x-model="search"
                    x-on:keydown.window.prevent.slash="$refs.searchField.focus()"
                    placeholder="Search in notifications"
                    placeholderColor="text-brand-accent"
                />
            </div>

            <div class="mt-8">
                <span
                    x-show="filteredNotifications.length > 0"
                    class="text-xs"
                    x-text="'Found '+ filteredNotifications.length +' results'"
                ></span>

                <div
                    x-show="filteredNotifications.length === 0"
                    class="mt-4"
                >
                    <x-ui.empty-state
                        heading="No notifications"
                        description="Your notifications will appear here."
                    />
                </div>

                <div class="mt-2">
                    <template
                        x-for="item in filteredNotifications"
                        :key="item.id"
                    >
                        <x-ui.list.notification-template-item />
                    </template>
                </div>
            </div>
        </div>
    </x-ui.layout>
</x-ui.page>

@push('scripts')
    <script>
        function loadNotifications() {
            return {
                search: '',
                notificationData: {!! $this->notificationData !!},
                get filteredNotifications() {
                    if (this.search === '') {
                        return this.notificationData;
                    }
                    return this.notificationData.filter((item) => {
                        return (item.user_name + item.content).toLowerCase().includes(this.search.toLowerCase());
                    });
                },
            };
        }
    </script>
@endpush
