<div class="w-full">
    <!-- SearchBox -->
    <div
        class="relative"
        x-data="initComboBox"
        :data-hs-combo-box="options"
    >
        <div class="btn-retro relative">
            <div class="pointer-events-none absolute inset-y-0 start-0 z-20 flex items-center ps-3.5">
                <x-icons.magnifier class="hidden size-5 hs-combo-box-active:block" />
                <x-icons.magnifier
                    class="visible size-5 hs-combo-box-active:hidden"
                    fill="accent"
                />
            </div>
            <input
                class="no-border-focus block w-full bg-brand-secondary py-3 pe-4 ps-10 text-sm text-white placeholder:text-brand-primary focus:bg-brand-darkest disabled:pointer-events-none"
                type="text"
                placeholder="Search on Web3Chan"
                value=""
                data-hs-combo-box-input=""
            />
        </div>

        <!-- SearchBox Dropdown -->
        <div
            class="btn-retro absolute z-[10000] !-mt-2 h-96 w-full bg-brand-secondary pt-2 hs-combo-box-active:bg-brand-darkest"
            style="display: none"
            data-hs-combo-box-output=""
        >
            <div
                class="scrollbar-thin scrollbar-track scrollbar-thumb scrollbar-hover {{ $dropdownHeight }} overflow-hidden overflow-y-auto rounded-b-lg px-4 pb-4 pt-2"
                data-hs-combo-box-output-items-wrapper=""
            ></div>
        </div>
        <!-- End SearchBox Dropdown -->
    </div>
    <!-- End SearchBox -->

    @script
        <script>
            Alpine.data('initComboBox', () => ({
                options: {
                    isOpenOnFocus: true,
                    groupingType: 'default',
                    apiGroupField: 'category',
                    apiUrl: '{{ route('global-search') }}',
                    apiSearchQuery: 'q',
                    outputItemTemplate: @json(view('components.ui.search.item')->render()),
                    outputEmptyTemplate: @json(view('components.ui.search.empty')->render()),
                    outputLoaderTemplate: @json(view('components.ui.search.loader')->render()),
                    groupingTitleTemplate: @json(view('components.ui.search.group-title')->render()),
                },
                setup() {
                    this.options = JSON.stringify(this.options);
                },
                init() {
                    console.log('initComboBox');
                    this.setup();
                },
            }));
        </script>
    @endscript
</div>
