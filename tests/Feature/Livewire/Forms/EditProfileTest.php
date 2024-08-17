<?php

declare(strict_types=1);

use App\Livewire\Forms\EditProfile;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

describe('Edit Profile', function () {
    it('renders successfully', function () {
        livewire(EditProfile::class)
            ->assertOk();
    });

    it('can fill the form', function () {
        livewire(EditProfile::class)
            ->assertFormSet(
                state: auth()->user()->toArray(),
            );
    });

    it('can validate user name field', function () {
        livewire(EditProfile::class)
            ->fillForm(['name' => ''])
            ->call('save')
            ->assertHasErrors([
                'data.name' => 'The name field is required.',
            ])
            ->fillForm(['name' => 'ok'])
            ->call('save')
            ->assertHasErrors([
                'data.name' => 'The name field must be at least 3 characters.',
            ]);
    });

    it('can validate user email field', function () {
        livewire(EditProfile::class)
            ->fillForm(['email' => ''])
            ->call('save')
            ->assertHasErrors([
                'data.email' => 'The email field is required.',
            ])
            ->fillForm(['email' => 'invalid-email'])
            ->call('save')
            ->assertHasErrors([
                'data.email' => 'The email field must be a valid email address.',
            ]);
    });

    it('can validate user bio field', function () {
        livewire(EditProfile::class)
            ->fillForm(['profile.bio' => str_repeat('a', 301)])
            ->call('save')
            ->assertHasErrors([
                'data.profile.bio' => 'The bio field must not be greater than 300 characters.',
            ]);
    });

    it('can validate date of birth field is a valid date', function () {
        livewire(EditProfile::class)
            ->fillForm(['profile.date_of_birth' => '2000-001-00000'])
            ->call('save')
            ->assertHasErrors([
                'data.profile.date_of_birth' => 'The date of birth (not visible) field must be a valid date.',
            ]);
    });

    it('can validate user location field', function () {
        livewire(EditProfile::class)
            ->fillForm(['profile.location' => str_repeat('a', 101)])
            ->call('save')
            ->assertHasErrors([
                'data.profile.location' => 'The location (not visible) field must not be greater than 100 characters.',
            ]);
    });

    it('can update or create user profile', function () {
        $profile = [
            'bio' => fake()->realText(),
            'date_of_birth' => now()->subYears(18)->format('Y-m-d'),
            'location' => collect([
                fake()->streetAddress(),
                fake()->city(),
                fake()->country(),
            ])->join(', '),
        ];

        $user = auth()->user();

        livewire(EditProfile::class)
            ->fillForm([
                'profile' => $profile,
            ])
            ->assertFormSet(
                state: $user->toArray(),
            )
            ->call('save')
            ->assertHasNoFormErrors();

        // Note: Profile fields are nullable, we can't test the relationship directly, so need to check the profile is in the db
        assertDatabaseHas('profiles', $profile);
    });
});
