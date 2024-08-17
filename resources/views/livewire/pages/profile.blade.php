<x-ui.page>
    <x-ui.layout>
        <x-slot name="contentHeader">
            <x-ui.layout.user-content-header
                :showInformation="true"
                :name="$this->user->name"
                :userName="$this->user->username"
                :headerImageSrc="$this->user->banner ?? 'img/dummy-myprofile-header.jpg'"
                :editable="$this->user && $this->user->id === auth()->id()"
                :avatarImageSrc="$this->user->getAvatar()"
            >
                <x-slot name="stats">
                    <x-ui.stats-follow
                        :followers="$this->user->followers"
                        :followings="$this->user->followings"
                    />

                    <x-ui.stats-item
                        :itemCount="$this->user->posts->count()"
                        label="Chants"
                    />
                </x-slot>

                <x-slot name="actionButtons">
                    @can('update', $this->user)
                        <span class="w-40">
                            <x-ui.button
                                label="Edit Profile"
                                color="primary"
                                :fullWidth="true"
                                @click="$dispatch('open-modal', { id: 'profile-edit-modal' })"
                            />
                        </span>
                    @else
                        <span class="w-40">
                            <x-ui.button
                                label="Direct chant"
                                color="primary"
                                :fullWidth="true"
                                wire:click="directChant"
                            />
                        </span>
                        <span class="w-40">
                            <x-ui.post.follow :user="$this->user" />
                        </span>
                    @endcan
                </x-slot>
            </x-ui.layout.user-content-header>
        </x-slot>

        <x-feed
            :feeds-nav="$this->feedsNav"
            :posts="$this->posts"
            :canPost="$this->user && $this->user->id === auth()->id()"
        />

        @can('update', $this->user)
            <x-slot name="sidebarRight">
                <x-ui.widgets.buy-sell-tokens />
                <x-ui.widgets.earn-more />
                <livewire:widgets.featured-block
                    type="suggested-channels"
                    entity="channel"
                />
            </x-slot>

            <livewire:forms.edit-profile />
            <livewire:forms.edit-banner />
            <livewire:forms.edit-avatar />
        @endcan
    </x-ui.layout>
</x-ui.page>
