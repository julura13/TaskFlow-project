<x-guest-layout>
    <h1 class="text-2xl font-bold text-taskflow-dark mb-2">{{ __('Forgot your password?') }}</h1>
    <p class="text-sm text-gray-600 mb-6">
        {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 pt-2">
            <a class="text-sm text-taskflow-dark hover:text-taskflow-red transition order-2 sm:order-1" href="{{ route('login') }}">
                {{ __('Back to login') }}
            </a>
            <x-primary-button class="w-full sm:w-auto order-1 sm:order-2">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
