@props([
    'description' => null,
    'heading' => 'Nothing here yet',
])

<div {{ $attributes->class(['px-6 py-12']) }}>
    <div class="mx-auto grid max-w-lg justify-items-center text-center">
        <h4 class="text-base font-semibold leading-6 text-white">
            {{ $heading }}
        </h4>

        @if ($description)
            <p class="text-sm text-gray-400">
                {{ $description }}
            </p>
        @endif
    </div>
</div>
