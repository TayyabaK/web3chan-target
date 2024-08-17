<?php

declare(strict_types=1);

namespace App\Livewire\Components;

use App\Events\PostCreated;
use App\Livewire\Components\Concerns\WithUploadAction;
use App\Livewire\Concerns\InteractsWithContentParser;
use App\Livewire\Concerns\WithPostActions;
use App\Livewire\Concerns\WithResponsiveModal;
use App\Models\Channel;
use App\Models\Post;
use App\Models\Tag;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CreatePost extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithContentParser;
    use InteractsWithForms;
    use WithPostActions;
    use WithResponsiveModal;
    use WithUploadAction;

    public bool $showModal = false;

    public string $content = '';

    public string $currentUrl = '';

    public ?Post $parentPost = null;

    public Post $post;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        'open-modal' => 'openModal',
        'close-modal' => 'closeModal',
    ];

    #[On('replace-lookup-value')]
    public function replaceLookupValue(
        string $value,
        string $selected,
        int $currentCaretPosition,
    ): void {
        $this->replaceWord($value, $selected, $currentCaretPosition);
    }

    #[On('syncSelectedGiphy')]
    public function syncSelectedGiphy(?string $value): void
    {
        $this->selectedGiphy = $value;

        $this->poll = null;
        $this->selectedMedia = null;
    }

    /**
     * @param  array<string, string>|null  $value
     */
    #[On('syncSelectedMedia')]
    public function syncSelectedMedia(?array $value): void
    {
        $this->selectedMedia = $value;

        $this->poll = null;
        $this->selectedGiphy = null;
    }

    /**
     * @param  array<string, string>|null  $value
     */
    #[On('syncPoll')]
    public function syncPoll(?array $value): void
    {
        $this->poll = $value;

        $this->selectedMedia = null;
        $this->selectedGiphy = null;
    }

    public function openModal(?string $id = null, ?string $parentId = null): void
    {
        if ($id === 'post-modal') {
            if ($parentId !== null && $parentId !== '' && $parentId !== '0') {
                $this->parentPost = Post::findOrFail($parentId);
                $this->currentUrl = route('post-thread', [$this->parentPost->user, $this->parentPost]);
            }
            $this->showModal = true;
        }
    }

    public function closeModal(?string $id = null): void
    {
        if ($id === 'post-modal') {
            $this->showModal = false;
        }
    }

    public function create(): void
    {
        $blocks = [
            'content' => $this->content,
            'giphy' => $this->selectedGiphy,
            'media' => $this->selectedMedia,
            'poll' => $this->poll,
        ];

        $attributes = [
            'blocks' => $blocks,
            'user_id' => auth()->id(),
        ];

        // @note Temp hack to fill from parent post
        if ($this->parentPost instanceof Post) {
            $attributes['parent_id'] = $this->parentPost->id;
            $attributes['channel_id'] = $this->parentPost->channel_id;
            $attributes['depth'] = $this->parentPost->depth + 1;
        }

        // @todo Move this to Action class (later)
        $this->post = Post::create($attributes);

        if (str_contains($this->currentUrl, '/channel/')) {
            $channelSlug = Str::of($this->currentUrl)
                ->explode('/')
                ->last();
            $channel = Channel::where('slug', $channelSlug)->firstOrFail();
            $this->post->channel()->associate($channel);
            $this->post->save();
        }

        // @todo Move this to Action class (later)
        if ($topics = $this->extractLookups($this->post->blocks['content'])->get('topic')) { // @phpstan-ignore-line
            collect($topics)->each(function ($topicSlug): void { // @phpstan-ignore-line
                $tag = Tag::firstOrCreate(['slug->en' => $topicSlug], ['name->en' => Str::title($topicSlug)]);
                if ($this->post->tags->contains($tag->id)) {
                    return;
                }
                $this->post->tags()->attach($tag->id);
            });
        }

        PostCreated::dispatch($this->post);

        $this->dispatch('close-modal', id: 'post-modal');
        $this->redirect($this->currentUrl);
    }

    public function render(): View
    {
        return view('livewire.components.create-post');
    }
}
