<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: route('home', absolute: false), navigate: true);
};

?>

<div>
    <x-ui.modal.auth>
        <x-slot name="headingAlternative">
            <h1 class="text-center text-3xl font-semibold text-white sm:px-6 sm:text-4xl">👋🏼 Welcome</h1>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4"
            :status="session('status')"
        />

        <form wire:submit="login">
            <div class="mt-10">
                <div class="space-y-6">
                    <x-ui.input.text
                        label="Email"
                        backgroundColor="bg-brand-darkest "
                        wire:model="form.email"
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        autocomplete="username"
                        validationFieldName="form.email"
                    />

                    <x-ui.input.text
                        wire:model="form.password"
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        label="Enter Password"
                        backgroundColor="bg-brand-darkest "
                        validationFieldName="form.password"
                    />

                    <div class="!mt-0 flex items-center justify-end">
                        @if (Route::has('password.request'))
                            <a
                                class="text-xs font-bold text-neutral hover:text-white focus:outline-none"
                                href="#"
                            >
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-12 flex flex-col space-y-2">
                <x-ui.button
                    type="submit"
                    color="primary"
                    label="Login"
                    size="lg"
                    :fullWidth="true"
                />

                {{-- <x-ui.button --}}
                {{-- href="#" --}}
                {{-- color="accent" --}}
                {{-- label="Connect With Wallet" --}}
                {{-- size="lg" --}}
                {{-- :fullWidth="true" --}}
                {{-- /> --}}
            </div>

            <div class="mt-6 text-center text-xs">
                Don’t have an account?
                <a
                    href="{{ route('register') }}"
                    wire:navigate
                >
                    <span class="text-xs font-bold text-white">Create account</span>
                </a>
            </div>
        </form>
    </x-ui.modal.auth>
</div>
