@props([
    'post' => null,
])

<div class="relative z-50 text-sm">
    <div>
        {!! $post->content !!}
    </div>
</div>

@if (($post->blocks['media'] ?? false) || ($post->blocks['giphy'] ?? false) || ($post->blocks['poll'] ?? false))
    <div class="relative z-50 mt-4">
        @if ($post->blocks['giphy'] ?? false)
            <x-post.blocks.giphy :giphy="$post->blocks['giphy']" />
        @endif

        @if ($post->blocks['media'] ?? false)
            @if (is_array($post->blocks['media']))
                <x-post.blocks.media :media="$post->blocks['media']" />
            @endif
        @endif

        @if ($post->blocks['poll'] ?? false)
            @if (is_array($post->blocks['poll']))
                <x-post.blocks.poll
                    :poll="$post->blocks['poll']"
                    :post="$post"
                />
            @endif
        @endif
    </div>
@endif
