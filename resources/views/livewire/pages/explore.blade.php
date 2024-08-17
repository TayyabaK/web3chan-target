<x-ui.page>
    <x-ui.layout>
        <x-slot name="navTabs">
            <x-ui.tabs.item
                label="Channels"
                routeName="explore"
            />

            <x-ui.tabs.item
                label="Chansters"
                routeName="explore-people"
            />

            <x-ui.tabs.item
                label="Topics"
                routeName="explore-topics"
            />
        </x-slot>

        <div class="grid grid-cols-2 gap-2 gap-y-6 px-5 py-4 lg:grid-cols-4">
            @forelse ($this->channels as $channel)
                <x-ui.card.channel
                    :channel="$channel"
                    :routeParams="$channel"
                    routeName="channel"
                />
            @empty
                No channels found.
            @endforelse
        </div>
    </x-ui.layout>
</x-ui.page>
