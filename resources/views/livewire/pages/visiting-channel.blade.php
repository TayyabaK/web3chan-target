<x-ui.page>
    <x-ui.layout>
        <x-slot name="withSearch">
            <x-ui.layout.content-header />
        </x-slot>
        <x-slot name="contentHeader">
            <x-ui.layout.user-content-header
                :showInformation="true"
                :name="$channel->name"
                avatarImageSrc="{{ $channel->getAvatar() }}"
                :userName="$channel->getSlugPrepended()"
                avatarBorderColor="border-brand-accent"
                :userBio="$channel->description"
                :editable="auth()->user() && $channel->owner_id === auth()->id()"
                :headerImageSrc="$channel->banner ?? 'img/dummy-myprofile-header.jpg'"
            >
                <x-slot name="stats">
                    <x-ui.stats-item
                        itemCount="0"
                        label="Tips"
                    />

                    {{-- <x-ui.stats-item --}}
                    {{-- itemCount="1120" --}}
                    {{-- label="Followers" --}}
                    {{-- /> --}}

                    <x-ui.stats-item
                        itemCount="{{ $channel->members_count }}"
                        label="Members"
                    />

                    <x-ui.stats-item
                        :itemCount="$channel->posts_count"
                        label="Chants"
                    />
                </x-slot>

                <x-slot name="actionButtons">
                    @unless ($this->isChannelAdmin())
                        <span class="w-40">
                            <x-ui.button
                                label="Donate"
                                color="accent"
                                :fullWidth="true"
                                @click="$dispatch('open-modal', { id: 'tip-modal', userId: '{{ $channel->owner_id }}' })"
                            />
                        </span>

                        <span class="w-40">
                            <x-ui.button
                                label="{{ $this->isChannelMember($channel) ? 'Leave' : 'Join' }}"
                                color="{{ $this->isChannelMember($channel) ? 'gray' : 'white' }}"
                                :fullWidth="true"
                                wire:click="toggleJoinChannel"
                            />
                        </span>
                    @else
                        <span class="w-40">
                            <x-ui.button
                                label="Edit Channel"
                                color="primary"
                                :fullWidth="true"
                                @click="$dispatch('open-modal', { id: 'channel-edit-modal' })"
                            />
                        </span>
                    @endunless
                </x-slot>
            </x-ui.layout.user-content-header>
        </x-slot>

        @unless ($this->isChannelMember($channel) || $this->isChannelAdmin())
            <div class="flex h-96 items-center justify-center">
                <p class="text-lg text-white">Join this channel to see the feed</p>
            </div>
        @else
            <x-feed
                :feeds-nav="$this->feedsNav"
                :posts="$this->posts"
                :canPost="true"
            />

            @if ($this->isChannelAdmin())
                <livewire:forms.channel-form :channel="$channel" />
                <livewire:forms.edit-banner :hasDefaultSelection="false" />
                <livewire:forms.edit-avatar :hasDefaultSelection="false" />
            @endif
        @endif
    </x-ui.layout>
</x-ui.page>
