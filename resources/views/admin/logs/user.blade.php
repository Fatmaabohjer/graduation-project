<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Logs: {{ $user->name }} ({{ $user->email }})
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-lg border">Back to Users</a>
                <a href="{{ route('admin.logs.index') }}" class="px-4 py-2 rounded-lg border">System Logs</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left p-3">Time</th>
                            <th class="text-left p-3">Action</th>
                            <th class="text-left p-3">Actor</th>
                            <th class="text-left p-3">IP</th>
                            <th class="text-left p-3">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr class="border-t">
                                <td class="p-3">{{ $log->created_at }}</td>
                                <td class="p-3 font-semibold">{{ $log->action }}</td>
                                <td class="p-3">{{ $log->actor?->email ?? '—' }}</td>
                                <td class="p-3">{{ $log->ip_address ?? '—' }}</td>
                                <td class="p-3">{{ $log->description ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $logs->links() }}</div>
        </div>
    </div>
</x-app-layout>
