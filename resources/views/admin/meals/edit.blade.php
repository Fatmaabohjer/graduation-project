{{-- resources/views/admin/meals/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Meal Template</h2>
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

                {{-- ✅ هنا أصلحنا الـ route: لازم تمرري $item مش $item->id --}}
                <form method="POST" action="{{ route('admin.meals.update', $item) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    @php
                        $mt = old('meal_type', $item->meal_type);
                        $goalSelected = old('goal_type', $item->goal_type ?? 'general');
                        $dietSelected = old('dietary_condition', $item->dietary_condition ?? 'none');

                    @endphp

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Meal Type</label>
                        <select name="meal_type" class="mt-1 w-full rounded-lg border-gray-300" required>
                            <option value="">Select</option>
                            <option value="Breakfast" @selected($mt==='Breakfast')>Breakfast</option>
                            <option value="Lunch" @selected($mt==='Lunch')>Lunch</option>
                            <option value="Dinner" @selected($mt==='Dinner')>Dinner</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input
                            name="name"
                            value="{{ old('name', $item->name) }}"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Calories</label>
                        <input
                            type="number"
                            name="calories"
                            value="{{ old('calories', $item->calories) }}"
                            class="mt-1 w-full rounded-lg border-gray-300"
                            required
                        >
                    </div>

                    {{-- ✅ خاص بالوجبات فقط --}}
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
                            <label class="block text-sm font-medium text-gray-700">Diet Condition</label>
                            <select name="dietary_condition" class="mt-1 w-full rounded-lg border-gray-300">

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
                        <input
                            type="checkbox"
                            name="is_active"
                            value="1"
                            class="rounded border-gray-300"
                            @checked(old('is_active', (bool) $item->is_active))
                        >
                        <span class="text-sm text-gray-700">Active</span>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('admin.meals.index') }}" class="text-sm underline text-gray-600">Back</a>
                        <button class="px-5 py-2 rounded-lg bg-gray-900 text-white">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
