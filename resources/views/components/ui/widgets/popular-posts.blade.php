@props(['posts' => []])

<x-ui.list.container
    heading="Popular Chants"
    :hasBackground="true"
    showMoreLink="{{ route('explore-topics') }}"
>
    @foreach ($posts as $post)
        @php
            $postMedia = $post->blocks['giphy'] ?? ($post->blocks['media']['url'] ?? '');
        @endphp

        <x-ui.media-object
            heading="{!! Str::limit($post->title, 15) !!}"
            subHeading="#{{ $post->tags?->first()?->name }}"
            viewButtonLink="{{ route('post-thread', [$post->user, $post]) }}"
        >
            <x-slot name="image">
                @unless ($postMedia)
                    <img
                        src="{{ asset('img/dummy-list-avatar-40x40.png') }}"
                        class="size-10"
                        alt=""
                    />
                @else
                    @if (Str::endsWith($postMedia, '.mp4'))
                        <video
                            class="size-10 object-cover"
                            src="{{ route('external-media', ['url' => $postMedia]) }}"
                            autoplay
                            loop
                            muted
                        ></video>
                    @else
                        <img
                            src="{{ route('external-media', ['url' => $postMedia]) }}"
                            class="size-10"
                            alt=""
                        />
                    @endif
                @endunless
            </x-slot>
        </x-ui.media-object>
    @endforeach
</x-ui.list.container>
