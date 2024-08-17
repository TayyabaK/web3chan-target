<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Livewire\Components\Concerns\WithUploadAction;
use App\Livewire\Concerns\InteractsWithContentParser;
use App\Livewire\Concerns\WithPostActions;
use App\Models\User;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Contracts\View\View;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateBookmarkFolder extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithContentParser;
    use InteractsWithForms;
    use WithPostActions;
    use WithUploadAction;

    public bool $bookmarkFolderNotification = false;

    public string $bookmarkedPostId;

    public bool $userBookmarked = false;

    public string $name;

    public User $user;

    /** @var array<string, mixed> */
    public ?array $data = [];

    #[On('userBookmarked')]
    public function userBookmarked(string $postId): void
    {
        $this->bookmarkedPostId = $postId;

        $this->bookmarkFolderNotification = true;
        $this->userBookmarked = true;
    }

    #[On('userUnBookmarked')]
    public function userUnBookmarked(): void
    {
        $this->bookmarkFolderNotification = true;
        $this->userBookmarked = false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Folder name')
                    ->suffix(fn (): \Illuminate\Support\HtmlString => new HtmlString('
                            <button
                                type="button"
                                class="block fill-white/50 hover:fill-brand-accent px-2"
                                wire:click="createFolder"
                            >
                                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <polygon points="23 11 23 13 22 13 22 14 14 14 14 22 13 22 13 23 11 23 11 22 10 22 10 14 2 14 2 13 1 13 1 11 2 11 2 10 10 10 10 2 11 2 11 1 13 1 13 2 14 2 14 10 22 10 22 11 23 11"/>
                                </svg>
                            </button>
                        '),
                    )
                    ->minLength(3)
                    ->columnSpanFull()
                    ->live()
                    ->required(fn (Get $get): bool => ! $get('folder_id')),
                ToggleButtons::make('folder_id')
                    ->extraAttributes(['class' => 'folder-selection'])
                    ->reactive()
                    ->label('Folders')
                    ->options($this->getBookmarkFolders())
                    ->icons($this->getBookmarkFolders(onlyIcons: true)),
            ])
            ->statePath('data');
    }

    public function createFolder(): void
    {
        $this->validateOnly('name');

        $name = $this->form->getState()['name'];
        auth()->user()->bookmarkFolders()->create([
            'name' => $name,
            'slug' => Str::slug($name),
        ]);
    }

    public function saveToFolder(): void
    {
        $bookmarkFolder = auth()->user()->bookmarkFolders()->first();
        auth()->user()->bookmarks()->detach($this->bookmarkedPostId, ['folder_id' => $bookmarkFolder->id]);

        auth()->user()->bookmarks()->attach(
            id: $this->bookmarkedPostId,
            attributes: ['folder_id' => $this->form->getState()['folder_id']],
        );

        $this->dispatch('close-modal', id: 'bookmark-folder-modal');
    }

    public function render(): View
    {
        return view('livewire.components.create-bookmark-folder');
    }

    private function getBookmarkFolders(bool $onlyIcons = false): array
    {
        /** @var \Illuminate\Database\Eloquent\Collection<\App\Models\BookmarkFolder> $userBookmarkFolders */
        $userBookmarkFolders = auth()->user()->bookmarkFolders()->latest()->get();

        return $userBookmarkFolders->mapWithKeys(
            fn ($folder): array => [$folder->id => $onlyIcons ? 'heroicon-s-bookmark' : $folder->name],
        )->toArray();
    }
}
