<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Channel;
use App\Models\User;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

/**
 * @property Form $form
 */
class ChannelForm extends Component implements HasForms
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    public ?Channel $channel = null;

    public string $formMode = 'create';

    public string $heading = 'Create Channel';

    public string $description = 'Create a new channel';

    public bool $showModal = false;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        'open-modal' => 'openModal',
        'close-modal' => 'closeModal',
    ];

    public function mount(): void
    {
        if ($this->channel instanceof Channel) {
            $this->formMode = 'edit';
            $this->heading = 'Edit Channel';
            $this->description = 'Edit your channel';

            $this->form->fill($this->channel->toArray());
        } else {
            $this->form->fill([]);
        }
    }

    public function openModal(?string $id = null): void
    {
        if ($id === 'channel-'.$this->formMode.'-modal') {
            $this->showModal = true;
        }
    }

    public function closeModal(?string $id = null): void
    {
        if ($id === 'channel-'.$this->formMode.'-modal') {
            $this->showModal = false;
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->model(Channel::class)
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Channel')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Name')
                                    ->placeholder('Enter channel name')
                                    ->minLength(3)
                                    ->columnSpanFull()
                                    ->required(),
                                TextInput::make('slug')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state): mixed => $set('slug', Str::slug($state)))
                                    ->label('Link')
                                    ->placeholder('Enter channel link')
                                    ->columnSpanFull()
                                    ->hint('Changing the link may affect SEO')
                                    ->required(),
                                Textarea::make('description')
                                    ->label('Description')
                                    ->autosize()
                                    ->rows(3)
                                    ->maxLength(300)
                                    ->placeholder('Enter your bio'),
                                ToggleButtons::make('is_private')
                                    ->label('Privacy Setting')
                                    ->options([
                                        0 => 'Open',
                                        1 => 'Private',
                                    ])
                                    ->inline(),
                            ]),
                        Tabs\Tab::make('Moderators')
                            ->schema([
                                TableRepeater::make('moderators')
                                    ->headers([
                                        Header::make('user_id')->width('150px'),
                                    ])
                                    ->extraAttributes(['class' => 'no-border-focus divide-y-none'])
                                    ->label('Moderators')
                                    ->relationship()
                                    ->renderHeader(false)
                                    ->streamlined()
                                    ->showLabels(false)
                                    ->emptyLabel('There are no users registered.')
                                    ->schema([
                                        Select::make('user_id')
                                            ->label('User')
                                            ->placeholder('Select user')
                                            ->options(fn () => User::pluck('name', 'id'))
                                            ->required(),
                                    ])
                                    ->columnSpan('full'),
                            ]),
                        Tabs\Tab::make('Rules')
                            ->schema([
                                Textarea::make('rules')
                                    ->label('Rules')
                                    ->placeholder('Enter channel rules')
                                    ->rows(10)
                                    ->columnSpanFull(),
                                // ->extraAttributes(['class' => 'text-left min-h-[600px]'])
                                // ->toolbarButtons([
                                //     'bold',
                                //     'bulletList',
                                //     'h2',
                                //     'h3',
                                //     'italic',
                                //     'link',
                                //     'orderedList',
                                //     'strike',
                                //     'underline',
                                //     'undo',
                                // ]),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $formData = $this->form->getState();

        if ($this->channel instanceof Channel) {
            $this->channel->update($formData);
        } else {
            $formData['owner_id'] = auth()->id();
            $this->channel = Channel::create($formData);
        }

        $this->form->model($this->channel)->saveRelationships();

        $this->redirectRoute('channel', ['channel' => $this->channel]);
    }

    public function render(): View
    {
        return view('livewire.forms.channel-form');
    }
}
