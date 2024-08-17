<?php

declare(strict_types=1);

namespace App\Support;

use App\Livewire\Concerns\InteractsWithBookmarks;
use App\Livewire\Concerns\InteractsWithFollowing;
use App\Livewire\Concerns\InteractsWithLikes;
use App\Livewire\Concerns\InteractsWithPostInlineActions;
use App\Livewire\Concerns\InteractsWithShares;
use App\Livewire\Concerns\InteractsWithTips;
use App\Livewire\Concerns\WithUserReactions;
use Livewire\Component;
use Mary\Traits\Toast;

class PagePosts extends Component
{
    use InteractsWithBookmarks;
    use InteractsWithFollowing;
    use InteractsWithLikes;
    use InteractsWithPostInlineActions;
    use InteractsWithShares;
    use InteractsWithTips;
    use Toast;
    use WithUserReactions;
}
