<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-taskflow-dark">{{ __('Edit task') }}</h1>
    </x-slot>

    <x-card class="max-w-xl">
        <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="project_id" :value="__('Project')" />
                <select id="project_id" name="project_id" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none" required>
                    @foreach ($projects as $p)
                        <option value="{{ $p->id }}" {{ old('project_id', $task->project_id) == $p->id ? 'selected' : '' }}>{{ $p->title }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('project_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $task->title)" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark placeholder-gray-400 focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none">{{ old('description', $task->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" name="status" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none" required>
                    @foreach (\App\Enums\Status::cases() as $status)
                        <option value="{{ $status->value }}" {{ old('status', $task->status->value) === $status->value ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status->value)) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="assigned_to" :value="__('Assigned to')" />
                <select id="assigned_to" name="assigned_to" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none">
                    <option value="">{{ __('Unassigned') }}</option>
                    @foreach ($users as $u)
                        <option value="{{ $u->id }}" {{ old('assigned_to', $task->assigned_to) == $u->id ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('assigned_to')" class="mt-2" />
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-600">
                    {{ __('Update task') }}
                </button>
                <a href="{{ route('tasks.show', $task) }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Cancel') }}
                </a>
            </div>
        </form>
    </x-card>
</x-app-layout>
