<div class="flex w-full flex-col items-center justify-center">
    @error('mediaUpload')
        <span class="error mb-2 h-full w-full border border-dashed border-white/20 p-4 font-semibold text-white">
            {{ $message }}
        </span>
    @enderror

    <form
        class="h-full w-full"
        wire:submit="save"
    >
        <label>
            @unless ($this->mediaUpload)
                <x-filepond::upload
                    wire:model="mediaUpload"
                    class="block w-full cursor-pointer rounded-lg border-2 border-dashed border-brand-primary bg-brand-secondary"
                    maxFileSize="50MB"
                />
            @else
                @if (in_array($this->mediaUpload->getMimeType(), ['video/mp4', 'video/*']))
                    <video
                        class="w-full object-cover"
                        controls
                    >
                        <source
                            src="{{ $this->mediaUpload->temporaryUrl() }}"
                            type="video/mp4"
                        />
                        Your browser does not support the video tag.
                    </video>
                @elseif (in_array($this->mediaUpload->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/webp']))
                    <img
                        class="w-full object-cover"
                        src="{{ $this->mediaUpload->temporaryUrl() }}"
                        alt="Media"
                    />
                @endif
                <x-ui.button
                    type="submit"
                    class="w-full"
                    label="Upload Media"
                    color="primary"
                    size="sm"
                />
            @endunless
        </label>
    </form>
</div>

@unless ($this->mediaUpload?->temporaryUrl())
    <x-post.media-selector :mode="$mode" />
@endif
