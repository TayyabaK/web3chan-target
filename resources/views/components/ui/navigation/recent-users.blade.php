@props(['users' => []])

@if (count($users) > 0)
    <x-ui.list.container
        heading="Recent"
        :hasPadding="false"
        class="py-6"
    >
        @foreach ($users as $user)
            <x-ui.list.creator-item
                :model="$user"
                name="{{ $user->name }}"
                href="{{ route('profile', $user) }}"
                avatarImageSrc="{{ asset($user->getAvatar()) }}"
            />
        @endforeach
    </x-ui.list.container>
@endif
