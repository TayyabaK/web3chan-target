<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Channel;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! app()->isProduction());
        Model::unguard();

        $this->bootViewComposers();
    }

    private function bootViewComposers(): void
    {
        Facades\View::composer('components.ui.widgets.suggested-channels', function (View $view): void {
            $alreadyJoined = auth()->check() ? Channel::whereHas('members', function ($query): void {
                $query->where('user_id', auth()->id());
            })->pluck('id')->toArray() : [];

            $suggestedChannels = Channel::whereNotIn('id', $alreadyJoined)
                ->take(3)
                ->get();

            $view->with('channels', $suggestedChannels);
        });

        Facades\View::composer('components.ui.widgets.suggested-follows', function (View $view): void {

            $alreadyFollowing = auth()->check() ? auth()->user()->followings->pluck('id')->toArray() : [];
            $suggestedPeople = User::whereNotIn('id', [auth()->id()])
                ->whereNotIn('id', $alreadyFollowing)
                ->where('is_admin', false)
                ->take(3)
                ->get();

            $view->with('people', $suggestedPeople);
        });

        Facades\View::composer('components.ui.widgets.popular-posts', function (View $view): void {
            $posts = Post::with(['user', 'tags'])
                ->where('depth', 0)
                ->where('blocks->content', '!=', '')
                ->whereHas('tags')
                ->latest()
                ->take(3)
                ->get();

            $view->with('posts', $posts);
        });

        Facades\View::composer('components.ui.navigation.recent-users', function (View $view): void {
            $view->with('users', User::whereNotIn('id', [auth()->id()])->where('is_admin', false)->orderByDesc('id')->take(4)->get());
        });

        Facades\View::composer('components.ui.navigation.all-users', function (View $view): void {
            $view->with('users', User::whereNotIn('id', [auth()->id()])->where('is_admin', false)->inRandomOrder()->take(4)->get());
        });
    }
}
