<div class="sticky top-0 z-50">
    <header
        class="relative bg-brand-darkest md:hidden lg:static lg:overflow-y-visible"
        {{-- :class="{ 'fixed inset-0 z-40 overflow-y-auto px-4': mainNavOpen || accountOpen || searchOpen }" --}}
    >
        <div class="z-40 bg-brand-darkest">
            <div class="relative flex justify-between lg:gap-8 xl:grid xl:grid-cols-12">
                <div class="flex md:absolute md:inset-y-0 md:left-0 lg:static xl:col-span-2">
                    <div class="flex items-center gap-2 md:absolute md:inset-y-0 md:right-0 lg:hidden">
                        <!-- Mobile menu button -->
                        <button
                            type="button"
                            class="relative mr-2 inline-flex items-center justify-center rounded-md p-2 text-white hover:text-gray-500"
                            :class="{ '!bg-brand-secondary': mainNavOpen, '!bg-transparent': !(mainNavOpen)  }"
                            @click="mainNavOpen = true"
                        >
                            <span class="sr-only">Open menu</span>
                            <svg
                                class="block h-6 w-6"
                                :class="{ 'hidden': mainNavOpen, 'block': !(mainNavOpen) }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                                ></path>
                            </svg>
                            <svg
                                class="hidden h-6 w-6"
                                :class="{ 'block': mainNavOpen, 'hidden': !(mainNavOpen) }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 18L18 6M6 6l12 12"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex flex-shrink-0 items-center">
                        <a
                            href="{{ route('home') }}"
                            wire:navigate
                        >
                            <img
                                class="block w-[134px]"
                                src="{{ asset('img/web3chan-logo.png') }}"
                                alt="Web3chan logo"
                            />
                        </a>
                    </div>
                </div>
                <div class="min-w-0 flex-1 md:px-8 lg:px-0 xl:col-span-6">
                    <div
                        class="flex items-center justify-end py-4 pl-6 md:mx-auto md:max-w-3xl lg:mx-0 lg:max-w-none xl:px-0"
                    >
                        <div class="flex items-center gap-4">
                            <div class="">
                                <a
                                    href="#"
                                    class=""
                                    @click="searchOpen = true"
                                >
                                    <x-icons.magnifier class="w-6" />
                                </a>
                            </div>

                            <x-ui.divider-vertical />

                            <div class="flex-shrink-0">
                                <a
                                    href="#"
                                    class=""
                                    @click="accountOpen = true"
                                >
                                    <img
                                        src="{{ asset( auth()->user()->getAvatar()) }}"
                                        alt=""
                                        class="size-10 flex-shrink-0"
                                    />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN MENU --}}
        <nav
            class="lg:hidden overflow-y-auto"
            style="height: calc(100dvh - 72px)"
            x-ref="panel"
            x-show="mainNavOpen"
            @click.away="mainNavOpen = false"
            style="display: none"
        >
            <div class="mx-auto max-w-3xl space-y-1 px-2 pb-3 pt-2 sm:px-4">
                <x-ui.navigation.main-menu />
            </div>
        </nav>

        {{-- ACCOUNT MENU --}}
        <nav
            class="lg:hidden overflow-y-auto"
            style="height: calc(100dvh - 72px)"
            x-ref="panel"
            x-show="accountOpen"
            @click.away="accountOpen = false"
            style="display: none"
        >
            <div class="mx-auto max-w-3xl space-y-1 px-2 pb-3 pt-2 sm:px-4">
                <x-ui.navigation.account-menu />
            </div>
        </nav>

        {{-- SEARCH --}}
        {{-- @todo: search input + back to main --}}
        <nav
            class="absolute inset-0 z-50 bg-brand-darkest p-4 lg:hidden"
            x-ref="panel"
            x-show="searchOpen"
            @click.away="searchOpen = false"
            style="display: none"
        >
            <div class="flex items-center justify-between">
                <span class="w-10 flex-shrink-0 text-white">
                    <button
                        type="button"
                        @click="searchOpen = false"
                        class="_hover:bg-brand-accent grid place-content-center p-2"
                    >
                        <x-icons.caret-left />
                    </button>
                </span>
                <div class="flex flex-grow justify-center">
                    <livewire:components.global-search dropdownHeight="h-full" />
                </div>
                <span class="w-10 flex-shrink-0"></span>
            </div>
        </nav>
    </header>
</div>

