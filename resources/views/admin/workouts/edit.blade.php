@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">Edit Workout Template</h2>
            <p class="text-sm text-gray-500 mt-1">Update workout details, video, goal and limitations.</p>
        </div>

        <a href="{{ route('admin.workouts.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 bg-white hover:bg-gray-50">
            Back to list
        </a>
    </div>

    <div class="max-w-4xl">
        <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm">

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200">
                    <ul class="list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
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
                    <label class="block text-sm font-semibold text-gray-700">Name</label>
                    <input name="name"
                           value="{{ old('name', $item->name) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Level (optional)</label>
                    <input name="level"
                           value="{{ old('level', $item->level) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Duration Minutes (optional)</label>
                    <input type="number"
                           name="duration_minutes"
                           value="{{ old('duration_minutes', $item->duration_minutes) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Video URL (optional)</label>
                    <input name="video_url"
                           value="{{ old('video_url', $item->video_url) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Goal Type</label>
                        <select name="goal_type"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                            <option value="general" @selected($goalSelected==='general')>general</option>
                            <option value="Lose Weight" @selected($goalSelected==='Lose Weight')>Lose Weight</option>
                            <option value="Gain Muscle" @selected($goalSelected==='Gain Muscle')>Gain Muscle</option>
                            <option value="Maintain" @selected($goalSelected==='Maintain')>Maintain</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Injury / Limitation</label>
                        <select name="health_condition_type"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
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
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           class="rounded border-gray-300"
                           @checked(old('is_active', $item->is_active))>
                    <span class="text-sm text-gray-700 font-semibold">Active</span>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('admin.workouts.index') }}" class="text-sm font-semibold text-gray-600 hover:underline">
                        Back
                    </a>
                    <button class="px-5 py-2 rounded-xl bg-gray-900 text-white font-semibold hover:bg-black">
                        Save
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
