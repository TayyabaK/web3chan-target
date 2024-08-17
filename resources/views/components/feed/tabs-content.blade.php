@props([
    'feedsNav' => [],
])

<div class="lg:m-4">
    <div class="space-y-4">
        {{ $beforeTabContent ?? '' }}
        <div class="pt-4">
            @foreach ($feedsNav as $key => [$feedTitle, $feedDescription])
                <div
                    id="{{ $key }}"
                    @class([
                        'hidden' => ! $this->isCurrentFeed($key),
                    ])
                    role="tabpanel"
                    aria-labelledby="{{ $key }}-item"
                >
                    <div class="mb-4 flex justify-between text-white">
                        <div>{{ $feedDescription }}</div>
                    </div>
                    <div class="space-y-4">
                        <div class="space-y-4">
                            {{ $slot ?? '' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
