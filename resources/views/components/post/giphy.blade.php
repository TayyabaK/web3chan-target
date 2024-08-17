@props(['mode' => 'post'])

<div
    x-data="initGiphy"
    x-init="search"
>
    <label>
        <input
            type="text"
            x-model="searchQuery"
            placeholder="Search Giphy..."
            autocomplete="off"
        />
        <x-filament::button
            @click.prevent="search"
            type="button"
        >
            Search
        </x-filament::button>
    </label>

    @isset($post)
        <div class="text-xs">
            {{ $post->title }}
        </div>
    @endif

    <div
        id="grid"
        class="mt-4 grid max-h-96 grid-cols-4 gap-1 overflow-x-auto"
    >
        <template
            x-for="giphy in results"
            :key="giphy.id"
        >
            <div class="relative h-40 w-full bg-gray-100">
                <button
                    type="button"
                    @click="selectGiphy(giphy)"
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
                    class="h-full w-full object-cover"
                    :src="'/external-media?url=' + encodeURIComponent(giphy.images.fixed_height.url)"
                    :alt="giphy.title"
                />
            </div>
        </template>
    </div>

    @script
        <script>
            Alpine.data('initGiphy', () => ({
                parentModal: @js($mode) + '-modal',
                searchQuery: 'gif',
                results: [],
                selectedGiphy: $wire.entangle('selectedGiphy').live,
                // @todo: Move this to env
                apiKey: 'vqwywrzvIjPk9E8xqtCCSnlghtPGCSFs',
                endpoint: 'https://api.giphy.com/v1/gifs/search',
                limit: 50,
                get fetchEndpoint() {
                    return (
                        this.endpoint + '?q=' + this.searchQuery + '&api_key=' + this.apiKey + '&limit=' + this.limit
                    );
                },
                search() {
                    fetch(this.fetchEndpoint)
                        .then((res) => res.json())
                        .then((res) => {
                            this.results = res.data;
                            // console.log(this.results);
                        })
                        .catch((e) => {
                            console.log(e, 'error');
                        });
                },
                selectGiphy(giphy) {
                    $dispatch('close-modal', { id: 'giphy-modal' });
                    $dispatch('open-modal', { id: this.parentModal });
                    this.selectedGiphy = giphy.images.fixed_height.url;
                    $wire.selectedMedia = null;
                },
            }));
        </script>
    @endscript
</div>
