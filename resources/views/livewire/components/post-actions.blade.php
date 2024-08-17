@props([
    'currentAction' => null,
])

<div class="flex items-center justify-around font-semibold">
    <x-post.actions.media-upload :currentAction="$currentAction" />

    <x-ui.divider-vertical />

    <x-post.actions.giphy :currentAction="$currentAction" />

    <x-ui.divider-vertical />

    <x-post.actions.poll :currentAction="$currentAction" />
</div>
