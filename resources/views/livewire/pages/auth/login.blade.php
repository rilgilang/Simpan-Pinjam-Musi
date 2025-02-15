<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>



<div>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="z-1 relative flex h-screen w-full overflow-hidden bg-white px-4 py-6 sm:p-0 dark:bg-gray-900">
        <div class="flex flex-1 flex-col rounded-2xl p-6 sm:rounded-none sm:border-0 sm:p-8">
            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center">
                <div>
                    <div class="mb-5 sm:mb-8">
                        <h1 class="text-title-sm sm:text-title-md mb-2 font-semibold text-gray-800 dark:text-white/90">
                            Sign In
                        </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Enter your email and password to sign in!
                        </p>
                    </div>
                    <div>
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form wire:submit="login">
                            <!-- Email Address -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input wire:model="form.email" id="email" class="mt-1 block w-full"
                                    type="email" name="email" required autofocus autocomplete="username" />
                                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full"
                                    type="password" name="password" required autocomplete="current-password" />

                                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between">
                                @if (Route::has('password.request'))
                                    <a class="text-brand-500 hover:text-brand-600 dark:text-brand-400 text-sm"
                                        href="{{ route('password.request') }}" wire:navigate>
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                            </div>


                            <x-primary-button
                                class="bg-brand-500 shadow-theme-xs hover:bg-brand-600 flex w-full items-center justify-center rounded-lg px-4 py-3 text-sm font-medium text-white transition">
                                {{ __('Log in') }}
                            </x-primary-button>



                        </form>

                        @if (Route::has('password.request'))
                            <div class="mt-5">
                                <p
                                    class="text-center text-sm font-normal text-gray-700 sm:text-start dark:text-gray-400">
                                    Don't have an account?
                                    <a href="{{ route('register') }}"
                                        class="text-brand-500 hover:text-brand-600 dark:text-brand-400"
                                        wire:navigate>Sign
                                        Up</a>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="z-1 bg-brand-950 relative hidden flex-1 items-center justify-center p-8 lg:flex dark:bg-white/5">
            <!-- ===== Common Grid Shape Start ===== -->
            <!-- ===== Common Grid Shape End ===== -->
            <div class="flex max-w-xs flex-col items-center">
                <a href="index.html" class="mb-4 block">
                    <img src="./images/logo/auth-logo.svg" alt="Logo" />
                </a>
                <p class="text-center text-gray-400 dark:text-white/60">
                    Free and Open-Source Tailwind CSS Admin Dashboard Template
                </p>
            </div>
        </div>
    </div>
</div>
