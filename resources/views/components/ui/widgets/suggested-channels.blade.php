@props(['channels' => []])

<x-ui.list.container
    heading="Suggested Channels"
    showMoreLink="{{ route('explore') }}"
>
    @foreach ($channels as $channel)
        <x-ui.media-object
            heading="{{ $channel->name }}"
            subHeading="/{{ $channel->slug }}"
            href="{{ route('channel', $channel) }}"
            joinButtonLink="#"
        >
            <x-slot name="image">
                <img
                    src="{{ asset($channel->image) }}"
                    alt="Channel image"
                    class="size-10 object-cover"
                />
            </x-slot>

            <x-slot name="actionButtons">
                <span>
                    <x-ui.button
                        label="{{ $this->isChannelMember($channel->loadMissing('members')) ? 'Leave' : 'Join' }}"
                        color="{{ $this->isChannelMember($channel->loadMissing('members')) ? 'gray' : 'white' }}"
                        :fullWidth="true"
                        wire:click="toggleJoinChannel('{{ $channel->id }}')"
                        size="sm"
                    />
                </span>
            </x-slot>
        </x-ui.media-object>
    @endforeach
</x-ui.list.container>
