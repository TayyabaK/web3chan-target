@props([
    'userName' => 'Username',
    'textPreview' => null,
    'datePosted' => null,
    'href' => null,
    'imgSrc' => null,
    'isActive' => false,
    'isUserOnline' => false,
])

@isset($href)<a href="{{ $href }}" wire:navigate>@endisset
    <div @class(['relative flex gap-2 p-2 lg:p-4 group hover:bg-brand-secondary', 'bg-brand-secondary' => $isActive])>
        @if ($isUserOnline)
            <span class="absolute right-0 top-0 mr-2 mt-2 size-3 rounded-full bg-brand-accent"></span>
        @endif

        <button x-on:click="archiveModalOpen = true" class="absolute bottom-0 right-0 mb-2 mr-2 grid h-8 place-content-center bg-black p-2 text-white hidden">
            <x-icons.dots />
        </button>

        <div class="z-[5] mr-2 flex-shrink-0">
            <img
                src="{{ asset($imgSrc) }}"
                class="size-12"
                alt=""
            />
        </div>

        <div>
            <span class="block text-white">{{ $userName }}</span>

            <p @class([
                'line-clamp-2 pr-10 text-sm',
                'text-white' => $isUserOnline,
            ])>
                {{ $textPreview }}
            </p>

            <span @class([
                'block text-xs',
                'text-brand-accent' => $isUserOnline,
            ])>
                {{ $datePosted }}
            </span>
        </div>
    </div>
@isset($href)</a>@endisset
