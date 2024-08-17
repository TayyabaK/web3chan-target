<x-ui.page>
    <x-ui.layout>
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs :href-back="route('home')">
                <x-ui.breadcrumbs.breadcrumb-item :hasCaret="true">Topics</x-ui.breadcrumbs.breadcrumb-item>
                <x-ui.breadcrumbs.breadcrumb-item :isHighlighted="true">
                    {{ $this->topic }}
                </x-ui.breadcrumbs.breadcrumb-item>
            </x-ui.breadcrumbs>
        </x-slot>

        <div class="py-4">
            <div class="space-y-4">
                <div class="pt-4">
                    <div class="mb-4 flex justify-between text-white">
                        <div>#{{ $this->topic }}</div>
                        <div class="text-brand-primary">Chants: {{ count($this->posts) }}</div>
                    </div>
                    <div class="space-y-4">
                        <div class="space-y-4">
                            @foreach ($this->posts as $post)
                                <x-ui.post
                                    :post="$post"
                                    :isUserOnline="true"
                                />
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-ui.layout>
</x-ui.page>
