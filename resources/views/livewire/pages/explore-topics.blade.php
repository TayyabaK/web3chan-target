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
            @forelse ($this->topics as $topic)
                <x-ui.card.topics
                    :topic="$topic"
                    routeName="topic"
                    :routeParams="$topic"
                    :imgSrc="isset($topic->posts->first()->blocks['media']['url']) ? $topic->posts->first()->blocks['media']['url'] : null"
                />
            @empty
                No topics found.
            @endforelse
        </div>
    </x-ui.layout>
</x-ui.page>
