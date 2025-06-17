<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        $this->redirectIntended(default: route('account', absolute: false), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }
}; ?>

<div class="flex flex-col gap-6 max-w-xl mx-auto font-zen-kaku-gothic-antique">
    {{--
    <x-auth-header :title="__('Sign Up')"
        :description="__('Helping retailers grow with fast access to high-demand products.')" /> --}}

    <h2 class="text-center text-3xl font-semibold mt-6">{{__('Sign Up')}}</h2>
    <p class="text-gray-600 text-center">{{__('Helping retailers grow with fast access to high-demand products.')}}</p>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div class="border border-theme-zinc dark:border-neutral-700 p-3">
            <!-- Email -->
            <label for="email" class="uppercase text-xs">Email <span class="text-red-500 text-xs">*</span></label>
            <input type="email" wire:model="email" id="email"
                class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                autofocus autocomplete="email" placeholder="{{ __('user@foxecom.com') }}" />
            @error('email')
            <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="relative">
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <!-- Password -->
                <label for="password" class="uppercase text-xs">Password <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="password" wire:model="password" id="password"
                    class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    autofocus autocomplete="password" placeholder="{{ __('********') }}" />
                <small class="text-xs text-gray-500">Password must be at least 8 characters long, contain at least one
                    uppercase letter and one number.</small>
                @error('password')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                    <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon=""
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>


        </div>

        <div class="grid grid-cols-2 gap-4">
            <flux:checkbox wire:model="remember" :label="__('Remember me')" />

            @if (Route::has('password.request'))
            <div class="text-sm text-right block">
                <flux:link class="" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            </div>
            @endif
        </div>
        <!-- Remember Me -->

        <div class="flex items-center justify-end">
            <button type="submit"
                class="w-full text-white bg-themeblue font-semibold hover:bg-blue-600 py-5 px-5">{{__('Sign
                In')}}</button>
        </div>
    </form>

    @if (Route::has('register'))
    <div class="w-full text-zinc-600 dark:text-zinc-400 mb-4">
        <p class="text-center overflow-hidden before:h-[1px] after:h-[1px] after:bg-black 
           after:inline-block after:relative after:align-middle after:w-1/4 
           before:bg-black before:inline-block before:relative before:align-middle 
           before:w-1/4 before:right-2 after:left-2 mb-3 py-4">{{ __('New to FOXERGO?') }}</p>
        <a href="{{route('register')}}"
            class="bg-gray-300 hover:bg-gray-500 px-5 py-5 w-full font-semibold text-white block text-center"
            wire:navigate>{{ __('Create your FOXERGO account') }}</a>
    </div>
    @endif
</div>