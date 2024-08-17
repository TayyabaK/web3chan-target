<div class="dark h-full">
    {{ $slot }}
    @guest
        <div class="fixed bottom-0 z-50 mb-0 w-full pt-20">
            <x-ui.layout.offline-marketing />
        </div>
    @endguest
</div>
