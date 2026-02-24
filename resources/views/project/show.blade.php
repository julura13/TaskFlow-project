<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-taskflow-dark">{{ $project->title }}</h1>
            <div class="flex gap-2">

                @can('updateProject', $project)
                <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Edit') }}
                </a>
                @endcan
                @can('deleteProject', $project)
                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('{{ __('Delete this project?') }}');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-taskflow-red hover:bg-red-50">
                        {{ __('Delete') }}
                    </button>
                </form>
                @endcan
                @can('createTask', $project)
                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="inline-flex items-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                        {{ __('Add task') }}
                    </a>
                @endcan


            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-6">
        @if ($project->description || $project->owner)
            <x-card>
                @if ($project->owner)
                    <p class="text-sm text-gray-500">{{ __('Owner') }}: {{ $project->owner->name }}</p>
                @endif
                @if ($project->description)
                    <p class="mt-2 text-taskflow-dark">{{ $project->description }}</p>
                @endif
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
                    @can('createTask', $project)
                        <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="mt-3 inline-flex rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                            {{ __('Add task') }}
                        </a>
                    @endcan
                @else
                    <ul class="space-y-2">
                        @foreach ($tasks as $task)
                            <li class="flex flex-wrap items-center gap-3 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3 hover:bg-gray-100/80">
                                <a href="{{ route('tasks.show', $task) }}" class="min-w-0 flex-1 font-medium text-taskflow-dark hover:underline">
                                    {{ $task->title }}
                                </a>
                                <div class="flex flex-shrink-0 items-center gap-3">
                                    <span class="text-sm text-gray-500">{{ __('Comments') }}:</span>
                                    <span>{{ $task->comments->count() }}</span>

                                    <span class="text-sm text-gray-500">{{ __('Assigned to') }}:</span>
                                    @can('updateTask', $task)
                                        <form action="{{ route('tasks.update-assignee', $task) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <select
                                                name="assigned_to"
                                                class="rounded-lg border-gray-300 text-sm focus:border-taskflow-red focus:ring-taskflow-red"
                                                onchange="this.form.submit()"
                                            >
                                                <option value="">{{ __('Unassigned') }}</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}" @selected($task->assigned_to === $u->id)>{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @else
                                        <span class="text-sm text-taskflow-dark">{{ $task->user?->name ?? __('Unassigned') }}</span>
                                    @endcan
                                </div>
                                @can('updateTask', $task)
                                    <form action="{{ route('tasks.update-status', $task) }}" method="POST" class="flex-shrink-0">
                                        @csrf
                                        @method('PATCH')
                                        <select
                                            name="status"
                                            class="rounded-lg border-gray-300 text-sm focus:border-taskflow-red focus:ring-taskflow-red"
                                            onchange="this.form.submit()"
                                        >
                                            @foreach (\App\Enums\Status::cases() as $status)
                                                <option value="{{ $status->value }}" @selected($task->status === $status)>
                                                    {{ ucfirst(str_replace('_', ' ', $status->value)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endcan
                                @cannot('updateTask', $task)
                                    <span class="flex-shrink-0 text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $task->status->value)) }}</span>
                                @endcannot
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </x-card>
    </div>
</x-app-layout>
