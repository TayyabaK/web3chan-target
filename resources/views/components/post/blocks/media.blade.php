@props(['media' => null, 'mode' => null])

@if ($media)
    <!-- Delete action -->
    @if ($mode === 'editor')
        <div class="absolute right-0 top-0 z-50 mr-8 mt-8">
            <button
                type="button"
                wire:click="deleteMedia"
                class="flex items-center gap-2 rounded-full bg-black/20 p-3 text-xs text-white hover:opacity-50"
            >
                <x-bx-trash class="w-4 fill-white" />
            </button>
        </div>
    @endif

    @if ($media['type'] === 'video')
        <div class="p-4">
            <video
                class="h-full w-full object-cover"
                src="{{ $media['url'] }}"
                playsinline
                autoplay
                loop
                muted
                controls
            ></video>
        </div>
    @else
        <div class="p-4">
            <img
                class="h-full w-full object-cover"
                src="{{ $media['url'] }}"
                alt="image"
            />
        </div>
    @endif
@endif
