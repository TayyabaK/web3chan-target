<x-ui.list.container
    heading="Bookmark Folders"
    :hasPadding="false"
    class="py-6"
>
    @foreach ($this->bookmarkFolders as $bookmarkFolder)
        <a
            href="{{ $bookmarkFolder['route'] }}"
            wire:navigate
            @class([
                'flex items-center gap-3 pl-4 font-bold text-white',
                'bg-brand-secondary' => $bookmarkFolder['active'],
            ])
        >
            <div class="size-6">
                <x-dynamic-component
                    component="icons.bookmark"
                    @class([
                        'w-5',
                        'group-hover:fill-white fill-neutral stroke-black stroke-2',
                        '!fill-brand-accent' => $bookmarkFolder['active'],
                    ])
                />
            </div>
            <span class="text-white">{{ $bookmarkFolder['label'] }}</span>
        </a>
    @endforeach
</x-ui.list.container>
