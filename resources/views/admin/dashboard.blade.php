@extends('layouts.admin')

@php
    // Safe counts (حتى لو موديل ناقص ما يطيحش)
    $usersCount = class_exists(\App\Models\User::class) ? \App\Models\User::count() : 0;

    $mealsCount = class_exists(\App\Models\MealTemplate::class) ? \App\Models\MealTemplate::count() : 0;
    $workoutsCount = class_exists(\App\Models\WorkoutTemplate::class) ? \App\Models\WorkoutTemplate::count() : 0;

    $logsCount = class_exists(\App\Models\ActivityLog::class) ? \App\Models\ActivityLog::count() : 0;

    $recentLogs = class_exists(\App\Models\ActivityLog::class)
        ? \App\Models\ActivityLog::with('user')->latest()->take(6)->get()
        : collect([]);
@endphp

@section('content')
    <!-- Header (بدل x-slot) -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">Admin Dashboard</h2>
            <p class="text-sm text-gray-500 mt-1">Overview of users, templates, and activity.</p>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
                Manage Users
            </a>
            <a href="{{ route('admin.logs.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gray-900 hover:bg-black">
                View Logs
            </a>
        </div>
    </div>

    <!-- Top Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Users -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500">Users</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $usersCount }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl grid place-items-center bg-yellow-100 text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                    Go to users →
                </a>
            </div>
        </div>

        <!-- Meals -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500">Meal Templates</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $mealsCount }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl grid place-items-center bg-emerald-100 text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 3v3"/>
                        <path d="M16 3v3"/>
                        <path d="M4 8h16"/>
                        <path d="M6 6h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2Z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.meals.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                    Manage meals →
                </a>
            </div>
        </div>

        <!-- Workouts -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500">Workout Templates</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $workoutsCount }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl grid place-items-center bg-indigo-100 text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 7v10"/>
                        <path d="M18 7v10"/>
                        <path d="M4 9h16"/>
                        <path d="M4 15h16"/>
                        <path d="M8 7h8"/>
                        <path d="M8 17h8"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.workouts.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                    Manage workouts →
                </a>
            </div>
        </div>

        <!-- Logs -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-500">Activity Logs</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $logsCount }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl grid place-items-center bg-gray-100 text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18"/>
                        <path d="M7 14l3-3 4 4 6-6"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.logs.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                    View logs →
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mt-6">
        <div class="flex items-center justify-between gap-3 flex-wrap">
            <div>
                <h3 class="text-lg font-extrabold text-gray-900">Quick Actions</h3>
                <p class="text-sm text-gray-500 mt-1">Jump into the most used admin pages.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.meals.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold bg-yellow-300 text-gray-900 hover:opacity-90">
                    + Add Meals
                </a>
                <a href="{{ route('admin.workouts.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold bg-yellow-300 text-gray-900 hover:opacity-90">
                    + Add Workouts
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-semibold bg-gray-900 text-white hover:bg-black">
                    Manage Users
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Logs -->
    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 mt-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-extrabold text-gray-900">Recent Activity</h3>
                <p class="text-sm text-gray-500 mt-1">Latest actions in the system.</p>
            </div>
            <a href="{{ route('admin.logs.index') }}" class="text-sm font-semibold text-gray-900 hover:underline">
                See all →
            </a>
        </div>

        <div class="mt-5 overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-3 pr-4">User</th>
                    <th class="py-3 pr-4">Action</th>
                    <th class="py-3 pr-4">Details</th>
                    <th class="py-3">Time</th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($recentLogs as $log)
                    <tr class="text-gray-800">
                        <td class="py-3 pr-4 font-semibold">
                            {{ optional($log->user)->name ?? 'System' }}
                        </td>
                        <td class="py-3 pr-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-gray-100 text-gray-800 font-semibold">
                                {{ $log->action ?? '—' }}
                            </span>
                        </td>
                        <td class="py-3 pr-4 text-gray-600">
                            {{ $log->description ?? '—' }}
                        </td>
                        <td class="py-3 text-gray-500">
                            {{ optional($log->created_at)->diffForHumans() ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-gray-500">
                            No logs yet.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
