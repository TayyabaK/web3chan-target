@props([
    'mode' => 'post',
    'withDefaultSelector' => false,
])

<div x-data="initAvatarSelector">
    <div
        @class([
            'grid grid-cols-1 gap-y-4',
            'md:grid-cols-3 md:gap-4' => $withDefaultSelector,
        ])
    >
        <form
            class="h-full w-full"
            wire:submit="save"
        >
            <label
                class="flex h-full w-full cursor-pointer flex-col items-center justify-between rounded-lg border-2 border-dashed border-brand-primary bg-brand-secondary p-3"
            >
                <div></div>

                <input
                    wire:model="avatarUpload"
                    type="file"
                    class="hidden"
                />

                @error('avatarUpload')
                    <span class="error">{{ $message }}</span>
                @enderror

                @unless ($this->avatarUpload)
                    <div
                        @class([
                            'flex flex-col items-center justify-center pb-6 pt-5',
                            'h-60 md:h-auto' => $withDefaultSelector,
                            'h-[300px]' => ! $withDefaultSelector,
                        ])
                    >
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
                            <span class="block font-semibold">Click to upload</span>
                            @if ($withDefaultSelector)
                                or select an avatar
                            @endif
                        </p>
                    </div>
                @else
                    <img
                        class="h-full w-full object-cover"
                        src="{{ $this->avatarUpload->temporaryUrl() }}"
                        alt="Avatar"
                    />
                    <x-ui.button
                        type="submit"
                        class="w-full"
                        label="Upload Avatar"
                        color="primary"
                        size="sm"
                        @click="$dispatch('close-modal', { id: 'profile-edit-avatar-modal' })"
                    />
                @endunless
                <div></div>
            </label>
        </form>

        @if ($withDefaultSelector)
            <div class="col-span-2 grid h-[160px] grid-cols-4 gap-4 overflow-scroll md:h-auto md:overflow-hidden">
                <template
                    x-for="avatar in avatarItems"
                    :key="avatar.id"
                >
                    <div class="relative w-full bg-gray-100">
                        <button
                            type="button"
                            @click="selectAvatar(avatar.url)"
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
                            :src="avatar.url"
                            alt="Image"
                        />
                    </div>
                </template>
            </div>
        @endif

        @script
            <script>
                Alpine.data('initAvatarSelector', () => ({
                    selectedAvatar: $wire.entangle('selectedAvatar').live,
                    avatarItems: [
                        {
                            id: 1,
                            type: 'image',
                            url: 'https://media0.giphy.com/media/CSbIZi52DvqnJPm1WA/giphy.webp?cid=ecf05e47mwsqajg7rzwukqe16idgan49zwbtfkzop42vzdd4&ep=v1_gifs_search&rid=giphy.webp&ct=g',
                        },
                        {
                            id: 2,
                            type: 'image',
                            url: 'https://media1.giphy.com/media/uhkgRdrMSnqDBofJru/giphy.webp?cid=ecf05e472iy41aj0o5bjmbn097y9hmd59x1wex9e72xxrveq&ep=v1_gifs_search&rid=giphy.webp&ct=g',
                        },
                        {
                            id: 3,
                            type: 'image',
                            url: 'https://media0.giphy.com/media/13yQp5Xf7YsLcs/giphy.webp?cid=790b7611yuc0znp6n90qgwd8r9sd25swq11emyu7arutzxxi&ep=v1_gifs_search&rid=giphy.webp&ct=g',
                        },
                        {
                            id: 4,
                            type: 'image',
                            url: 'https://media3.giphy.com/media/AVvl9fqv5oD7vjkiyQ/giphy.webp?cid=ecf05e47v1pwu82xmux7uyypwtafhuq5jwmhbohg9ndx2lsr&ep=v1_gifs_search&rid=giphy.webp&ct=g',
                        },
                        {
                            id: 5,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 6,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 7,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 8,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 9,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 10,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 11,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1602452920335-6a132309c7c8?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                        {
                            id: 12,
                            type: 'image',
                            url: 'https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=300&h=300&q=80',
                        },
                    ],
                    init() {
                        console.log(this.avatarItems);
                    },
                    selectAvatar(avatarUrl) {
                        $dispatch('close-modal', { id: 'profile-edit-avatar-modal' });
                        this.selectedAvatar = avatarUrl;
                    },
                }));
            </script>
        @endscript
    </div>
</div>
