@props([
    'feedsNav',
])

@foreach ($feedsNav as $key => [$feedTitle, $feedDescription])
    <x-ui.tabs.item
        :asButton="true"
        :key="$key"
        :label="$feedTitle"
        :isActive="$this->isCurrentFeed($key)"
        :hasIndicator="false"
    />
@endforeach
