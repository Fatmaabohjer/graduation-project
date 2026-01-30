@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">Workout Templates</h2>
            <p class="text-sm text-gray-500 mt-1">Manage workout templates used for generating user plans.</p>
        </div>

        <a href="{{ route('admin.workouts.create') }}"
           class="px-4 py-2 rounded-xl bg-gray-900 text-white text-sm font-semibold hover:bg-black">
            + Add Workout Template
        </a>
    </div>

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

    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-600">
                    <th class="p-4 font-semibold">Name</th>
                    <th class="p-4 font-semibold">Level</th>
                    <th class="p-4 font-semibold">Minutes</th>
                    <th class="p-4 font-semibold">Goal</th>
                    <th class="p-4 font-semibold">Video</th>
                    <th class="p-4 font-semibold">Active</th>
                    <th class="p-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($items as $item)
                    <tr class="hover:bg-gray-50/60">
                        <td class="p-4 font-semibold text-gray-900">{{ $item->name }}</td>
                        <td class="p-4 text-gray-700">{{ $item->level ?? '—' }}</td>
                        <td class="p-4 text-gray-700">{{ $item->duration_minutes ?? '—' }}</td>
                        <td class="p-4 text-gray-700">{{ $item->goal_type ?? 'general' }}</td>

                        <td class="p-4">
                            @if($item->video_url)
                                <a class="text-sm font-semibold text-gray-900 hover:underline"
                                   href="{{ $item->video_url }}" target="_blank" rel="noopener">
                                    Open
                                </a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="p-4">
                            @if($item->is_active)
                                <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">
                                    Yes
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                    No
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex justify-end gap-2 flex-wrap">
                                <a class="px-3 py-2 rounded-xl border border-gray-200 bg-white text-sm font-semibold hover:bg-gray-50"
                                   href="{{ route('admin.workouts.edit', $item) }}">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.workouts.destroy', $item) }}"
                                      onsubmit="return confirm('Delete this template?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 rounded-xl border border-red-200 bg-white text-sm font-semibold text-red-600 hover:bg-red-50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-8 text-center text-gray-500" colspan="7">
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
@endsection
