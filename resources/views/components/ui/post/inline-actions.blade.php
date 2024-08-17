@props([
    'post' => null,
])

<div>
    <div
        x-data="{ dropdownOpen: false }"
        class="relative"
    >
        <button
            id="hs-dropdown-custom-icon-trigger"
            type="button"
            class="hs-dropdown-toggle group flex size-7 items-center justify-center rounded-full bg-brand-secondary/40 text-sm font-semibold text-neutral shadow-sm hover:bg-brand-secondary disabled:pointer-events-none disabled:opacity-50"
            @click.prevent="$dispatch('hydrateCurrentPost', { postId: '{{ $post->id }}' })"
            @click="dropdownOpen=true"
        >
            <svg
                class="size-5 flex-none rotate-90 fill-black text-brand-primary"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle
                    class="text-brand-primary/80 group-hover:text-brand-accent"
                    cx="12"
                    cy="12"
                    r="1"
                />
                <circle
                    class="text-brand-primary/80 group-hover:text-brand-accent"
                    cx="12"
                    cy="5"
                    r="1"
                />
                <circle
                    class="text-brand-primary/80 group-hover:text-brand-accent"
                    cx="12"
                    cy="19"
                    r="1"
                />
            </svg>
        </button>
        <div
            x-show="dropdownOpen"
            @click.away="dropdownOpen=false"
            x-transition:enter="duration-200 ease-out"
            x-transition:enter-start="-translate-y-2"
            x-transition:enter-end="translate-y-0"
            class="absolute left-1/2 top-0 z-50 mt-10 w-56 -translate-x-full"
            x-cloak
        >
            <div
                class="duration btn-retro z-50 min-w-60 border-0 bg-brand-secondary p-2"
                aria-labelledby="hs-dropdown-custom-icon-trigger"
            >
                <x-ui.post.inline-action-item
                    label="Delete"
                    icon="trash"
                    @click="$dispatch('showDeletePostModal')"
                />

                <x-ui.post.inline-action-item
                    :label="$post->is_pinned ? 'Unpin from profile' : 'Pin to profile'"
                    icon="pin"
                    wire:click="togglePin"
                />

                @if ($this->channel ?? false)
                    <x-ui.post.inline-action-item
                        :label="$post->is_highlighted ? 'Remove from highlight' : 'Add to highlight'"
                        icon="pin"
                        wire:click="toggleHighlight"
                    />
                @endif
            </div>
        </div>
    </div>

    <div class="hs-dropdown relative z-[999] inline-flex [--placement:bottom-right]">
        <div
            class="hs-dropdown-menu duration btn-retro z-50 hidden min-w-60 border-0 bg-brand-secondary p-2 opacity-0 transition-[opacity,margin] hs-dropdown-open:opacity-100"
            aria-labelledby="hs-dropdown-custom-icon-trigger"
        >
            <x-ui.post.inline-action-item
                label="Delete"
                icon="trash"
                @click="$dispatch('showDeletePostModal')"
            />

            <x-ui.post.inline-action-item
                :label="$post->is_pinned ? 'Unpin from profile' : 'Pin to profile'"
                icon="pin"
                wire:click="togglePin"
            />

            @if ($this->channel ?? false)
                <x-ui.post.inline-action-item
                    :label="$post->is_highlighted ? 'Remove from highlight' : 'Add to highlight'"
                    icon="pin"
                    wire:click="toggleHighlight"
                />
            @endif
        </div>
    </div>
</div>
