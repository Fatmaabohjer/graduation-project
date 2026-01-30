<nav class="bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Left: Logo + Links --}}
            <div class="flex items-center gap-10">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="w-9 h-9 rounded-xl bg-amber-400 flex items-center justify-center text-white font-bold">
                        V
                    </div>
                    <span class="text-lg font-extrabold text-gray-900 dark:text-gray-100">
                        VitaPlan
                    </span>
                </a>

                {{-- Links --}}
                <div class="hidden sm:flex items-center gap-8">

                    <a href="{{ route('dashboard') }}"
                       class="text-sm font-semibold
                       {{ request()->routeIs('dashboard') ? 'text-amber-600 border-b-2 border-amber-500 pb-1'
                       : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('profile.health.edit') }}"
                       class="text-sm font-semibold
                       {{ request()->routeIs('profile.health.*') ? 'text-amber-600 border-b-2 border-amber-500 pb-1'
                       : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">
                        Health Profile
                    </a>

                    <a href="{{ route('plan.show') }}"
                       class="text-sm font-semibold
                       {{ request()->routeIs('plan.*') ? 'text-amber-600 border-b-2 border-amber-500 pb-1'
                       : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">
                        My Plan
                    </a>

                    <a href="{{ route('progress.index') }}"
                       class="text-sm font-semibold
                       {{ request()->routeIs('progress.*') ? 'text-amber-600 border-b-2 border-amber-500 pb-1'
                       : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white' }}">
                        Progress
                    </a>

                </div>
            </div>

            {{-- Right: User --}}
            <div class="flex items-center gap-4">

                <span class="hidden sm:block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ auth()->user()->name }}
                </span>

                {{-- Dropdown --}}
                <div class="relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 px-3 py-2 rounded-xl
                                           bg-gray-100 dark:bg-gray-800
                                           hover:bg-gray-200 dark:hover:bg-gray-700">

                                {{-- Avatar: أول حرف من الاسم --}}
                                <div class="w-8 h-8 rounded-full bg-amber-400
                                            flex items-center justify-center
                                            text-sm font-bold text-white">
                                    {{ mb_substr(auth()->user()->name, 0, 1) }}
                                </div>

                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.health.edit')">
                                Health Profile
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('progress.index')">
                                Progress
                            </x-dropdown-link>

                            {{-- ✅ Log Out (صح) --}}
                            <x-dropdown-link href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>

                    {{-- ✅ الفورم لازم يكون خارج dropdown --}}
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>
                </div>

            </div>
        </div>
    </div>
</nav>
