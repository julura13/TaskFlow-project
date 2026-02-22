<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-bold text-taskflow-dark">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="max-w-4xl space-y-6">
        <p class="text-taskflow-dark">
            {{ __("Your projects") }}
        </p>

        @if ($projects->isEmpty())
            <x-card>
                <p class="text-gray-600">{{ __('You have no projects yet.') }}</p>
                <a href="{{ route('projects.create') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                    {{ __('Create your first project') }}
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
                        </a>
                    </li>
                @endforeach
            </ul>


            <a href="{{ route('projects.create') }}" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-4 py-2 text-sm font-semibold text-white hover:bg-red-600">
                {{ __('New project') }}
            </a>
        @endif
    </div>
</x-app-layout>
