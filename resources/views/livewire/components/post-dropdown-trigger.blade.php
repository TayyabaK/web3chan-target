<div class="absolute z-[1000] text-left">
    <x-post.post-dropdown
        id="topics-dropdown"
        max-height="400px"
        x-on:update-lookup-value.window="$dispatch('lookupValueUpdated', $event.detail)"
    >
        <x-slot name="heading">Choose/Create Topic</x-slot>
        <div class="space-y-4">
            @foreach ($this->topics as $topic)
                <x-ui.list.subject-item
                    :subTitleAlt="$topic['label']"
                    :slug="$topic['slug']"
                    :title="$topic['label']"
                    :imgSrc="$topic['image']"
                    :subTitle="$topic['isNew'] ? 'New topic' : '1k chants'"
                    x-on:click="$dispatch('lookup', { selected: '{{ $topic['slug'] }}' })"
                />
            @endforeach
        </div>
    </x-post.post-dropdown>

    <x-post.post-dropdown
        id="channels-dropdown"
        max-height="400px"
        x-on:update-lookup-value.window="$dispatch('lookupValueUpdated', $event.detail)"
    >
        <x-slot name="heading">Choose Channel</x-slot>
        <div class="space-y-2">
            @foreach ($this->channels as $channel)
                <x-ui.list.channel-item
                    :subTitleAlt="$channel['label']"
                    :slug="$channel['slug']"
                    :title="$channel['label']"
                    :imgSrc="$channel['image']"
                    x-on:click="$dispatch('lookup', { selected: '{{ $channel['slug'] }}' })"
                />
            @endforeach
        </div>
    </x-post.post-dropdown>

    <x-post.post-dropdown
        id="mentions-dropdown"
        max-height="400px"
        x-on:update-lookup-value.window="$dispatch('lookupValueUpdated', $event.detail)"
    >
        <x-slot name="heading">Tag</x-slot>
        <div class="space-y-2">
            @foreach ($this->mentions as $user)
                <x-ui.list.profile-item
                    wire:key="mention-{{ $user['slug'] }}"
                    :subTitleAlt="$user['label']"
                    :slug="$user['slug']"
                    :title="$user['label']"
                    :imgSrc="$user['image']"
                    x-on:click="$dispatch('lookup', { selected: '{{ $user['slug'] }}' })"
                />
            @endforeach

            <div class="pb-2 pt-4">
                <hr class="border-t-brand-primary" />
            </div>

            <div class="text-sm text-neutral">Profiles you may know</div>

            <x-ui.list.profile-item />
            <x-ui.list.profile-item />
        </div>
    </x-post.post-dropdown>
</div>
