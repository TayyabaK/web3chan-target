@props([
    'sidebarLeft' => null,
    'sidebarRight' => null,
    'contentHeader' => null,
    'breadcrumbs' => null,
    'navTabs' => null,
])

<div class="mx-auto max-w-8xl px-4 sm:px-6 md:px-8">
    {{-- SIDBAR LEFT --}}
    <div
        class="scrollbar-thin scrollbar-track scrollbar-thumb scrollbar-hover fixed inset-0 left-[max(0px,calc(50%-45rem))] right-auto top-0 z-20 hidden w-[21.5rem] overflow-y-auto pb-10 pl-8 pr-5 lg:block"
    >
        <nav
            aria-label="Sidebar"
            class="sticky top-0"
        >
            <div class="relative mt-4 rounded-lg bg-brand-darkest p-4">
                <a
                    href="{{ route('home') }}"
                    wire:navigate
                >
                    <img
                        src="{{ asset('img/web3chan-logo.png') }}"
                        alt="Web3Chan logo"
                    />
                </a>

                @isset($sidebarLeft)
                    {{ $sidebarLeft }}
                @else
                    @auth
                        <x-ui.navigation.main-nav />
                    @endauth

                    <div class="space-y-6 py-6">
                        <x-ui.navigation.recent-users />
                        <x-ui.navigation.all-users />
                    </div>

                    @auth
                        <div class="fixed bottom-0 mb-20 pt-20">
                            <x-ui.layout.create-channel-button />
                        </div>
                    @endauth
                @endisset
            </div>
        </nav>
    </div>
    <div class="lg:pl-[19.5rem]">
        @auth
            <x-ui.navigation.mobile-nav />
        @endauth

        <div
            class="mx-auto max-w-3xl border-brand-secondary lg:border-l xl:ml-0 xl:mr-[24.8rem] xl:max-w-none xl:border-r h-[98dvh]"
        >
            @auth
                <x-ui.layout.content-header />
            @endauth

            @isset($contentHeader)
                {{ $contentHeader }}
            @endisset

            @isset($breadcrumbs)
                {{ $breadcrumbs }}
            @endisset

            @isset($navTabs)
                <x-ui.tabs>
                    {{ $navTabs }}
                </x-ui.tabs>
            @endisset

            {{-- CONTENT --}}
            <div class="lg:m-4">
                {{ $slot }}
            </div>

            <div
                class="scrollbar-thin scrollbar-track scrollbar-thumb scrollbar-hover fixed bottom-0 right-[max(0px,calc(50%-45rem))] top-0 z-20 hidden w-[25.5rem] overflow-y-auto py-4 xl:block"
            >
                <div class="pr-8">
                    <div class="space-y-4">
                        @auth
                            <x-ui.layout.profile-switcher />
                        @endauth

                        @isset($sidebarRight)
                            {{ $sidebarRight }}
                        @else
                            @auth
                                <x-ui.widgets.invite-friends />
                            @endauth

                            <livewire:widgets.featured-block
                                type="popular"
                                entity="post"
                            />
                            <livewire:widgets.featured-block
                                type="suggested-follows"
                                entity="user"
                            />
                            <livewire:widgets.featured-block
                                type="suggested-channels"
                                entity="channel"
                            />
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        <livewire:forms.channel-form />
        <livewire:components.create-bookmark-folder />
        <livewire:components.tip-action />
    @endauth
</div>
