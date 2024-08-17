<x-ui.page>
    <x-ui.layout>
        <div class="grid grid-cols-2 gap-2 gap-y-6 px-5 py-4 lg:grid-cols-4">
            @forelse ($this->channels as $channel)
                <x-ui.card.channel
                    :$channel
                    routeName="channel"
                    :routeParams="$channel"
                    :userCount="$channel->members_count"
                />
            @empty
        </div>
        <div class="flex-center flex-col">
                <x-ui.empty-state
                    heading="No channels"
                    description="Create a channel to get started!"
                />
            @endforelse
        </div>
    </x-ui.layout>
</x-ui.page>
