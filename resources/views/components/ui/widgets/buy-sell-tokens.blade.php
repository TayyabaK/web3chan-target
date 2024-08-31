@props([
    'href' => null,
    'price' => '$150.00',
    'amount' => '103',
    'percentage' => '+12.00%',
])

<x-ui.list.container
    :hasBackground="true"
    spacingY="4"
>
    <div
        x-data="phantomWalletComponent"
        x-init="init()"
    >
        <div class="flex justify-between gap-x-6">
            <div class="flex min-w-0 gap-x-4">
                <img
                    class="size-12 flex-none"
                    src="{{ asset('img/web3chan-3-logo.png') }}"
                    alt=""
                />
                <div class="min-w-0 flex-auto">
                    <p class="text-sm font-bold leading-6">Web3Chan</p>
                    <p
                        class="mt-1 truncate text-lg font-bold leading-4 text-white"
                        x-show="balance > 0"
                    >
                        <span x-text="balance"></span>
                        3CHAN
                    </p>
                </div>
            </div>
            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <p class="text-sm leading-6">{{ $price }}</p>
                <p class="mt-1 text-sm leading-5 text-green-500">{{ $percentage }}</p>
            </div>
        </div>

        <div class="mt-4 space-y-4">
            <x-ui.button
                x-effect="$el.textContent = walletAddress ? (walletAddress.substring(0, 4) + '...' + walletAddress.substring(walletAddress.length - 4)) : 'Connect'"
                color="accent"
                size="lg"
                :fullWidth="true"
                @click="connectWallet()"
            />
        </div>
    </div>
</x-ui.list.container>
