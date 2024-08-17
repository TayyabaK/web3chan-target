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
            @forelse ($this->people as $user)
                <x-ui.card.people
                    :person="$user"
                    :routeParams="$user"
                    routeName="profile"
                />
            @empty
                No people found.
            @endforelse
        </div>
    </x-ui.layout>
</x-ui.page>
