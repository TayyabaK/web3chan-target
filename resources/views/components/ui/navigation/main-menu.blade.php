<div class="space-y-1 py-6">
    <x-ui.navigation.main-nav-item
        label="Home"
        icon="home"
        routeName="home"
    />
    <x-ui.navigation.main-nav-item
        label="Notifications"
        icon="bell"
        routeName="notifications"
    />
    <x-ui.navigation.main-nav-item
        label="Direct Chants"
        icon="chat-bubble"
        routeName="direct-chants"
        itemCount="9"
    />
    <x-ui.navigation.main-nav-item
        label="Explore"
        icon="explore"
        routeName="explore"
    />
    <x-ui.navigation.main-nav-item
        label="Bookmarks"
        icon="bookmark"
        routeName="bookmarks"
        :routeParams="['folder' => 'default']"
    />
    <x-ui.navigation.main-nav-item
        label="Profile"
        icon="user"
        :routeParams="['user' => auth()->user()]"
        routeName="profile"
    />
    <x-ui.navigation.main-nav-item
        label="My Channels"
        icon="channel"
        routeName="my-channels"
    />
</div>

{{-- <x-ui.navigation.recent-users /> --}}

{{-- <x-ui.navigation.all-users /> --}}
