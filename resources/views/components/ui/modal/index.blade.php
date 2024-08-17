<div class="bg-brand-darkest fixed inset-0 z-10 bg-opacity-80 backdrop-blur-sm transition-opacity"></div>

<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
        <div
            class="bg-brand-secondary relative transform overflow-hidden rounded-lg px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6"
        >
            <div class="">
                {{-- @todo: This element serves as a spacer since without it the modal is not full width. Needs fixing though --}}
                <div class="w-96"></div>
                <div class="mt-4 space-y-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
