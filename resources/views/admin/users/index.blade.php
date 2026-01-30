@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                Manage Users
            </h2>
            <p class="text-sm text-gray-500 mt-1">Search, enable/disable users, and view activity logs.</p>
        </div>

        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.logs.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
                System Logs
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
                Admin Dashboard
            </a>
        </div>
    </div>

    {{-- Flash --}}
    @if(session('error'))
        <div class="mb-4 p-3 rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-900">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="mb-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-900">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex gap-2">
        <input type="text" name="q" value="{{ $q }}"
               class="w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
               placeholder="Search by name or email...">

        <button class="px-4 py-2 rounded-xl bg-gray-900 text-white font-semibold hover:bg-black">
            Search
        </button>
    </form>

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-gray-600">
                    <th class="text-left p-4 font-semibold">Name</th>
                    <th class="text-left p-4 font-semibold">Email</th>
                    <th class="text-left p-4 font-semibold">Role</th>
                    <th class="text-left p-4 font-semibold">Status</th>
                    <th class="text-right p-4 font-semibold">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($users as $u)
                    <tr class="hover:bg-gray-50/60">
                        <td class="p-4 font-semibold text-gray-900">{{ $u->name }}</td>
                        <td class="p-4 text-gray-700">{{ $u->email }}</td>

                        <td class="p-4">
                            @if($u->is_admin)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-900 text-white">
                                    Admin
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                    User
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($u->is_active)
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                    Active
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                    Disabled
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex justify-end gap-2 flex-wrap">
                                {{-- Toggle Active --}}
                                <form method="POST" action="{{ route('admin.users.toggleActive', $u) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-3 py-2 rounded-xl border border-gray-200 font-semibold bg-white hover:bg-gray-50">
                                        {{ $u->is_active ? 'Disable' : 'Enable' }}
                                    </button>
                                </form>

                                {{-- View Logs --}}
                                <a href="{{ route('admin.logs.user', $u) }}"
                                   class="px-3 py-2 rounded-xl bg-gray-900 text-white font-semibold hover:bg-black">
                                    View Logs
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
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
@endsection
