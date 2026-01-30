@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">Add Meal Template</h2>
            <p class="text-sm text-gray-500 mt-1">Create a new meal template used in user plans.</p>
        </div>

        <a href="{{ route('admin.meals.index') }}"
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

            <form method="POST" action="{{ route('admin.meals.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Meal Type</label>
                    <select name="meal_type"
                            class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                            required>
                        <option value="">Select meal type</option>
                        <option value="Breakfast" @selected(old('meal_type') === 'Breakfast')>Breakfast</option>
                        <option value="Lunch" @selected(old('meal_type') === 'Lunch')>Lunch</option>
                        <option value="Dinner" @selected(old('meal_type') === 'Dinner')>Dinner</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           placeholder="Oatmeal + Banana" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Calories</label>
                    <input type="number" name="calories" value="{{ old('calories') }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           placeholder="400" required>
                </div>

                @php
                    $goalSelected = old('goal_type', 'general');
                    $condSelected = old('health_condition_type', 'none');
                @endphp

                {{-- ✅ خانتين: Goal + Condition (خليتها زي ما عندك) --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Goal Type</label>
                        <select name="goal_type"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                            <option value="general" @selected($goalSelected === 'general')>general</option>
                            <option value="Lose Weight" @selected($goalSelected === 'Lose Weight')>Lose Weight</option>
                            <option value="Gain Muscle" @selected($goalSelected === 'Gain Muscle')>Gain Muscle</option>
                            <option value="Maintain" @selected($goalSelected === 'Maintain')>Maintain</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Health Condition</label>
                        <select name="health_condition_type"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                            <option value="none" @selected($condSelected === 'none')>None</option>
                            <option value="diabetes" @selected($condSelected === 'diabetes')>Diabetes</option>
                            <option value="gluten" @selected($condSelected === 'gluten')>Gluten Intolerance</option>
                            <option value="hypertension" @selected($condSelected === 'hypertension')>Hypertension</option>
                            <option value="knee_pain" @selected($condSelected === 'knee_pain')>Knee Pain</option>
                            <option value="back_pain" @selected($condSelected === 'back_pain')>Back Pain</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300">
                    <span class="text-sm text-gray-700 font-semibold">Active</span>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('admin.meals.index') }}" class="text-sm font-semibold text-gray-600 hover:underline">
                        Back
                    </a>
                    <button class="px-5 py-2 rounded-xl bg-gray-900 text-white font-semibold hover:bg-black">
                        Create
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
