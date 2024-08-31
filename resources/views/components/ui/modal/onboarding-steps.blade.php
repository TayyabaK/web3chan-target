<x-filament::modal
    x-init="$dispatch('open-modal', { id: 'onboarding-modal' })"
    id="onboarding-modal"
    width="md"
    class="btn-retro-lg"
    @close-modal.window="$dispatch('close-modal-callback', { id: 'onboarding-modal' })"
>
    <x-slot name="heading"></x-slot>

    <div class="text-left">
        <div class="flex justify-center">
            <img
                src="{{ asset('img/web3chan-logo.png') }}"
                alt=""
            />
        </div>

        <h1 class="mt-8 text-xl font-bold text-white sm:text-2xl">👋🏼 Welcome</h1>

        <p class="mt-4">Complete the following steps and earn 2500 tokens.</p>

        <div class="py-6">
            <hr class="border-brand-primary" />
        </div>

        <livewire:onboarding.steps />

        <div class="mt-8 grid">
            <x-ui.button
                x-data="phantomWalletComponent"
                label="Get Started"
                type="button"
                color="accent"
                size="lg"
                @click="connectWallet()"
            />
        </div>
    </div>
</x-filament::modal>
