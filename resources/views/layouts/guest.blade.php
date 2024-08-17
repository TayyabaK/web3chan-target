<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="min-h-full"
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

        @livewireStyles
        @vite('resources/css/app.css')
        @filamentStyles
        @stack('styles')
    </head>

    <body
        style="background-image: url({{ asset('img/guest-bg.jpg') }})"
        class="min-h-full overflow-x-hidden overscroll-none bg-center bg-no-repeat font-sans text-gray-900 antialiased"
        :class="{
        'overflow-hidden': accountOpen,
    }"
        x-data="{
            accountOpen: false,
        }"
    >
        {{ $slot }}
        @livewireScriptConfig
        @vite('resources/js/app.ts')
        @filamentScripts
        @stack('scripts')
    </body>
</html>
