<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-taskflow-dark">{{ __('Tasks') }}</h1>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($tasks->isEmpty())
        <x-card>
            <p class="text-gray-600">{{ __('No tasks yet.') }}</p>
            <a href="{{ route('tasks.create') }}" class="mt-4 inline-flex rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                {{ __('Create task') }}
            </a>
        </x-card>
    @else
        <ul class="space-y-3">
            @foreach ($tasks as $task)
                <li class="flex flex-wrap items-center gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-gray-300 hover:shadow">
                    <a href="{{ route('tasks.show', $task) }}" class="min-w-0 flex-1">
                        <span class="font-medium text-taskflow-dark">{{ $task->title }}</span>
                        <p class="mt-1 text-sm text-gray-600">{{ $task->project->title }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $task->status->value)) }}</p>
                    </a>
                    <div class="flex flex-shrink-0 items-center gap-3">
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
                                        <option value="{{ $u->id }}" @selected($task->assigned_to === $u->id)>
                                            {{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @else
                            <span class="text-sm text-taskflow-dark">{{ $task->user?->name ?? __('Unassigned') }}</span>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    @endif
</x-app-layout>
