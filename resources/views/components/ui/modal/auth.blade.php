<x-filament::modal
    x-init="$dispatch('open-modal', { id: 'authModal' })"
    id="authModal"
    :closeByClickingAway="false"
    :closeByEscaping="false"
    width="2xl"
    class="btn-retro-lg"
>
    @isset($breadcrumbs)
        {{ $breadcrumbs }}
    @endisset

    <div class="lg:p-12">
        @isset($heading)
            <h1 class="text-center text-2xl font-bold text-white sm:px-6 sm:text-3xl">
                {{ $heading }}
            </h1>
        @endisset

        @isset($headingAlternative)
            <h4 class="leading-loose">{{ $headingAlternative }}</h4>
        @endisset

        {{ $slot }}
    </div>
</x-filament::modal>
