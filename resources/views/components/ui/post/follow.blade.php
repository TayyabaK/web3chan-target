@props([
    'user' => null,
    'size' => 'md',
])

@if ($this->isFollowingUser($user->id))
    <x-ui.button
        label="Unfollow"
        color="secondary"
        :fullWidth="true"
        :size="$size"
        wire:click="unfollowUser('{{ $user->id }}')"
    />
@else
    <x-ui.button
        label="Follow"
        color="white"
        :fullWidth="true"
        :size="$size"
        wire:click="followUser('{{ $user->id }}')"
    />
@endif
