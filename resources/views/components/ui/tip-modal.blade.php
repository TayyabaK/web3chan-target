@props([
    'href' => null,
    'price' => '$150.00',
    'amount' => '100.00',
    'percentage' => '+12.00%',
])

<x-ui.list.container>
    <div>
        <div class="flex justify-between gap-x-6">
            <div class="flex min-w-0 gap-x-4">
                <img
                    class="size-12 flex-none"
                    src="{{ asset('img/web3chan-3-logo.png') }}"
                    alt=""
                />
                <div class="min-w-0 flex-auto text-left">
                    <p class="text-sm font-bold leading-6">Web3Chan</p>
                    <p class="mt-1 truncate text-lg font-bold leading-4 text-white">{{ $amount }} 3CHAN</p>
                </div>
            </div>
            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <p class="text-sm leading-6">{{ $price }}</p>
                <p class="mt-1 text-sm leading-5 text-green-500">{{ $percentage }}</p>
            </div>
        </div>

        <form
            id="tipAmountForm"
            wire:submit="tip"
        >
            <input
                type="hidden"
                name="userId"
                value="{{ $this->userId }}"
            />
            <div class="mt-4 space-y-4">
                <x-mary-input
                    label="Default money"
                    wire:model="amount"
                    prefix="3CHAN"
                    type="number"
                    inline
                    class="w-full border-brand-primary bg-brand-secondary p-3 text-center text-lg text-brand-primary"
                />

                <x-ui.button
                    type="submit"
                    label="Tip"
                    color="accent"
                    size="lg"
                    :fullWidth="true"
                />
            </div>
        </form>
    </div>
</x-ui.list.container>
