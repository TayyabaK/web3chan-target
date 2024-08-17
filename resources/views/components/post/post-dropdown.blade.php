@props([
    "availableHeight" => null,
    "availableWidth" => null,
    "maxHeight" => null,
    "offset" => 8,
    "placement" => "bottom-start",
    "shift" => false,
    "size" => false,
    "sizePadding" => 16,
    "teleport" => false,
    "trigger" => null,
    "width" => "xs",
    "heading" => null,
    "id" => null,
    "closeButton" => \Filament\Support\View\Components\Modal::$hasCloseButton,
    "openEventName" => "open-dropdown",
    "closeEventName" => "close-dropdown",
])

{{-- @note: This file could use cleanup but let's implement and see how it's used first. --}}

@php
    use Filament\Support\Enums\MaxWidth;

    $sizeConfig = collect([
        "availableHeight" => $availableHeight,
        "availableWidth" => $availableWidth,
        "padding" => $sizePadding,
    ])
        ->filter()
        ->toJson();

    $closeEventHandler = filled($id) ? '$dispatch(' . \Illuminate\Support\Js::from($closeEventName) . ", { id: " . \Illuminate\Support\Js::from($id) . " })" : "close()";
@endphp

<div
    x-data="{
        isOpen: false,

        toggle: function (event) {
            this.isOpen = ! this.isOpen
        },

        open: function (event) {
            this.isOpen = true

            console.log('open', event.detail)

            const OFFSET_X = 20
            const OFFSET_Y = 20

            this.$refs.panel.style.top = `${event.detail.cursor.top + OFFSET_Y}px`
            this.$refs.panel.style.left = `${event.detail.cursor.left + OFFSET_X}px`

            this.$refs.panel.dispatchEvent(
                new CustomEvent('dropdown-opened', { id: '{{ $id }}' }),
            )
        },

        close: function (event) {
            this.isOpen = false

            this.$refs.panel.dispatchEvent(
                new CustomEvent('dropdown-closed', { id: '{{ $id }}' }),
            )
        },
    }"
    @if ($id)
        x-on:{{ $closeEventName }}.window="if ($event.detail.id === '{{ $id }}') close($event)"
        x-on:{{ $openEventName }}.window="if ($event.detail.id === '{{ $id }}') open($event)"
    @endif
    {{ $attributes->class(["fi-dropdown"]) }}
>
    @if ($trigger)
        <div {{ $trigger->attributes }}>
            {{ $trigger }}
        </div>
    @endif

    <div
        x-cloak
        x-show="isOpen"
    >
        <div
            x-show="isOpen"
            x-float{{ $placement ? ".placement.{$placement}" : "" }}{{ $size ? ".size" : "" }}.flip{{ $shift ? ".shift" : "" }}{{ $teleport ? ".teleport" : "" }}{{ $offset ? ".offset" : "" }}="{ offset: {{ $offset }}, {{ $size ? "size: " . $sizeConfig : "" }} }"
            x-ref="panel"
            x-transition:enter-start="opacity-0"
            x-transition:leave-end="opacity-0"
            @if ($attributes->has("wire:key"))
                wire:ignore.self
                wire:key="{{ $attributes->get("wire:key") }}.panel"
            @endif
            @class([
                "fi-dropdown-panel btn-retro fixed z-10 w-screen divide-y divide-gray-100 bg-brand-secondary shadow-xl transition",
                match ($width) {
                    // These max width classes need to be `!important` otherwise they will be usurped by the Floating UI "size" middleware.
                    MaxWidth::ExtraSmall, "xs" => "!max-w-xs",
                    MaxWidth::Small, "sm" => "!max-w-sm",
                    MaxWidth::Medium, "md" => "!max-w-md",
                    null => "!max-w-[14rem]",
                    default => $width,
                },
                "overflow-y-auto" => $maxHeight || $size,
            ])
            @style([
                "max-height: {$maxHeight}" => $maxHeight,
            ])
        >
            <div class="px-6 pb-10 pt-6">
                @isset($heading)
                    <h2 class="text-2xl font-bold text-white">{{ $heading }}</h2>
                @endisset

                @if ($closeButton)
                    <div
                        @class([
                            "absolute",
                            "end-4 top-4",
                        ])
                    >
                        <x-filament::icon-button
                            color="gray"
                            icon="heroicon-o-x-mark"
                            icon-alias="modal.close-button"
                            icon-size="lg"
                            :label="__('filament::components/modal.actions.close.label')"
                            tabindex="-1"
                            :x-on:click="$closeEventHandler"
                            class="fi-modal-close-btn"
                        />
                    </div>
                @endif

                <div class="mt-4">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
