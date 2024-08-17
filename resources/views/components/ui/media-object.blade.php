@props([
    'heading' => 'HEADING',
    'subHeading' => 'SUBHEADING',
    'subHeadingColor' => 'text-brand-primary',
    'viewButtonLink' => null,
    'href' => null,
    'alignImage' => 'center',
    'imageGap' => '4',
])

<div class="mt-2 flex items-center justify-between">
    @isset($href)
        <a href="{{ $href }}" wire:navigate>
    @endif

    <div class="flex {{ $alignImage == 'center' ? 'items-center' : null }} gap-2">
        <div class="mr-{{ $imageGap }} flex-shrink-0 {{ $alignImage == 'center' ? 'self-center' : null }}">
            @isset($image)
                {{ $image }}
            @else
                <svg
                    class="h-10 w-10 border border-gray-300 bg-white text-gray-300"
                    preserveAspectRatio="none"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 200 200"
                    aria-hidden="true"
                >
                    <path
                        vector-effect="non-scaling-stroke"
                        stroke-width="1"
                        d="M0 0l200 200M0 200L200 0"
                    />
                </svg>
            @endisset
        </div>

        <div>
            <h4 class="text-sm font-semibold text-white truncate max-w-40">{{ $heading }}</h4>
            @isset($subHeading)
                <p class="text-sm {{ $subHeadingColor }}">{{ $subHeading }}</p>
            @endisset
        </div>
    </div>
    @isset($href)
        </a>
    @endif

    {{ $actionButtons ?? '' }}

    @isset($viewButtonLink)
        <span class="w-24">
            <x-ui.button
                href="{{ $viewButtonLink }}"
                color="accent"
                label="View"
                size="sm"
                :fullWidth="true"
            />
        </span>
    @endisset
</div>
