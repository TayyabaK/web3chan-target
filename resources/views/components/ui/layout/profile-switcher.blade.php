@props([
    'userName' => auth()->user()->username??'@NikoDJ',
    'imgSrc' => auth()->user()->getAvatar(),
    'itemCount' => session('user-tokens-total',
    '1250'),
])

<div class="flex-center-between">
    <div class="flex-center gap-4">
        <span class="font-bold text-white">{{ $itemCount }}</span>

        <img
            src="{{ asset('img/web3chan-3-logo.png') }}"
            alt=""
        />

        <x-ui.divider-vertical />

        <div class="hs-dropdown relative z-50 inline-flex [--placement:bottom-right]">
            <button
                id="hs-dropdown-default"
                type="button"
                class="hs-dropdown-toggle group inline-flex items-center gap-x-4 px-4 py-3 text-base font-semibold text-white"
            >
                <img
                    src="{{ asset($imgSrc) }}"
                    alt=""
                    class="w-10 ring-1 ring-offset-0 ring-offset-brand-accent group-hover:ring-offset-1"
                />
                {{ $userName }}
                <svg
                    class="size-4 hs-dropdown-open:rotate-180"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </button>

            <div
                class="hs-dropdown-menu duration mt-2 hidden min-w-60 space-y-2 rounded-lg bg-brand-secondary p-2 opacity-0 shadow-md transition-[opacity,margin] before:absolute before:-top-4 before:start-0 before:h-4 before:w-full after:absolute after:-bottom-4 after:start-0 after:h-4 after:w-full hs-dropdown-open:opacity-100"
                aria-labelledby="hs-dropdown-default"
            >
                <a
                    href="{{ route('profile', auth()->user()) }}"
                    class="dropdown-item inline-block w-full items-center gap-x-3.5 rounded-lg bg-brand-primary/20 px-3 py-2 text-sm text-gray-200 hover:bg-brand-primary focus:bg-gray-100 focus:outline-none"
                    wire:navigate
                >
                    @lang('My Profile')
                </a>
                <button
                    class="dropdown-item inline-block w-full items-center gap-x-3.5 rounded-lg bg-brand-primary/20 px-3 py-2 text-left text-sm text-gray-200 hover:bg-brand-primary focus:bg-gray-100 focus:outline-none"
                    x-on:click.prevent="$refs.logoutForm.submit()"
                    type="button"
                >
                    @lang('Logout')
                </button>

                <form
                    x-ref="logoutForm"
                    action="{{ route('logout') }}"
                    method="POST"
                >
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
