<x-ui.page>
    <x-ui.layout>
        <x-feed
            :feeds-nav="$this->feedsNav"
            :posts="$this->posts"
            :canPost="true"
        />
    </x-ui.layout>
</x-ui.page>
