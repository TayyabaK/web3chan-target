<x-ui.page>
    <x-ui.layout>
        <x-ui.post.create-post-trigger />
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs :href-back="route('home')">
                <x-ui.breadcrumbs.breadcrumb-item :hasCaret="true">
                    {{ str($post->user->username)->prepend('@') }}
                </x-ui.breadcrumbs.breadcrumb-item>
                <x-ui.breadcrumbs.breadcrumb-item :isHighlighted="true">Chant</x-ui.breadcrumbs.breadcrumb-item>
            </x-ui.breadcrumbs>
        </x-slot>

        <div class="pt-4">
            <x-ui.post
                :post="$post"
                :show-more-button="false"
            />
        </div>

        @guest
            <div class="mt-8 flex w-full items-center justify-center">
                <x-ui.button
                    href="{{ route('login') }}"
                    color="accent"
                    class="mt-4"
                    size="lg"
                >
                    Join the Chan
                </x-ui.button>
            </div>
        @endguest

        @auth
            <div class="px-4">
                <div>
                    <div class="mt-4 bg-brand-secondary p-[0.15rem]">
                        <div class="relative mx-[0.225rem] bg-brand-darkest text-xs text-white">
                            <div class="flex py-2 pl-2">
                                <div class="z-[5] mr-4 flex-shrink-0">
                                    <img
                                        src="{{ asset( auth()->user()->getAvatar(),) }}"
                                        class="size-10"
                                        alt="User Avatar"
                                    />
                                </div>

                                <div
                                    name="trigger"
                                    @click="$dispatch('open-modal', { id: 'post-modal' })"
                                >
                                    <div class="group flex min-h-10 items-center">
                                        <div
                                            class="ms-4 block w-full cursor-pointer font-semibold text-neutral/50 group-hover:text-neutral"
                                        >
                                            Reply to this post
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 hidden border-t border-brand-secondary" />

                <div class="replies-list -mx-8 mt-10">
                    @foreach ($post->replies as $reply)
                        <x-ui.post.reply
                            :reply="$reply"
                            :post="$post"
                        />

                        @if ($replyCount = $reply->posts->count())
                            <x-ui.post.reply
                                :reply="$reply->posts->first()"
                                :post="$post"
                            />
                        @endif
                    @endforeach
                </div>
            </div>
            <livewire:components.create-post
                :current-url="url()->current()"
                :parent-post="$post"
            />
            <x-ui.post.delete-post-modal />
        @endauth
    </x-ui.layout>
</x-ui.page>
