<div>
    @if ($this->showModal)
        <x-filament::modal
            id="tip-modal"
            x-init="$dispatch('open-modal', { id: 'tip-modal' })"
            width="lg"
        >
            <x-ui.tip-modal />
        </x-filament::modal>
    @endif
</div>
