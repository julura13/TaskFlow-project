<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-xl font-bold text-taskflow-dark">
                {{ __('Dashboard') }}
            </h1>
            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 transition">
                {{ __('New project') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-8">
        <section>
            <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                {{ __('Your projects') }}
            </h2>

            @if ($projects->isEmpty())
                <x-card>
                    <div class="text-center py-8">
                        <p class="text-gray-600">{{ __('You have no projects yet.') }}</p>
                        <a href="{{ route('projects.create') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                            {{ __('Create your first project') }}
                        </a>
                    </div>
                </x-card>
            @else
                <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($projects as $project)
                        @php
                            $total = $project->tasks->count();
                            $completed = $project->completedTasks->count();
                            $pct = $total > 0 ? round(($completed / $total) * 100, 1) : 0;
                        @endphp
                        <li>
                            <a href="{{ route('projects.show', $project) }}" class="group block h-full rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-taskflow-red/30 hover:shadow-md">
                                <h3 class="font-semibold text-taskflow-dark group-hover:text-taskflow-red transition">
                                    {{ $project->title }}
                                </h3>
                                @if ($project->owner)
                                    <p class="mt-1 text-xs text-gray-500">{{ __('Owner') }}: {{ $project->owner->name }}</p>
                                @endif
                                @if ($project->description)
                                    <p class="mt-1.5 text-sm text-gray-600 line-clamp-2">{{ $project->description }}</p>
                                @endif
                                <div class="mt-4 flex items-center justify-between text-sm">
                                    <span class="text-gray-500">
                                        {{ $completed }} {{ __('of') }} {{ $total }} {{ __('tasks') }}
                                    </span>
                                    <span class="font-medium text-taskflow-dark">{{ $pct }}%</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-gray-200 overflow-hidden" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="h-full rounded-full bg-taskflow-red transition-all duration-300" style="width: {{ $pct }}%"></div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</x-app-layout>
