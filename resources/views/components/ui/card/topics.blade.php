@props([
    'topic' => null,
    'routeName' => null,
    'routeParams' => null,
    'imgSrc' => null,
])

<a
    href="{{ isset($routeName) ? route($routeName, $routeParams) : null }}"
    wire:navigate
>
    <div class="relative">
         <div class="absolute bottom-2 left-2 bg-brand-primary px-1 text-sm font-bold text-white">
             #{{ $topic->name }}
         </div>

        @if (filled($imgSrc))
            <div>
                <img
                    src="{{ asset($imgSrc) }}"
                    alt="Topic Image"
                    class="aspect-square object-cover"
                />
            </div>
        @endif
    </div>
</a>
