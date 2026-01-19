<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Workout Templates</h2>

            <a href="{{ route('admin.workouts.create') }}"
               class="px-4 py-2 rounded-lg bg-gray-900 text-white font-semibold">
                + Add Workout Template
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('error'))
                <div class="mb-4 p-3 rounded bg-yellow-50 border border-yellow-200 text-yellow-900">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 border border-green-200 text-green-900">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-left">
                            <th class="p-3">Name</th>
                            <th class="p-3">Level</th>
                            <th class="p-3">Minutes</th>
                            <th class="p-3">Goal</th>
                            <th class="p-3">Video</th>
                            <th class="p-3">Active</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr class="border-t">
                                <td class="p-3 font-semibold">{{ $item->name }}</td>
                                <td class="p-3">{{ $item->level ?? '—' }}</td>
                                <td class="p-3">{{ $item->duration_minutes ?? '—' }}</td>
                                <td class="p-3">{{ $item->goal_type ?? 'general' }}</td>
                                <td class="p-3">
                                    @if($item->video_url)
                                        <a class="underline" href="{{ $item->video_url }}" target="_blank">Open</a>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($item->is_active)
                                        <span class="px-2 py-1 rounded bg-green-100 text-green-800 text-xs">Yes</span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs">No</span>
                                    @endif
                                </td>
                                <td class="p-3 text-right">
                                    <a class="px-3 py-1 rounded border" href="{{ route('admin.workouts.edit', $item) }}">Edit</a>

                                    <form class="inline" method="POST" action="{{ route('admin.workouts.destroy', $item) }}"
                                          onsubmit="return confirm('Delete this template?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-3 py-1 rounded border text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t">
                                <td class="p-6 text-gray-600" colspan="7">
                                    No workout templates yet. Click “Add Workout Template”.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
