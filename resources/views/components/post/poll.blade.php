<div>
    <form wire:submit="insertPoll">
        <div class="px-4 py-6 sm:p-6">
            {{ $this->form }}
        </div>
        <div class="px-4 py-3 text-right sm:px-6">
            <x-ui.button
                type="submit"
                color="primary"
                label="Save"
                size="lg"
                :fullWidth="true"
            />
        </div>
    </form>
</div>
