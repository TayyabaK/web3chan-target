@props([
    'mode' => 'post',
    'withDefaultSelector' => false,
])

<div class="space-y-6">
    @if ($withDefaultSelector)
        <div
            x-data="initBannerSelector"
            data-hs-carousel='{"loadingClasses": "opacity-0"}'
            class="relative"
            wire:ignore
        >
            <div class="hs-carousel relative h-48 w-full overflow-hidden rounded-lg bg-white">
                <div
                    class="hs-carousel-body absolute bottom-0 start-0 top-0 flex flex-nowrap opacity-0 transition-transform duration-700"
                >
                    <template
                        x-for="banner in bannerItems"
                        :key="banner.id"
                    >
                        <div class="hs-carousel-slide">
                            <div class="relative flex h-full justify-center">
                                <button
                                    type="button"
                                    @click="selectBanner(banner.url)"
                                    class="absolute inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hover:bg-opacity-0"
                                >
                                    <svg
                                        class="h-6 w-6 text-white"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M10 18a1 1 0 01-.707-.293l-6-6a1 1 0 111.414-1.414L10 15.586l5.293-5.293a1 1 0 111.414 1.414l-6 6A1 1 0 0110 18z"
                                        ></path>
                                    </svg>
                                </button>
                                <img
                                    class="h-full w-full object-cover"
                                    :src="banner.url"
                                    alt="Image"
                                />
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <button
                type="button"
                class="hs-carousel-prev hs-carousel:disabled:opacity-50 absolute inset-y-0 start-0 inline-flex h-full w-[46px] items-center justify-center rounded-s-lg text-gray-800 hover:bg-gray-800/10 disabled:pointer-events-none"
            >
                <span
                    class="text-2xl"
                    aria-hidden="true"
                >
                    <svg
                        class="size-5 flex-shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="m15 18-6-6 6-6"></path>
                    </svg>
                </span>
                <span class="sr-only">Previous</span>
            </button>
            <button
                type="button"
                class="hs-carousel-next hs-carousel:disabled:opacity-50 absolute inset-y-0 end-0 inline-flex h-full w-[46px] items-center justify-center rounded-e-lg text-gray-800 hover:bg-gray-800/10 disabled:pointer-events-none"
            >
                <span class="sr-only">Next</span>
                <span
                    class="text-2xl"
                    aria-hidden="true"
                >
                    <svg
                        class="size-5 flex-shrink-0"
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </span>
            </button>

            <div
                class="hs-carousel-pagination pointer-events-none absolute bottom-3 end-0 start-0 flex justify-center space-x-2"
            >
                <template
                    x-for="banner in bannerItems"
                    :key="banner.id"
                >
                    <span
                        class="pointer-events-auto size-3 cursor-pointer rounded-full border border-gray-400 hs-carousel-active:border-blue-700 hs-carousel-active:bg-blue-700"
                    ></span>
                </template>
            </div>
        </div>

        @script
            <script>
                Alpine.data('initBannerSelector', () => ({
                    selectedBanner: $wire.entangle('selectedBanner').live,
                    bannerItems: [
                        {
                            id: 1,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner1.webp',
                        },
                        {
                            id: 2,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner2.webp',
                        },
                        {
                            id: 3,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner3.webp',
                        },
                        {
                            id: 4,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner4.webp',
                        },
                        {
                            id: 5,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner5.webp',
                        },
                        {
                            id: 6,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner6.webp',
                        },
                        {
                            id: 7,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner7.webp',
                        },
                        {
                            id: 8,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner8.webp',
                        },
                        {
                            id: 9,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner9.webp',
                        },
                        {
                            id: 10,
                            type: 'image',
                            url: 'https://web3chan-bucket.s3.eu-west-3.amazonaws.com/banners/banner10.webp',
                        },
                    ],
                    init() {
                        this.$nextTick(() => {
                            setTimeout(() => {
                                window.HSStaticMethods.autoInit(['carousel']);
                            }, 0);
                        });
                    },
                    selectBanner(bannerUrl) {
                        $dispatch('close-modal', { id: 'edit-banner-modal' });
                        this.selectedBanner = bannerUrl;
                    },
                }));
            </script>
        @endscript
    @endif

    <form
        class="flex w-full items-center justify-center"
        wire:submit="save"
    >
        <label
            class="relative flex h-48 w-full cursor-pointer flex-col items-center justify-center overflow-hidden rounded-lg border-2 border-dashed border-brand-primary bg-brand-secondary"
        >
            <input
                wire:model="bannerUpload"
                type="file"
                class="hidden"
            />

            @error('bannerUpload')
                <span class="error">{{ $message }}</span>
            @enderror

            @unless ($this->bannerUpload)
                <div class="flex flex-col items-center justify-center pb-6 pt-5">
                    <svg
                        class="mb-4 h-8 w-8 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 16"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
                        ></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="font-semibold">Click to upload</span>
                        or drag and drop
                    </p>
                </div>
            @else
                <img
                    class="h-full w-full object-cover"
                    src="{{ $this->bannerUpload->temporaryUrl() }}"
                    alt="Banner"
                />
                <x-ui.button
                    type="submit"
                    class="absolute bottom-2 w-[98%]"
                    label="Upload Banner"
                    color="primary"
                    size="sm"
                    @click="$dispatch('close-modal', { id: 'edit-banner-modal' })"
                />
            @endunless
        </label>
    </form>
</div>
