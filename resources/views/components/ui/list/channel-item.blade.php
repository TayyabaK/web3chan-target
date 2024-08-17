@props([
    'title' => '/SolSoldiers',
    'slug' => 'sol-soldiers',
    'subTitle' => '1k followers',
    'subTitleAlt' => null,
    'imgSrc' => 'img/dummy-avatar-48x48.jpg',
])

<div {{ $attributes->merge(['class' => 'flex gap-2 rounded-lg p-2 hover:bg-brand-primary/50']) }}>
    <div class="z-[5] mr-4 flex-shrink-0">
        <img
            src="{{ asset($imgSrc) }}"
            class="size-12"
            alt=""
        />
    </div>

    <div>
        <h4 class="text-sm font-semibold text-white">{{ $slug }}</h4>
        <span class="text-sm text-brand-primary">{{ $subTitle }}</span>
    </div>
</div>
