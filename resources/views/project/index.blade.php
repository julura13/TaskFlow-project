<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-taskflow-dark">{{ __('Projects') }}</h1>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                {{ __('New project') }}
            </a>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    @if ($projects->isEmpty())
        <x-card>
            <p class="text-gray-600">{{ __('No projects yet.') }}</p>
            <a href="{{ route('projects.create') }}" class="mt-4 inline-flex rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                {{ __('Create project') }}
            </a>
        </x-card>
    @else
        <ul class="space-y-3">
            @foreach ($projects as $project)
                <li>
                    <a href="{{ route('projects.show', $project) }}" class="block rounded-xl border border-gray-200 bg-white p-4 shadow-sm transition hover:border-gray-300 hover:shadow">
                        <span class="font-medium text-taskflow-dark">{{ $project->title }}</span>
                        @if ($project->description)
                            <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $project->description }}</p>
                        @endif
                        <p class="mt-2 text-xs text-gray-500">{{ $project->status->value }}</p>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $projects->links() }}
        </div>
    @endif
</x-app-layout>
