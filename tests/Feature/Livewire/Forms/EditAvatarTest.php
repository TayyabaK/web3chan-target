<?php

declare(strict_types=1);

use App\Livewire\Forms\EditAvatar;
use App\Livewire\Pages\Profile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

describe('Edit Avatar', function () {
    it('renders successfully', function () {
        Livewire::test(EditAvatar::class)
            ->assertOk();
    });

    it('can select and update user avatar', function () {
        Livewire::test(EditAvatar::class)
            ->set('selectedAvatar', 'avatar.jpg')
            ->assertDispatched('update-avatar', 'avatar.jpg');

        Livewire::test(Profile::class, ['user' => auth()->user()])
            ->dispatch('update-avatar', 'avatar.jpg')
            ->assertSet('user.image', 'avatar.jpg');

        // Additionally let's check the user avatar has been updated in the database
        assertDatabaseHas('users', [
            'id' => auth()->id(),
            'image' => 'avatar.jpg',
        ]);
    });

    it('can upload an avatar', function () {
        Storage::fake('tmp-for-tests');

        $file = UploadedFile::fake()->image('uploaded-avatar.jpg');
        $url = Storage::url('avatars/uploaded-avatar.jpg');

        Livewire::test(EditAvatar::class)
            ->set('avatarUpload', $file)
            ->call('save')
            ->assertDispatched('update-avatar', $url);

        Storage::disk('tmp-for-tests')->assertExists('avatars/uploaded-avatar.jpg');

        Livewire::test(Profile::class, ['user' => auth()->user()])
            ->dispatch('update-avatar', $url)
            ->assertSet('user.image', $url);

        // Additionally let's check the user avatar has been updated in the database
        assertDatabaseHas('users', [
            'id' => auth()->id(),
            'image' => $url,
        ]);
    });
});
