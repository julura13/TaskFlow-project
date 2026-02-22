<x-guest-layout>
    <h1 class="text-2xl font-bold text-taskflow-dark mb-6">{{ __('Log in') }}</h1>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-taskflow-red focus:ring-taskflow-red" name="remember">
            <label for="remember_me" class="ms-2 text-sm text-taskflow-dark">{{ __('Remember me') }}</label>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-2">
            @if (Route::has('password.request'))
                <a class="text-sm text-taskflow-dark hover:text-taskflow-red transition order-2 sm:order-1" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-primary-button class="w-full sm:w-auto order-1 sm:order-2">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
