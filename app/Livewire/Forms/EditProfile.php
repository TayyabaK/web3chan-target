<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @property Form $form
 */
class EditProfile extends Component implements HasForms
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();

        $this->form->fill($this->user->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(User::class)
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Enter your name')
                    ->minLength(3)
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->label('Email')
                    ->placeholder('Enter your email')
                    ->columns()
                    ->required(),
                TextInput::make('username')
                    ->label('Username (not editable)')
                    ->placeholder('Enter your username')
                    ->disabled()
                    ->columns()
                    ->required(),
                Section::make()
                    ->relationship('profile')
                    ->columns(1)
                    ->schema([
                        Textarea::make('bio')
                            ->label('Bio')
                            ->rows(3)
                            ->maxLength(300)
                            ->placeholder('Enter your bio'),
                        DatePicker::make('date_of_birth')
                            ->label('Date of birth (not visible)'),
                        Textarea::make('location')
                            ->label('Location (not visible)')
                            ->maxLength(100)
                            ->placeholder('Enter your location'),
                    ]),
            ])
            ->statePath('data')
            ->columns();
    }

    public function save(): void
    {
        $this->user->update($this->form->getState());

        $this->form->model($this->user)->saveRelationships();

        $this->redirectRoute('profile', ['user' => $this->user]);
    }

    public function render(): View
    {
        return view('livewire.forms.edit-profile');
    }
}
