<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Add Workout Template</h2>
            <a href="{{ route('admin.workouts.index') }}" class="px-4 py-2 rounded border">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow p-6">

                @if($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-50 border border-red-200 text-red-800">
                        <ul class="list-disc ms-5">
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.workouts.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">Name</label>
                        <input name="name" value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="Plank (Core)">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Level (optional)</label>
                        <input name="level" value="{{ old('level','Beginner') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="Beginner/Intermediate/Advanced">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Duration Minutes (optional)</label>
                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes',10) }}"
                               class="w-full rounded-lg border-gray-300" min="0">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Video URL (optional)</label>
                        <input name="video_url" value="{{ old('video_url') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="https://www.youtube.com/watch?v=...">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Goal Type (optional)</label>
                        <input name="goal_type" value="{{ old('goal_type','general') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="lose / gain / maintain / general">
                    </div>

                    <button class="px-4 py-2 rounded bg-gray-900 text-white font-semibold">
                        Create
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
