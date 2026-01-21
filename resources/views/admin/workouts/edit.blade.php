<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Workout Template</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow">

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                        <ul class="list-disc pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.workouts.update', $item->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    @php
                        $goalSelected = old('goal_type', $item->goal_type ?? 'general');
                        $injurySelected = old('health_condition_type', $item->health_condition_type ?? 'none');
                    @endphp

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input name="name" value="{{ old('name', $item->name) }}" class="mt-1 w-full rounded-lg border-gray-300" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Level (optional)</label>
                        <input name="level" value="{{ old('level', $item->level) }}" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Duration Minutes (optional)</label>
                        <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $item->duration_minutes) }}" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Video URL (optional)</label>
                        <input name="video_url" value="{{ old('video_url', $item->video_url) }}" class="mt-1 w-full rounded-lg border-gray-300">
                    </div>

                    {{-- ✅ هنا الخاص بالتمارين فقط --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Goal Type</label>
                            <select name="goal_type" class="mt-1 w-full rounded-lg border-gray-300">
                                <option value="general" @selected($goalSelected==='general')>general</option>
                                <option value="Lose Weight" @selected($goalSelected==='Lose Weight')>Lose Weight</option>
                                <option value="Gain Muscle" @selected($goalSelected==='Gain Muscle')>Gain Muscle</option>
                                <option value="Maintain" @selected($goalSelected==='Maintain')>Maintain</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Injury / Limitation</label>
                            <select name="health_condition_type" class="mt-1 w-full rounded-lg border-gray-300">
                                <option value="none" @selected($injurySelected==='none')>None</option>
                                <option value="knee_pain" @selected($injurySelected==='knee_pain')>Knee Pain</option>
                                <option value="back_pain" @selected($injurySelected==='back_pain')>Back Pain</option>
                                <option value="shoulder_pain" @selected($injurySelected==='shoulder_pain')>Shoulder Pain</option>
                                <option value="neck_pain" @selected($injurySelected==='neck_pain')>Neck Pain</option>
                                <option value="asthma" @selected($injurySelected==='asthma')>Asthma (Low-Intensity)</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300"
                               @checked(old('is_active', $item->is_active))>
                        <span class="text-sm text-gray-700">Active</span>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('admin.workouts.index') }}" class="text-sm underline text-gray-600">Back</a>
                        <button class="px-5 py-2 rounded-lg bg-gray-900 text-white">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
