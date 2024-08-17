<div class="grid place-items-center py-6">
    <img
        src="{{ asset(auth()->user()->getAvatar()) }}"
        alt=""
    />

    <div class="mt-4 text-lg font-bold text-white">{{ auth()->user()->username }}</div>

    <a
        href="#"
        class="text-underline text-sm text-brand-accent"
        @click="$dispatch('open-modal', { id: 'profile-edit-modal' })"
    >
        edit profile
    </a>
</div>

<x-ui.navigation.main-nav-item
    label="Direct Chants"
    icon="chat-bubble"
    routeName="direct-chants"
    itemCount="9"
/>
<x-ui.navigation.main-nav-item
    label="Notifications"
    icon="bell"
    routeName="notifications"
/>
<x-ui.navigation.main-nav-item
    label="Rewards"
    icon="3"
/>
<x-ui.navigation.main-nav-item
    label="Connect Wallet"
    icon="wallet"
/>
<x-ui.navigation.main-nav-item
    label="Create a Chant"
    icon="plus-nav"
    :wireNavigate="false"
    @click="$dispatch('open-modal', { id: 'post-modal', mobileView: true })"
/>
<x-ui.navigation.main-nav-item
    label="Create a Channel"
    icon="plus-nav"
    :wireNavigate="false"
    @click="$dispatch('open-modal', { id: 'channel-create-modal', mobileView: true })"
/>

<x-ui.list.container :hasBackground="true">
    <x-slot name="heading">Invite friends, earn 3chans</x-slot>

    <p class="mt-4 text-xs text-white">
        You and your friend each get 3chans if they sign up using your invitation link
    </p>

    <div x-data="{ inviteLinkCopied: false }">
        <a
            href="#"
            class="mt-4 block rounded-lg border border-brand-accent bg-black p-4 text-center font-semibold text-white"
            x-show="inviteLinkCopied == false"
            @click="inviteLinkCopied = true; console.log(inviteLinkCopied)"
            wire:navigate
        >
            Copy Invite Link
        </a>

        <a
            href="#"
            class="mt-4 block rounded-lg border border-brand-accent bg-brand-accent p-4 text-center font-semibold text-white"
            x-show="inviteLinkCopied == true"
            wire:navigate
        >
            Link Copied
        </a>
    </div>
</x-ui.list.container>

<x-ui.navigation.main-nav-item
    label="Account Settings"
    icon="home"
/>
<x-ui.navigation.main-nav-item
    label="Security Settings"
    icon="home"
/>

<x-ui.navigation.main-nav-item
    x-data
    label="Logout"
    icon="home"
    :wire-navigate="false"
    x-on:click.prevent="$refs.logoutForm.submit()"
>
    <form
        x-ref="logoutForm"
        action="{{ route('logout') }}"
        method="POST"
    >
        @csrf
    </form>
</x-ui.navigation.main-nav-item>
