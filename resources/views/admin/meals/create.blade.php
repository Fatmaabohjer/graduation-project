<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Meal Template
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow">

                @if ($errors->any())
                    <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
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
                        <label class="block text-sm font-medium text-gray-700">Meal Type</label>
                        <select name="meal_type" class="mt-1 w-full rounded-lg border-gray-300" required>
                            <option value="">Select meal type</option>
                            <option value="Breakfast" @selected(old('meal_type') === 'Breakfast')>Breakfast</option>
                            <option value="Lunch" @selected(old('meal_type') === 'Lunch')>Lunch</option>
                            <option value="Dinner" @selected(old('meal_type') === 'Dinner')>Dinner</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 w-full rounded-lg border-gray-300"
                               placeholder="Oatmeal + Banana" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Calories</label>
                        <input type="number" name="calories" value="{{ old('calories') }}"
                               class="mt-1 w-full rounded-lg border-gray-300"
                               placeholder="400" required>
                    </div>

                    @php
                        $goalSelected = old('goal_type', 'general');
                        $condSelected = old('health_condition_type', 'none');
                    @endphp

                    {{-- ✅ خانتين: Goal + Condition --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Goal Type</label>
                            <select name="goal_type" class="mt-1 w-full rounded-lg border-gray-300">
                                <option value="general" @selected($goalSelected === 'general')>general</option>
                                <option value="Lose Weight" @selected($goalSelected === 'Lose Weight')>Lose Weight</option>
                                <option value="Gain Muscle" @selected($goalSelected === 'Gain Muscle')>Gain Muscle</option>
                                <option value="Maintain" @selected($goalSelected === 'Maintain')>Maintain</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Health Condition</label>
                            <select name="health_condition_type" class="mt-1 w-full rounded-lg border-gray-300">
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
                        <span class="text-sm text-gray-700">Active</span>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('admin.meals.index') }}" class="text-sm text-gray-600 underline">Back</a>
                        <button class="px-5 py-2 rounded-lg bg-gray-900 text-white">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
