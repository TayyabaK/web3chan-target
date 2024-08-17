<x-ui.page>
    <x-ui.layout>
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs hrefBack="{{ route('direct-chants') }}">
                <x-ui.breadcrumbs.breadcrumb-item :hasCaret="true">Messages</x-ui.breadcrumbs.breadcrumb-item>
                <x-ui.breadcrumbs.breadcrumb-item :isHighlighted="true">
                    {{ '@' . str_replace(' ', '', $this->thread->contact->username) }}
                </x-ui.breadcrumbs.breadcrumb-item>
            </x-ui.breadcrumbs>
        </x-slot>

        {{-- Empty navTabs to remove them --}}
        <x-slot name="navTabs"></x-slot>

        <div class="mx-auto flex h-[89dvh] flex-col py-4">
            <div class="flex-1 overflow-y-auto">
                <div class="flex flex-col space-y-2">
                    @foreach ($this->messages as $message)
                        @if ($loop->first || $message->created_at->diffInDays($this->messages[$loop->index - 1]->created_at))
                            <x-ui.messages.datetime-header
                                dateTime="{{ $message->created_at->format('F j, Y H:i') }}"
                            />
                        @endif

                        @if ($message->sender_id === auth()->id())
                            <x-ui.messages.sent>
                                <x-ui.post.content-block :post="$message" />
                            </x-ui.messages.sent>
                        @else
                            <x-ui.messages.received
                                :avatarImageSrc="$message->sender->getAvatar()"
                                :username="$message->sender->username"
                            >
                                <x-ui.post.content-block :post="$message" />
                            </x-ui.messages.received>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="sticky bottom-0 z-50 -mx-4 -mb-8 flex flex-col bg-brand-darkest px-4">
                <div class="relative w-full border border-brand-secondary">
                    <x-post.blocks.content
                        editorFor="dm"
                        placeholder="Aa"
                    />
                    {{-- <livewire:components.post-dropdown-trigger /> --}}

                    <div class="bg-brand-darkest">
                        <div class="relative">
                            <x-post.blocks.media
                                :media="$this->selectedMedia"
                                mode="editor"
                            />
                        </div>

                        <div class="relative">
                            <x-post.blocks.giphy
                                :giphy="$this->selectedGiphy"
                                mode="editor"
                            />
                        </div>
                    </div>

                    <button
                        class="absolute right-0 top-0 mr-3 mt-3 hover:animate-pulse"
                        wire:click="send"
                    >
                        <img src="{{ asset('img/comment-arrow.svg') }}" />
                    </button>
                </div>

                <div class="-mx-4 mt-2 bg-brand-secondary px-6">
                    <livewire:components.post-actions />
                </div>
            </div>
        </div>
    </x-ui.layout>
</x-ui.page>
