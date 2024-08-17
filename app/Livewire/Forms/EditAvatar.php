<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class EditAvatar extends Component
{
    use WithFileUploads;

    public ?string $selectedAvatar = null;

    #[Validate('image')]
    public ?TemporaryUploadedFile $avatarUpload = null;

    public bool $hasDefaultSelection = true;

    public function save(): void
    {
        if (! $this->avatarUpload instanceof TemporaryUploadedFile) {
            return;
        }

        $path = $this->avatarUpload->storeAs(
            path: 'avatars',
            name: $this->avatarUpload->getClientOriginalName(),
        );

        $this->dispatch('update-avatar', Storage::url($path)); // @phpstan-ignore-line
    }

    public function updatedSelectedAvatar(?string $avatar): void
    {
        $this->dispatch('update-avatar', $avatar);
    }

    public function render(): View
    {
        return view('livewire.forms.edit-avatar');
    }
}
