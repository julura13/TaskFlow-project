<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-taskflow-dark">{{ __('Edit project') }}</h1>
    </x-slot>

    <x-card class="max-w-xl">
        <form action="{{ route('projects.update', $project) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $project->title)" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark placeholder-gray-400 focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none">{{ old('description', $project->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none" required>
                    @foreach (\App\Enums\Status::cases() as $status)
                        <option value="{{ $status->value }}" {{ old('status', $project->status->value) === $status->value ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status->value)) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-600">
                    {{ __('Update project') }}
                </button>
                <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-app-layout>
