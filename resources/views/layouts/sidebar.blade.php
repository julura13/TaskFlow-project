<aside class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 flex flex-col transform transition-transform duration-200 ease-out -translate-x-full md:translate-x-0" :class="{ 'translate-x-0': open }">
    <div class="flex h-16 items-center justify-between px-6 border-b border-gray-200">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xl font-bold tracking-tight">
            <span class="text-taskflow-red">Task</span><span class="text-taskflow-dark">Flow</span>
        </a>
        <button @click="open = false" class="md:hidden p-2 rounded-md text-gray-500 hover:bg-gray-100">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>

    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-sidebar-link>
        <x-sidebar-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
            {{ __('Projects') }}
        </x-sidebar-link>
    </nav>

    <div class="border-t border-gray-200 p-4">
        <div class="flex items-center gap-3 px-3 py-2">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-taskflow-dark truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        <div class="mt-2 space-y-1">
            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium text-taskflow-dark rounded-lg hover:bg-gray-100">{{ __('Profile') }}</a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-taskflow-dark rounded-lg hover:bg-gray-100 text-left">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</aside>
