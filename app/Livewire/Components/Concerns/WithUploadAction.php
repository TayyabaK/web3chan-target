<?php

declare(strict_types=1);

namespace App\Livewire\Components\Concerns;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ViewField;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Storage;

trait WithUploadAction
{
    public array $photos = [];

    public function uploadAction(): Action
    {
        return Action::make('upload')
            ->form([
                FileUpload::make('attachments')
                    ->multiple()
                    ->disk('uploads')
                    ->afterStateUpdated(function ($state): void {
                        $this->photos = [];
                        foreach ($state as $file) {
                            $tmpFile = 'livewire-tmp/'.$file->getFileName();
                            $new = 'uploads/'.$file->getFileName();
                            $this->photos[] = $new;
                            Storage::move($tmpFile, $new);
                        }
                    }),
                ViewField::make('photos')
                    ->view('livewire.uploaded-photos', ['photos' => $this->photos]),
            ])
            ->modalWidth(MaxWidth::FiveExtraLarge)
            ->action(fn (): null => null);
    }
}
