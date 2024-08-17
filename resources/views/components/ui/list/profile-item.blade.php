@props([
    'title' => '@NikoDJ',
    'slug' => 'NikoDJ',
    'subTitle' => '1k followers',
    'imgSrc' => 'img/dummy-avatar-48x48.jpg',
])
<div {{ $attributes->merge(['class' => 'flex gap-2 rounded-lg p-2 hover:bg-brand-primary/50']) }}>
    <div class="z-[5] mr-4 flex-shrink-0">
        <img
            src="{{ asset($imgSrc) }}"
            class="h-12 w-12"
            alt=""
        />
    </div>

    <div>
        <h4 class="text-sm font-semibold text-white">{{ $slug }}</h4>
        <span class="text-sm text-brand-primary">{{ $subTitle }}</span>
    </div>
</div>
