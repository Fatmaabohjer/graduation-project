@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">
                Logs: {{ $user->name }} <span class="text-gray-500 font-semibold text-base">({{ $user->email }})</span>
            </h2>
            <p class="text-sm text-gray-500 mt-1">User-specific activity history.</p>
        </div>

        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
                Back to Users
            </a>
            <a href="{{ route('admin.logs.index') }}"
               class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
                System Logs
            </a>
        </div>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-600">
                    <th class="p-4 font-semibold">Time</th>
                    <th class="p-4 font-semibold">Action</th>
                    <th class="p-4 font-semibold">Actor</th>
                    <th class="p-4 font-semibold">IP</th>
                    <th class="p-4 font-semibold">Description</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/60">
                        <td class="p-4 text-gray-600 whitespace-nowrap">
                            {{ $log->created_at }}
                        </td>

                        <td class="p-4 font-semibold text-gray-900 whitespace-nowrap">
                            {{ $log->action }}
                        </td>

                        <td class="p-4 text-gray-700">
                            {{ $log->actor?->email ?? '—' }}
                        </td>

                        <td class="p-4 text-gray-700 whitespace-nowrap">
                            {{ $log->ip_address ?? '—' }}
                        </td>

                        <td class="p-4 text-gray-600">
                            {{ $log->description ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">
                            No logs found for this user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
@endsection
