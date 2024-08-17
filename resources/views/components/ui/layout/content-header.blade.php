<div class="sticky top-0 z-10 bg-brand-darkest/95 px-8 text-white md:pb-4 md:pt-6">
    <div class="hidden items-center justify-between md:flex">
        <div class="w-24 flex-shrink-0">
            <a
                href="{{ route('home') }}"
                class="text-2xl font-semibold text-white hover:text-brand-accent"
                wire:navigate
            >
                Home
            </a>
        </div>

        <div class="flex-shrink-1 block w-full px-4">
            <livewire:components.global-search />
        </div>

        <div class="flex w-24 flex-shrink-0 items-center gap-4">
            <a
                href="{{ route('notifications') }}"
                wire:navigate
            >
                <div class="relative ml-4 h-8 w-8">
                    @if (filled($notifications = auth()->user()->unreadNotifications) && $notifications->count() > 0)
                        <x-ui.badge-indicator
                            text="{{ $notifications->count() }}"
                            class="absolute -right-1 -top-1"
                        />
                    @endif

                    <x-icons.bell />
                </div>
            </a>

            <a
                href="{{ route('direct-chants') }}"
                wire:navigate
            >
                <div class="relative h-8 w-7">
                    @if (auth()->user()->messageThreads()->count() > 0)
                        <x-ui.badge-indicator
                            :text="auth()->user()->messageThreads()->count()"
                            class="absolute -right-1 -top-1"
                        />
                    @endif

                    <x-icons.chat-bubble />
                </div>
            </a>
        </div>
    </div>
</div>
