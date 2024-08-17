@props([
    'followings' => null,
    'followers' => null,
])

<x-filament::modal
    id="profile-stats-modal"
    width="3xl"
    class="btn-retro-lg text-center"
>
    <x-slot name="trigger">
        <x-ui.stats-item
            :itemCount="$followings->count()"
            label="Following"
        />
    </x-slot>

    <x-slot name="heading">
        <div class="text-lg font-semibold">Following</div>
    </x-slot>

    <x-slot name="description">
        <div class="text-neutral/50">Users you are following</div>
    </x-slot>

    <div class="grid grid-cols-2 gap-2 gap-y-6 px-5 py-4 lg:grid-cols-8">
        @forelse ($followings as $user)
            <x-ui.card.people
                :person="$user"
                :routeParams="$user"
                routeName="profile"
                :followingSystem="true"
            />
        @empty
            Your not following anyone.
        @endforelse
    </div>
    @if ($followings->count() === 0)
        No one following yet.
    @endif
</x-filament::modal>

<x-filament::modal
    id="profile-stats-modal"
    width="3xl"
    class="btn-retro-lg text-center"
>
    <x-slot name="trigger">
        <x-ui.stats-item
            :itemCount="$followers->count()"
            label="Followers"
        />
    </x-slot>

    <x-slot name="heading">
        <div class="text-lg font-semibold">Followers</div>
    </x-slot>

    <x-slot name="description">
        <div class="text-neutral/50">Users following you</div>
    </x-slot>

    <div class="grid grid-cols-2 gap-2 gap-y-6 px-5 py-4 lg:grid-cols-8">
        @foreach ($followers as $user)
            <x-ui.card.people
                :person="$user"
                :routeParams="$user"
                routeName="profile"
                :followingSystem="true"
            />
        @endforeach
    </div>
    @if ($followers->count() === 0)
        No followers yet.
    @endif
</x-filament::modal>
