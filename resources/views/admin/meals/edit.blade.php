@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="font-extrabold text-2xl text-gray-900 leading-tight">Edit Meal Template</h2>
            <p class="text-sm text-gray-500 mt-1">Update meal details, calories, goal, and dietary condition.</p>
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

            {{-- ✅ route: لازم تمرري $item --}}
            <form method="POST" action="{{ route('admin.meals.update', $item) }}" class="space-y-4">
                @csrf
                @method('PUT')

                @php
                    $mt = old('meal_type', $item->meal_type);
                    $goalSelected = old('goal_type', $item->goal_type ?? 'general');
                    $dietSelected = old('dietary_condition', $item->dietary_condition ?? 'none');
                @endphp

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Meal Type</label>
                    <select name="meal_type"
                            class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                            required>
                        <option value="">Select</option>
                        <option value="Breakfast" @selected($mt==='Breakfast')>Breakfast</option>
                        <option value="Lunch" @selected($mt==='Lunch')>Lunch</option>
                        <option value="Dinner" @selected($mt==='Dinner')>Dinner</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Name</label>
                    <input name="name"
                           value="{{ old('name', $item->name) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700">Calories</label>
                    <input type="number"
                           name="calories"
                           value="{{ old('calories', $item->calories) }}"
                           class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900"
                           required>
                </div>

                {{-- ✅ خاص بالوجبات --}}
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
                        <label class="block text-sm font-semibold text-gray-700">Diet Condition</label>
                        <select name="dietary_condition"
                                class="mt-1 w-full rounded-xl border-gray-300 focus:border-gray-900 focus:ring-gray-900">
                            <option value="none" @selected($dietSelected==='none')>None</option>
                            <option value="diabetes" @selected($dietSelected==='diabetes')>Diabetes-friendly</option>
                            <option value="gluten_free" @selected($dietSelected==='gluten_free')>Gluten-Free</option>
                            <option value="lactose_free" @selected($dietSelected==='lactose_free')>Lactose-Free</option>
                            <option value="low_salt" @selected($dietSelected==='low_salt')>Low-Salt</option>
                            <option value="high_protein" @selected($dietSelected==='high_protein')>High-Protein</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           class="rounded border-gray-300"
                           @checked(old('is_active', (bool) $item->is_active))>
                    <span class="text-sm text-gray-700 font-semibold">Active</span>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('admin.meals.index') }}" class="text-sm font-semibold text-gray-600 hover:underline">
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
