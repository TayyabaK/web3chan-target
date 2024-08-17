{{-- @if (Route::currentRouteName() === 'profile' || Route::currentRouteName() === 'home' || Route::currentRouteName() === 'channel') --}}
<div>
    <span class="hidden text-white sm:block">Create a bookmark folder</span>

    <div class="mt-4 bg-brand-secondary p-[0.15rem]">
        <div
            name="trigger"
            @click="$dispatch('open-modal', { id: 'post-modal' })"
        >
            <div class="group flex min-h-12 items-center">
                <div
                    class="ms-4 block w-full cursor-pointer font-semibold text-neutral/50 group-hover:text-neutral"
                >
                    CREATE FOLDER
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @endif --}}
