<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manage Users
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('admin.logs.index') }}" class="px-4 py-2 rounded-lg border">
                    System Logs
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg border">
                    Admin Dashboard
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash --}}
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-yellow-50 border border-yellow-300 text-yellow-900">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-300 text-green-900">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="q" value="{{ $q }}"
                       class="w-full rounded-lg border-gray-300"
                       placeholder="Search by name or email...">
                <button class="px-4 py-2 rounded-lg bg-gray-900 text-white font-semibold">
                    Search
                </button>
            </form>

            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-3">Name</th>
                            <th class="text-left p-3">Email</th>
                            <th class="text-left p-3">Role</th>
                            <th class="text-left p-3">Status</th>
                            <th class="text-right p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr class="border-t">
                                <td class="p-3 font-semibold">{{ $u->name }}</td>
                                <td class="p-3">{{ $u->email }}</td>

                                <td class="p-3">
                                    @if($u->is_admin)
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-900 text-white">
                                            Admin
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                            User
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    @if($u->is_active)
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                            Disabled
                                        </span>
                                    @endif
                                </td>

                                <td class="p-3">
                                    <div class="flex justify-end gap-2">
                                        {{-- Toggle Active --}}
                                        <form method="POST" action="{{ route('admin.users.toggleActive', $u) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="px-3 py-2 rounded-lg border font-semibold">
                                                {{ $u->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>

                                        {{-- View Logs --}}
                                        <a href="{{ route('admin.logs.user', $u) }}" class="px-3 py-2 rounded-lg bg-gray-900 text-white font-semibold">
                                            View Logs
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-6 text-center text-gray-500">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
