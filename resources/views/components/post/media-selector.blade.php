@props(['mode' => 'post'])

<div x-data="initMediaGrid">
    <div
        id="grid"
        class="mt-4 grid max-h-96 grid-cols-3 gap-1 overflow-x-auto"
    >
        <template
            x-for="(media, key) in mediaItems"
            :key="key"
        >
            <div class="relative h-40 w-full bg-gray-100">
                <button
                    type="button"
                    @click="selectMedia(media)"
                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 hover:bg-opacity-0"
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
                        />
                    </svg>
                </button>
                <img
                    x-show="media.type === 'image'"
                    class="h-full w-full object-cover"
                    :src="media.url"
                    alt="Image"
                />
                <video
                    x-show="media.type === 'video'"
                    class="pointer-events-none h-full w-full object-cover"
                    :src="media.url"
                    playsinline
                    autoplay
                    loop
                    muted
                />
            </div>
        </template>
    </div>

    @script
        <script>
            Alpine.data('initMediaGrid', () => ({
                parentModal: @js($mode) + '-modal',
                selectedMedia: $wire.entangle('selectedMedia').live,
                mediaItems: [
                    {
                        type: 'image',
                        url: 'https://fastly.picsum.photos/id/1037/600/400.jpg?hmac=E7oV9MlYzBUFFygTj04kbdysY_Yu8n2jqR9o-hXekyU',
                    },
                    {
                        type: 'image',
                        url: 'https://fastly.picsum.photos/id/638/600/400.jpg?hmac=8VrBDjauAXP1SKQLTJROxss4oSvNdclueX9HtzD739U',
                    },
                    {
                        type: 'image',
                        url: 'https://fastly.picsum.photos/id/701/600/400.jpg?hmac=JL-FnBwl5mr0M13Xus0vj6sufNiRo9P-Wm3pp6H_nTs',
                    },
                    {
                        type: 'video',
                        url: 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4',
                    },
                    {
                        type: 'image',
                        url: 'https://fastly.picsum.photos/id/546/600/400.jpg?hmac=DihO_j-eFueKyqEievwZ3-je4TfIFY3mQF1YiEANknk',
                    },
                    {
                        type: 'video',
                        url: 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4',
                    },
                    {
                        type: 'image',
                        url: 'https://fastly.picsum.photos/id/524/600/400.jpg?hmac=dHi4SzGwI6OXIEY7vXNpt6ohHGoDaZevHE0lBuB85xU',
                    },
                    {
                        type: 'video',
                        url: 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerFun.mp4',
                    },
                    {
                        type: 'image',
                        url: 'https://fastly.picsum.photos/id/549/600/400.jpg?hmac=Gh6Z6E0cjQrKlCHA9WKAhTdaSOd4vvqBHG_IKhWcch0',
                    },
                ],
                init() {
                    console.log(this.mediaItems);
                },
                selectMedia(media) {
                    $dispatch('close-modal', { id: 'media-modal' });
                    $dispatch('open-modal', { id: this.parentModal });
                    this.selectedMedia = media;
                    $wire.selectedGiphy = null;
                },
            }));
        </script>
    @endscript
</div>
