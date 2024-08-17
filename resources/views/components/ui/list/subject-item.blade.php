@props([
    'title' => '#asvoria',
    'subTitle' => '1k followers',
])
<div {{ $attributes->merge(['class' => 'flex gap-2 rounded-lg p-2 hover:bg-brand-primary/50']) }}>
    <h4 class="text-sm font-semibold text-white">{{ $title }}</h4>
    <span class="text-sm text-brand-primary">{{ $subTitle }}</span>
</div>
