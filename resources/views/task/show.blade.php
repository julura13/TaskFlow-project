<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-xl font-bold text-taskflow-dark">{{ $task->title }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('projects.show', $task->project) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Back to project') }}
                </a>
                <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-taskflow-dark hover:bg-gray-50">
                    {{ __('Edit') }}
                </a>
                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('{{ __('Delete this task?') }}');" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-taskflow-red hover:bg-red-50">
                        {{ __('Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-6 max-w-3xl">
        <x-card>
            <p class="text-sm text-gray-500">{{ __('Project') }}: <a href="{{ route('projects.show', $task->project) }}" class="text-taskflow-red hover:underline">{{ $task->project->title }}</a></p>
            <p class="mt-1 text-sm text-gray-500">{{ __('Status') }}: {{ ucfirst(str_replace('_', ' ', $task->status->value)) }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ __('Assigned to') }}: {{ $task->user?->name ?? __('Unassigned') }}</p>
            @if ($task->description)
                <div class="mt-4 text-taskflow-dark">{{ $task->description }}</div>
            @endif
        </x-card>

        <x-card :padding="false">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-taskflow-dark">{{ __('Comments') }}</h2>
            </div>

            @if ($task->comments->isEmpty())
                <div class="p-6 text-gray-600">
                    {{ __('No comments yet.') }}
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($task->comments as $comment)
                        <li class="p-6">
                            <p class="text-taskflow-dark">{{ $comment->body }}</p>
                            <p class="mt-2 text-sm text-gray-500">{{ $comment->user->name }} · {{ $comment->created_at->diffForHumans() }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="border-t border-gray-200 p-6">
                <form action="{{ route('tasks.comments.store', $task) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input-label for="body" :value="__('Add a comment')" />
                        <textarea id="body" name="body" rows="3" class="mt-1 block w-full rounded-lg border border-gray-300 px-4 py-2.5 text-taskflow-dark placeholder-gray-400 focus:border-taskflow-red focus:ring-2 focus:ring-taskflow-red/20 focus:outline-none" required placeholder="{{ __('Write your comment...') }}">{{ old('body') }}</textarea>
                        <x-input-error :messages="$errors->get('body')" class="mt-2" />
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-taskflow-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-600">
                        {{ __('Post comment') }}
                    </button>
                </form>
            </div>
        </x-card>
    </div>
</x-app-layout>
