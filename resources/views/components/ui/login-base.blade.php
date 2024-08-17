@props([
    'heading',
    'showBreadcrumbs' => true,
])

<x-ui.page>
    <div class="bg-brand-darkest">
        <div class="relative flex min-h-screen flex-col items-center">
            <div class="relative w-full max-w-2xl md:px-6 lg:max-w-7xl">
                <main
                    id="content"
                    class="relative mx-auto flex size-full max-w-5xl flex-col justify-center px-4 sm:items-center sm:px-6 lg:px-8"
                >
                    <div class="px-4 py-8 sm:px-6 lg:px-8">
                        {{-- @note: we may need this so leaving it in but hidden for now --}}
                        <div class="hidden text-center">
                            <div class="flex justify-center">
                                <img
                                    class="block w-[134px]"
                                    src="{{ asset('img/web3chan-logo.png') }}"
                                    alt="Web3chan logo"
                                />
                            </div>
                        </div>

                        <div class="btn-retro bg-brand-secondary mt-20 p-12 lg:p-28">
                            {{-- @todo: Spacer element. Not figured out yet why it's even needed --}}
                            <div class="w-96"></div>
                            @if ($showBreadcrumbs)
                                <x-ui.breadcrumbs>
                                    <x-ui.breadcrumbs.breadcrumb-item :hasCaret="true">
                                        Wallet
                                    </x-ui.breadcrumbs.breadcrumb-item>
                                    <x-ui.breadcrumbs.breadcrumb-item :isHighlighted="true">
                                        @NikoDJ
                                    </x-ui.breadcrumbs.breadcrumb-item>
                                </x-ui.breadcrumbs>
                            @endif

                            @isset($heading)
                                <h1 class="mt-8 text-center text-2xl font-bold text-white sm:px-6 sm:text-3xl">
                                    {{ $heading }}
                                </h1>
                            @endisset

                            @isset($headingAlternative)
                                {{ $headingAlternative }}
                            @endisset

                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-ui.page>
