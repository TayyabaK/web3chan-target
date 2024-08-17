<div class="hidden md:block">
    <span class="hidden text-white sm:block">Create a Chant</span>

    <div class="mt-4 bg-brand-secondary p-[0.15rem]">
        <div class="relative mx-[0.225rem] bg-brand-darkest text-xs text-white">
            <div>
                <div
                    class="absolute right-0 top-0 mr-2 mt-2 hidden pb-2 text-right text-xs text-brand-primary sm:block"
                >
                    (redirect /channel)
                </div>

                <div
                    name="trigger"
                    @click="$dispatch('open-modal', { id: 'post-modal' })"
                >
                    <div class="group flex min-h-12 items-center">
                        <div
                            class="ms-4 block w-full cursor-pointer font-semibold text-neutral/50 group-hover:text-neutral"
                        >
                            Anything new to share?
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden md:block">
            <livewire:components.post-actions />
        </div>
    </div>
</div>
