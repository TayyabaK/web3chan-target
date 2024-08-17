<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class EditBanner extends Component
{
    use WithFileUploads;

    public ?string $selectedBanner = null;

    #[Validate('image')]
    public ?TemporaryUploadedFile $bannerUpload = null;

    public bool $hasDefaultSelection = true;

    public bool $showModal = false;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        'open-modal' => 'openModal',
        'close-modal' => 'closeModal',
    ];

    public function openModal(?string $id = null): void
    {
        if ($id === 'edit-banner-modal') {
            $this->showModal = true;
        }
    }

    public function closeModal(?string $id = null): void
    {
        if ($id === 'edit-banner-modal') {
            $this->showModal = false;
        }
    }

    public function save(): void
    {
        if (! $this->bannerUpload instanceof TemporaryUploadedFile) {
            return;
        }

        $path = $this->bannerUpload->storeAs(
            path: 'banners',
            name: $this->bannerUpload->getClientOriginalName(),
        );

        $this->dispatch('update-banner', Storage::url($path)); // @phpstan-ignore-line
    }

    public function updatedSelectedBanner(?string $banner): void
    {
        $this->dispatch('update-banner', $banner);
    }

    public function render(): View
    {
        return view('livewire.forms.edit-banner');
    }
}
