<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-800 font-semibold">Welcome Admin ✅</p>
                <p class="text-sm text-gray-500 mt-2">
                    This page is protected. Only users with is_admin = 1 can access it.
                </p>
            </div>
        </div>
    </div>
    <div class="mt-4 flex gap-2">
    <a href="{{ route('admin.dashboard') }}"
       class="px-4 py-2 rounded bg-gray-900 text-white">
        Admin Home
    </a>

    <a href="{{ route('dashboard') }}"
       class="px-4 py-2 rounded border">
        User Dashboard
    </a>
    <a href="{{ route('admin.users.index') }}"
   class="inline-block mt-4 px-4 py-2 rounded-lg bg-gray-900 text-white font-semibold">
    Manage Users
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="{{ route('admin.users.index') }}"
       class="block p-6 bg-white rounded-2xl border hover:bg-gray-50">
        <div class="text-lg font-semibold">Users</div>
        <div class="text-sm text-gray-600 mt-1">
            Manage users, roles, and activation.
        </div>
    </a>

    <a href="{{ route('admin.logs.index') }}"
       class="block p-6 bg-white rounded-2xl border hover:bg-gray-50">
        <div class="text-lg font-semibold">System Logs</div>
        <div class="text-sm text-gray-600 mt-1">
            View all user activity logs.
        </div>
    </a>

    <a href="{{ route('admin.meals.index') }}"
       class="block p-6 bg-white rounded-2xl border hover:bg-gray-50">
        <div class="text-lg font-semibold">Meal Templates</div>
        <div class="text-sm text-gray-600 mt-1">
            Manage meals used in generated plans.
        </div>
    </a>

    <a href="{{ route('admin.workouts.index') }}"
       class="block p-6 bg-white rounded-2xl border hover:bg-gray-50">
        <div class="text-lg font-semibold">Workout Templates</div>
        <div class="text-sm text-gray-600 mt-1">
            Manage workouts and videos.
        </div>
    </a>
</div>

</x-app-layout>
