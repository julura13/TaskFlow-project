<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-taskflow-dark">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="max-w-4xl">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 sm:p-8">
                <p class="text-taskflow-dark">
                    {{ __("You're logged in!") }}
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
