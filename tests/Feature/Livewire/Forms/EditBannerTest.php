<?php

declare(strict_types=1);

use App\Livewire\Forms\EditBanner;
use App\Livewire\Pages\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

describe('Edit Banner', function () {
    it('renders successfully', function () {
        Livewire::test(EditBanner::class)
            ->assertOk();
    });

    it('can select and update user banner', function () {
        Livewire::test(EditBanner::class)
            ->set('selectedBanner', 'banner.jpg')
            ->assertDispatched('update-banner', 'banner.jpg');

        Livewire::test(Profile::class, ['user' => auth()->user()])
            ->dispatch('update-banner', 'banner.jpg')
            ->assertSet('user.banner', 'banner.jpg');

        // Additionally let's check the user banner has been updated in the database
        assertDatabaseHas('users', [
            'id' => auth()->id(),
            'banner' => 'banner.jpg',
        ]);
    });

    it('can upload user banner', function () {
        Storage::fake('tmp-for-tests');

        $file = UploadedFile::fake()->image('uploaded-banner.jpg');
        $url = Storage::url('banners/uploaded-banner.jpg');

        Livewire::test(EditBanner::class)
            ->set('bannerUpload', $file)
            ->call('save')
            ->assertDispatched('update-banner', $url);

        Storage::disk('tmp-for-tests')->assertExists('banners/uploaded-banner.jpg');

        Livewire::test(Profile::class, ['user' => auth()->user()])
            ->dispatch('update-banner', $url)
            ->assertSet('user.banner', $url);

        // Additionally let's check the user banner has been updated in the database
        assertDatabaseHas('users', [
            'id' => auth()->id(),
            'banner' => $url,
        ]);
    });
});
