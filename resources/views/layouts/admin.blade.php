<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'VitaPlan') }} | Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased">

    <!-- NAVBAR -->
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <!-- Left -->
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-yellow-300 grid place-items-center font-extrabold text-gray-900">
                                V
                            </div>
                            <span class="font-extrabold text-gray-900">VitaPlan</span>
                            <span class="text-xs font-semibold text-gray-400">Admin</span>
                        </a>
                    </div>

                    <!-- Links -->
                    <div class="hidden sm:flex sm:items-center sm:ml-10 space-x-8">
                        <a href="{{ route('admin.dashboard') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold
                           {{ request()->routeIs('admin.dashboard') ? 'border-yellow-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold
                           {{ request()->routeIs('admin.users.*') ? 'border-yellow-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Users
                        </a>

                        <a href="{{ route('admin.meals.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold
                           {{ request()->routeIs('admin.meals.*') ? 'border-yellow-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Meals
                        </a>

                        <a href="{{ route('admin.workouts.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold
                           {{ request()->routeIs('admin.workouts.*') ? 'border-yellow-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Workouts
                        </a>

                        <a href="{{ route('admin.logs.index') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-semibold
                           {{ request()->routeIs('admin.logs.*') ? 'border-yellow-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Logs
                        </a>
                    </div>
                </div>

                <!-- Right -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="text-sm font-semibold text-gray-500 hover:text-gray-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile -->
                <div class="flex items-center sm:hidden">
                    <span class="text-sm font-semibold text-gray-700">Admin</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

</body>
</html>
