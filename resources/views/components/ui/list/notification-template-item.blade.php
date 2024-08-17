@props([
    'isActive' => false,
    'isUserOnline' => false,
])

<div
    {{ $attributes }}
    @class(['group relative flex gap-2 p-2 hover:bg-brand-secondary lg:p-4', 'bg-brand-secondary' => $isActive])
    :class="{'border-l-2 border-brand-accent': ! item.read}"
>
    <div class="flex-shrink-0">
        <div class="z-[5] mr-2 flex-shrink-0">
            <img
                x-bind:src="item.profile_image"
                class="size-12"
                alt=""
            />
        </div>
    </div>

    <div class="flex-grow">
        <a
            x-bind:href="item.url"
            wire:click="$dispatch('clickNotification', [item.id])"
            wire:navigate
        >
            <div class="flex flex-col">
                <span
                    class="block text-white"
                    x-text="item.user_name"
                ></span>

                <p
                    @class([
                        'line-clamp-1 pr-10 text-sm',
                        'text-white' => $isUserOnline,
                    ])
                    x-text="item.content"
                ></p>

                <span
                    @class([
                        'block text-xs',
                        'text-brand-accent' => $isUserOnline,
                    ])
                    x-text="item.date"
                ></span>
            </div>
        </a>
    </div>

    <div class="items-right flex flex-shrink-0 flex-col items-end gap-2">
        @if ($isUserOnline)
            <span class="size-3 rounded-full bg-brand-accent"></span>
        @endif

        <span
            class="rounded-full bg-brand-secondary px-2 py-1 text-xs text-brand-primary"
            x-text="item.type"
        ></span>

        <div class="hs-dropdown z-1 relative inline-flex [--placement:bottom-right]">
            <button
                id="hs-dropdown-default"
                type="button"
                class="hs-dropdown-toggle group grid h-8 place-content-center bg-black p-2 text-white hs-dropdown-open:bg-brand-primary"
            >
                <x-icons.dots />
            </button>

            <div
                class="hs-dropdown-menu duration z-50 mt-2 hidden min-w-60 space-y-2 rounded-lg bg-brand-secondary p-2 opacity-0 shadow-md transition-[opacity,margin] before:absolute before:-top-4 before:start-0 before:h-4 before:w-full after:absolute after:-bottom-4 after:start-0 after:h-4 after:w-full hs-dropdown-open:opacity-100"
                aria-labelledby="hs-dropdown-default"
            >
                <span class="text-sm text-white">Username</span>
                <x-filament::button
                    tag="a"
                    size="lg"
                    href="{{ route('profile', auth()->user()) }}"
                    class="dropdown-item btn-retro inline-block w-full items-center gap-x-3.5 rounded-lg bg-brand-primary/20 text-center text-sm text-gray-200 hover:bg-brand-primary focus:bg-gray-100 focus:outline-none"
                    wire:navigate
                >
                    @lang('Go to user profile')
                </x-filament::button>
                <x-filament::button
                    size="lg"
                    class="dropdown-item btn-retro inline-block w-full items-center gap-x-3.5 rounded-lg bg-brand-primary/20 text-center text-sm text-gray-200 hover:bg-brand-primary focus:bg-gray-100 focus:outline-none"
                    type="button"
                >
                    @lang('Archive')
                </x-filament::button>
            </div>
        </div>
    </div>
</div>
