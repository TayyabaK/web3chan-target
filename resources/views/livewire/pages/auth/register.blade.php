<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'username' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    $validated['username'] = Str::slug($validated['name']);

    event(new Registered(($user = User::create($validated))));

    Auth::login($user);

    $this->redirect(route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <x-ui.modal.auth>
        <x-slot name="breadcrumbs">
            <x-ui.breadcrumbs
                hrefBack="{{ route('login') }}"
                class="bg-transparent"
            />
        </x-slot>

        <x-slot name="heading">Set your Main Information</x-slot>

        @if (request()->has('referral'))
            <x-slot name="headingAlternative">
                Referral Code:
                <span class="font-semibold text-white/80">{{ request('referral_code') }}</span>
            </x-slot>
        @endif

        <form wire:submit="register">
            <div class="mt-8 space-y-6">
                <x-ui.input.text
                    label="Referred by"
                    backgroundColor="bg-brand-darkest/50"
                    name="referral"
                    value="{{ request('referral') }}"
                    readonly
                />

                <x-ui.input.text
                    label="Username"
                    required="true"
                    backgroundColor="bg-brand-darkest "
                    wire:model="name"
                    name="name"
                    autofocus
                    autocomplete="name"
                />

                <x-ui.input.text
                    label="Email"
                    required="true"
                    backgroundColor="bg-brand-darkest "
                    wire:model="email"
                    id="email"
                    type="email"
                    name="email"
                    required
                    autocomplete="username"
                />

                <x-ui.input.text
                    type="password"
                    label="Password"
                    required="true"
                    backgroundColor="bg-brand-darkest "
                    wire:model="password"
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />

                <x-ui.input.text
                    type="password"
                    label="Re-Enter Password"
                    required="true"
                    backgroundColor="bg-brand-darkest "
                    wire:model="password_confirmation"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <div class="flex-center gap-2 text-sm text-white">
                    <input
                        id="privacy-policy"
                        type="checkbox"
                        class="accent-green-500"
                    />
                    <label for="privacy-policy">Accept Privacy Policy [?]</label>
                </div>

                <div class="mt-12 grid">
                    <x-ui.button
                        label="Create Account"
                        type="submit"
                        color="accent"
                        size="lg"
                    />
                </div>
            </div>

            <div class="mt-6 text-center">
                <a
                    href="{{ route('login') }}"
                    wire:navigate
                >
                    <span class="text-xs font-bold text-neutral">{{ __('Already registered?') }}</span>
                </a>
            </div>
        </form>
    </x-ui.modal.auth>
</div>
