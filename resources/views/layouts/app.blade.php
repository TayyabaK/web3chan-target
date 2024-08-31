<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="min-h-full"
    data-theme="web3chan"
>
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1"
        />
        <meta
            name="csrf-token"
            content="{{ csrf_token() }}"
        />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link
            rel="preconnect"
            href="https://fonts.bunny.net"
        />
        <link
            href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap"
            rel="stylesheet"
        />
        <script src="https://cdn.jsdelivr.net/npm/livewire-v2"></script>


        @livewireStyles
        @vite('resources/css/app.css')
        @filamentStyles
        @stack('styles')
    </head>

    <body
        class="min-h-screen overflow-x-hidden overscroll-none font-sans text-gray-900 antialiased"
        :class="{
        'overflow-hidden': mainNavOpen || accountOpen || searchOpen
    }"
        x-data="{
            mainNavOpen: false,
            searchOpen: false,
            accountOpen: false,
            archiveModalOpen: false,
            focus: false,
        }"
    >
        {{ $slot }}
        @livewireScriptConfig
        @vite('resources/js/app.ts')
        @filamentScripts
        @filepondScripts
        @stack('scripts')

        @auth
            @if (! session()->has('onboarding-modal'))
                <x-ui.modal.onboarding-steps />
            @endif
        @endauth

        <x-mary-toast />
    </body>
</html>
