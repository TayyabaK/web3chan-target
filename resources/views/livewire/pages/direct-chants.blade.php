<x-ui.page>
    <x-ui.layout>
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs hrefBack="{{ route('home') }}">
                <x-ui.breadcrumbs.breadcrumb-item>Messages</x-ui.breadcrumbs.breadcrumb-item>
            </x-ui.breadcrumbs>
        </x-slot>

        <div class="space-y-2 py-4">
            @if ($this->messageThreads->count() > 0)
                <div class="flex-shrink-1 mb-4 w-full">
                    <x-ui.input.search
                        placeholder="Search in messages"
                        placeholderColor="text-brand-accent"
                    />
                </div>
            @endif

            @forelse ($this->messageThreads as $messageThread)
                <x-ui.list.chant-item
                    href="{{ route('private-message', $messageThread->id ) }}"
                    :userName="$messageThread->contact->username"
                    :textPreview="$messageThread->latestMessage?->content"
                    :datePosted="$messageThread->latestMessage?->created_at->diffForHumans() ?? $messageThread->created_at->diffForHumans()"
                    :imgSrc="$messageThread->contact->getAvatar()"
                    :isActive="false"
                    :isUserOnline="false"
                />
            @empty
                <x-ui.empty-state
                    heading="No messages"
                    description="Start a conversation it will appear here!"
                />
            @endforelse
        </div>
    </x-ui.layout>
</x-ui.page>
