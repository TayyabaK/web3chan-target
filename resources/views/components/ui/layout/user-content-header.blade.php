@props([
    'showInformation' => true,
    'editable' => false,
    'name' => auth()->user()->name??'NikoDJ',
    'userName' => str(auth()->user()->username)->prepend('@')??'@NikoDJ',
    'userBio' => auth()->user()->profile->bio??'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
    'headerImageSrc' => 'img/dummy-myprofile-header.jpg',
    'avatarImageSrc' => auth()->user()->image??'https://ui-avatars.com/api/?background=8125ff&color=fff&name='.str($userName)->replace(' ',
    '+'),
    'avatarBorderColor' => 'border-black',
    'bioLengthCutoff' => 120,
])

<div class="flex-center gap-6 _lg:mt-12">
    <x-ui.breadcrumbs hrefBack="{{ route('home') }}">
        @isset($userName)
            <x-ui.breadcrumbs.breadcrumb-item>{{ $userName }}</x-ui.breadcrumbs.breadcrumb-item>
        @endisset
    </x-ui.breadcrumbs>
</div>

<div class="my-6 lg:px-4">
    <div class="group relative h-32 flex-shrink-0 overflow-hidden lg:h-48">
        <div>
            @if ($editable)
                <button
                    class="absolute inset-y-0 right-0 z-50 flex w-12 items-center justify-center opacity-0 transition-all duration-500 group-hover:bg-brand-primary/40 group-hover:opacity-100"
                    @click="$dispatch('open-modal', { id: 'edit-banner-modal' })"
                >
                    <x-icons.edit class="size-6 fill-white hover:animate-pulse hover:fill-white" />
                </button>
            @endif
        </div>

        <img
            src="{{ asset($headerImageSrc) }}"
            class="w-full object-cover object-center"
        />
    </div>

    <div class="z-10 -mt-16 ml-6 flex flex-col items-center lg:-mt-8 lg:flex-row">
        <div class="group relative aspect-square size-24 transform transition-all duration-700">
            <div>
                @if ($editable)
                    <button
                        class="absolute inset-0 flex items-center justify-center bg-brand-primary/20 opacity-0 transition-all duration-500 group-hover:bg-brand-secondary/50 group-hover:opacity-100"
                        @click="$dispatch('open-modal', { id: 'profile-edit-avatar-modal' })"
                    >
                        <x-icons.edit class="size-6 fill-white" />
                    </button>
                @endif
            </div>

{{--  @TODO Needs implementation for users only          --}}
{{--            @if ($this->user->isOnline())--}}
{{--                <span--}}
{{--                    class="absolute bottom-0 right-0 z-10 size-[11px] border-2 border-brand-darkest bg-accent-green"--}}
{{--                ></span>--}}
{{--            @endif--}}

            <img
                src="{!! asset($avatarImageSrc) !!}"
                class="{{ $avatarBorderColor }} aspect-square size-24 border-2 object-cover"
            />
        </div>

        <div class="flex items-center lg:flex-grow lg:items-end lg:justify-between">
            @if ($showInformation)
                <div class="lg:ml-4 lg:mt-8">
                    <div class="mt-4 flex items-center space-x-2">
                        <p class="text-xl font-bold text-white">{{ $name }}</p>
                    </div>

                    @isset($userName)
                        <p class="text-sm text-brand-accent">{{ $userName }}</p>
                    @endisset
                </div>
            @endif

            <div class="hidden lg:flex lg:gap-2">
                @isset($actionButtons)
                    {{ $actionButtons }}
                @endisset
            </div>
        </div>
    </div>

    @if ($showInformation)
        @isset($stats)
            <div
                class="relative ml-6 mt-2 flex items-center justify-center gap-4 text-center text-neutral lg:hidden lg:justify-start lg:gap-16 lg:text-left"
            >
                {{ $stats }}
            </div>

            <div class="ml-6 mt-4 hidden lg:inline-flex">
                {{ $stats }}
            </div>
        @endisset

        @isset($actionButtons)
            <div class="mt-2 flex justify-center gap-4 px-4 lg:hidden lg:px-6">
                {{ $actionButtons }}
            </div>
        @endisset

        <div
            x-cloak
            @if (str($userBio)->length() > $bioLengthCutoff) x-data="{ less: true }" @endif
            class="ml-6"
        >
            <div
                class="mt-4 overflow-hidden px-2 text-center text-sm lg:px-0 lg:text-left"
                @if (str($userBio)->length() > $bioLengthCutoff) :class="less ? 'line-clamp-1' : ''" @endif
            >
                {{ $userBio }}
            </div>

            @if (str($userBio)->length() > $bioLengthCutoff)
                <div class="text-center lg:text-left">
                    <button
                        class="text-sm text-brand-accent underline underline-offset-4"
                        x-on:click.prevent="less = !less"
                        x-text="less ? 'More info' : 'Close more info'"
                    ></button>
                </div>
            @endif
        </div>

        @isset($navTabs)
            {{ $navTabs }}
        @endisset
    @endif
</div>
