<?php

declare(strict_types=1);

namespace App\Livewire\Concerns;

use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;

trait WithPollForm
{
    use InteractsWithForms;

    public function mountWithPollForm(): void
    {
        $this->data = [
            'question' => null,
            'answers' => [
                ['answer' => null],
                ['answer' => null],
            ],
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')
                    ->label('Question')
                    ->placeholder('Ask a question'),

                TableRepeater::make('answers')
                    ->headers([
                        Header::make('answer')->width('150px'),
                    ])
                    ->extraAttributes(['class' => 'no-border-focus divide-y-none'])
                    ->label('Choices')
                    ->renderHeader(false)
                    ->streamlined()
                    ->showLabels(false)
                    ->emptyLabel('Add a choice')
                    ->schema([
                        TextInput::make('answer')
                            ->label('Choice')
                            ->placeholder('Choice')
                            ->required(),
                    ])
                    ->minItems(2)
                    ->maxItems(4)
                    ->columnSpan('full'),
            ])
            ->statePath('data');
    }

    public function insertPoll(): void
    {
        $this->dispatch('syncPoll', $this->data);

        $this->dispatch('close-modal', id: 'poll-modal');
        $this->dispatch('open-modal', id: 'post-modal');
    }

    protected function setPollCurrentAction(): ?string
    {
        if ($this->data['answers'] ?? null) {
            return 'poll';
        }

        return null;
    }
}
