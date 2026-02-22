<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-taskflow-dark">{{ __('Tasks') }}</h1>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                {{ __('New task') }}
            </a>
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
                <li>
                    <a href="{{ route('tasks.show', $task) }}" class="block rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-gray-300 hover:shadow">
                        <span class="font-medium text-taskflow-dark">{{ $task->title }}</span>
                        <p class="mt-1 text-sm text-gray-600">{{ $task->project->title }}</p>
                        <p class="mt-2 text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $task->status->value)) }} · {{ $task->user?->name ?? __('Unassigned') }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    @endif
</x-app-layout>
