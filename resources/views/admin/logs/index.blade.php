@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">System Logs</h2>
            <p class="text-sm text-gray-500 mt-1">Audit trail of actions across the system.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
            Admin Dashboard
        </a>
    </div>

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-600">
                    <th class="p-4 font-semibold">Time</th>
                    <th class="p-4 font-semibold">Action</th>
                    <th class="p-4 font-semibold">User</th>
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
                            {{ $log->user?->email ?? '—' }}
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
                        <td colspan="6" class="p-8 text-center text-gray-500">
                            No logs found.
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
