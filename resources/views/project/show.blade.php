<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-taskflow-dark">{{ $project->title }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('{{ __('Delete this project?') }}');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-taskflow-red hover:bg-red-50">
                        {{ __('Delete') }}
                    </button>
                </form>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                    {{ __('Add task') }}
                </a>
            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-6">
        @if ($project->description)
            <x-card>
                <p class="text-taskflow-dark">{{ $project->description }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ __('Status') }}: {{ ucfirst(str_replace('_', ' ', $project->status->value)) }}</p>
            </x-card>
        @endif

        <x-card :padding="false">
            <div class="grid grid-cols-2 gap-4 border-b border-gray-200 p-6 sm:grid-cols-4">
                <div>
                    <p class="text-sm text-gray-500">{{ __('Total tasks') }}</p>
                    <p class="text-2xl font-bold text-taskflow-dark">{{ $totalTasks }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">{{ __('Completed') }}</p>
                    <p class="text-2xl font-bold text-green-600">{{ $completedTasks }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">{{ __('Pending') }}</p>
                    <p class="text-2xl font-bold text-taskflow-dark">{{ $pendingTasks }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">{{ __('Completion %') }}</p>
                    <p class="text-2xl font-bold text-taskflow-red">{{ $completionPercentage }}%</p>
                </div>
            </div>

            <div class="p-6">
                <h2 class="mb-4 text-lg font-semibold text-taskflow-dark">{{ __('Tasks') }}</h2>
                @if ($tasks->isEmpty())
                    <p class="text-gray-600">{{ __('No tasks yet.') }}</p>
                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="mt-3 inline-flex rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                        {{ __('Add task') }}
                    </a>
                @else
                    <ul class="space-y-2">
                        @foreach ($tasks as $task)
                            <li>
                                <a href="{{ route('tasks.show', $task) }}" class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 hover:bg-gray-100">
                                    <span class="font-medium text-taskflow-dark">{{ $task->title }}</span>
                                    <span class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $task->status->value)) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </x-card>
    </div>
</x-app-layout>
