<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-taskflow-dark">{{ __('New task') }}</h1>
    </x-slot>

    <x-card class="max-w-xl">
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-5">
            @csrf

            <x-text-input type="hidden" name="project_id" value="{{ $project->id }}" />

            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark placeholder-gray-400 focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-600">
                    {{ __('Create task') }}
                </button>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-app-layout>
