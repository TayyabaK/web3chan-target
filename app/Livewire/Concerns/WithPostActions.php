<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\LivewireFilepond\WithFilePond;

trait WithPostActions
{
    use WithFilePond;

    public ?string $selectedGiphy = null;

    /**
     * @var array<int, array{id: string, url: string}>
     */
    public ?array $selectedMedia = null;

    public ?array $poll = null;

    #[Validate('max:51200|mimes:jpeg,jpg,webp,png,gif,mp4,webm')]
    public ?TemporaryUploadedFile $mediaUpload = null;

    public function save(): void
    {
        if (! $this->mediaUpload) {
            return;
        }

        $path = $this->mediaUpload->storeAs(
            path: 'chant-media',
            name: $this->mediaUpload->getClientOriginalName(),
        );

        $mediaType = in_array($this->mediaUpload->extension(), ['mp4', 'webm']) ? 'video' : 'image';
        $this->dispatch('syncSelectedMedia', [
            'url' => Storage::url($path),
            'type' => $mediaType,
        ]); // @phpstan-ignore-line

        $this->dispatch('close-modal', id: 'media-modal');
        $this->dispatch('open-modal', id: 'post-modal');
    }

    public function updatedSelectedGiphy(?string $value): void
    {
        $this->selectedGiphy = $value;

        $this->dispatch('syncSelectedGiphy', $value);
    }

    public function updatedSelectedMedia(?array $value): void
    {
        $this->selectedMedia = $value;

        $this->dispatch('syncSelectedMedia', $value);
    }

    public function deleteMedia(): void
    {
        $this->selectedMedia = null;
    }

    public function deleteGiphy(): void
    {
        $this->selectedGiphy = null;
    }

    public function deletePoll(): void
    {
        $this->poll = null;
    }
}
