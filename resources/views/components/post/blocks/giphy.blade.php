@props(['giphy' => null, 'mode' => null])

@if ($giphy)
    <!-- Delete action -->
    @if ($mode === 'editor')
        <div class="absolute right-0 top-0 z-50 mr-8 mt-8">
            <button
                type="button"
                wire:click="deleteGiphy"
                class="flex items-center gap-2 rounded-full bg-black/20 p-3 text-xs text-white hover:opacity-50"
            >
                <x-bx-trash class="w-4 fill-white" />
            </button>
        </div>
    @endif

    <div class="p-4">
        <img
            class="h-full w-full object-cover"
            src="{{ route('external-media', ['url' => $giphy]) }}"
            alt="Giphy"
        />
    </div>
@endif
