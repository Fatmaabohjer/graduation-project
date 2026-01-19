<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Add Meal Template</h2>
            <a href="{{ route('admin.meals.index') }}" class="px-4 py-2 rounded border">Back</a>
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

                <form method="POST" action="{{ route('admin.meals.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold mb-1">Meal Type</label>
                        <input name="meal_type" value="{{ old('meal_type','Breakfast') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="Breakfast / Lunch / Dinner">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Name</label>
                        <input name="name" value="{{ old('name') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="Oatmeal + Banana">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Calories</label>
                        <input type="number" name="calories" value="{{ old('calories',400) }}"
                               class="w-full rounded-lg border-gray-300" min="0">
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
