<?php

declare(strict_types=1);

use App\Http\Controllers\ExternalMediaController;
use App\Http\Controllers\GlobalSearchController;
use App\Livewire\Pages\Bookmarks;
use App\Livewire\Pages\DirectChants;
use App\Livewire\Pages\Explore;
use App\Livewire\Pages\ExplorePeople;
use App\Livewire\Pages\ExploreTopics;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\MyChannels;
use App\Livewire\Pages\Notifications;
use App\Livewire\Pages\PostThread;
use App\Livewire\Pages\PrivateMessage;
use App\Livewire\Pages\Profile;
use App\Livewire\Pages\VisitingChannel;
use App\Livewire\Pages\VisitingTopic;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', Home::class)->name('home');

    // Explore
    Route::get('explore', Explore::class)->name('explore');
    Route::get('explore-people', ExplorePeople::class)->name('explore-people');
    Route::get('explore-topics', ExploreTopics::class)->name('explore-topics');

    // Channels
    Route::get('my-channels', MyChannels::class)->name('my-channels');
    Route::get('channel/{channel:slug}', VisitingChannel::class)->name('channel');

    // Topics
    Route::get('topics/{topic:slug}', VisitingTopic::class)->name('topic');

    // Notifications
    Route::get('notifications', Notifications::class)->name('notifications');

    // Messages
    Route::get('direct-chants', DirectChants::class)->name('direct-chants');
    Route::get('private-message/{thread}', PrivateMessage::class)->name('private-message');

    // Bookmarks
    Route::get('bookmarks/{folder}', Bookmarks::class)->name('bookmarks');

    // Needs to be last
    Route::get('@{user:username}', Profile::class)->name('profile');
});

Route::get('@{user:username}/status/{post}', PostThread::class)->name('post-thread');

Route::get('/external-media', ExternalMediaController::class)->name('external-media');

Route::get('global-search', GlobalSearchController::class)
    ->name('global-search');

Route::get('dashboard', function () {
    return redirect()->route('home');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/auth.php';
