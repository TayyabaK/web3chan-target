<nav class="divide-y divide-brand-secondary">
    <div class="space-y-1 py-4">
        <x-ui.navigation.main-nav-item
            label="Home"
            icon="home"
            routeName="home"
            iconSize="w-7"
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
            iconSize="w-4"
        />
        <x-ui.navigation.main-nav-item
            label="Profile"
            icon="user"
            routeName="profile"
            :routeParams="['user' => auth()->user()]"
        />
         <x-ui.navigation.main-nav-item
             label="My Channels"
             icon="channel"
             routeName="my-channels"
         />
    </div>
</nav>
