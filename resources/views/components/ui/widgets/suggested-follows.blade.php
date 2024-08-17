@props(['people' => []])

<x-ui.list.container
    heading="Suggested Follows"
    showMoreLink="{{ route('explore-people') }}"
>
    @foreach ($people as $user)
        <x-ui.media-object
            heading="{{ $user->name }}"
            subHeading="{{ str($user->username)->prepend('@') }}"
            href="{{ route('profile', $user) }}"
            followButtonLink="#"
        >
            <x-slot name="image">
                <x-ui.avatar
                    :model="$user"
                    size="size-10"
                    mr="mr-0"
                />
            </x-slot>

            <x-slot name="actionButtons">
                <span class="w-24">
                    <x-ui.post.follow
                        :user="$user"
                        size="sm"
                    />
                </span>
            </x-slot>
        </x-ui.media-object>
    @endforeach
</x-ui.list.container>
