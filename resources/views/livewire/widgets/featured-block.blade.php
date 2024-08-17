<div>
    @if ($type === 'popular')
        <x-ui.widgets.popular-posts />
    @elseif ($type === 'suggested-follows')
        <x-ui.widgets.suggested-follows />
    @elseif ($type === 'suggested-channels')
        <x-ui.widgets.suggested-channels />
    @endif
</div>
