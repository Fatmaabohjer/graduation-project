<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Track Progress
            </h2>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl border font-semibold">
                Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Flash --}}
            @if(session('error'))
                <div class="p-3 rounded-lg border" style="background:#fff3cd; border-color:#F9C74F;">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="p-3 rounded-lg border" style="background:#eafaf1; border-color:#2B2D42;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-5 border">
                    <div class="text-xs text-gray-500">Start Weight</div>
                    <div class="text-2xl font-bold">{{ number_format($startWeight, 2) }} kg</div>
                </div>
                <div class="bg-white rounded-xl p-5 border">
                    <div class="text-xs text-gray-500">Current Weight</div>
                    <div class="text-2xl font-bold">{{ number_format($currentWeight, 2) }} kg</div>
                </div>
                <div class="bg-white rounded-xl p-5 border">
                    <div class="text-xs text-gray-500">Target Weight</div>
                    <div class="text-2xl font-bold">{{ number_format($targetWeight, 2) }} kg</div>
                </div>
                <div class="bg-white rounded-xl p-5 border" style="border-color:#F9C74F;">
                    <div class="text-xs text-gray-500">Change</div>
                    <div class="text-2xl font-bold">{{ $changeText }}</div>
                    @if($toTargetText)
                        <div class="text-sm text-gray-500 mt-1">{{ $toTargetText }}</div>
                    @endif
                </div>
            </div>

            {{-- Form --}}
            <div class="bg-white rounded-xl p-6 border">
                <h3 class="text-lg font-semibold mb-4">
                    {{ $editEntry ? 'Edit Entry' : 'Add / Update Entry (One per day)' }}
                </h3>

                <form method="POST" action="{{ route('progress.store') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    @csrf

                    <div>
                        <label class="text-sm text-gray-600">Date</label>
                        <input type="date" name="date"
                               value="{{ old('date', $editEntry?->date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                               class="w-full rounded-lg border-gray-300">
                        @error('date') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Weight (kg)</label>
                        <input type="number" step="0.01" name="weight_kg"
                               value="{{ old('weight_kg', $editEntry?->weight_kg ?? '') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="e.g. 72.5">
                        @error('weight_kg') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Target (kg) (from profile)</label>
                        <input type="text" value="{{ number_format($targetWeight, 2) }}" readonly
                               class="w-full rounded-lg border-gray-200 bg-gray-50">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Calories Burned</label>
                        <input type="number" name="calories_burned"
                               value="{{ old('calories_burned', $editEntry?->calories_burned ?? '') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="optional">
                        @error('calories_burned') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit"
                            class="px-6 py-2 rounded-xl font-semibold text-white"
                            style="background:#2B2D42;">
                        Save
                    </button>

                    <div class="md:col-span-5">
                        <label class="text-sm text-gray-600">Notes</label>
                        <input type="text" name="notes"
                               value="{{ old('notes', $editEntry?->notes ?? '') }}"
                               class="w-full rounded-lg border-gray-300" placeholder="optional">
                        @error('notes') <div class="text-sm text-red-600 mt-1">{{ $message }}</div> @enderror
                    </div>
                </form>

                @if($editEntry)
                    <div class="mt-3 text-sm text-gray-500">
                        Editing entry ID: {{ $editEntry->id }} —
                        <a class="underline" href="{{ route('progress.index') }}">Cancel edit</a>
                    </div>
                @endif
            </div>

            {{-- Chart --}}
            <div class="bg-white rounded-xl p-6 border">
                <h3 class="text-lg font-semibold mb-3">Weight Graph</h3>
                <canvas id="progressChart" height="90"></canvas>
            </div>

            {{-- History --}}
            <div class="bg-white rounded-xl p-6 border">
                <h3 class="text-lg font-semibold mb-3">History</h3>

                @if($entries->isEmpty())
                    <div class="text-gray-600">No progress entries yet.</div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                            <tr class="text-left text-gray-600 border-b">
                                <th class="py-2">Date</th>
                                <th class="py-2">Weight</th>
                                <th class="py-2">Target</th>
                                <th class="py-2">Calories</th>
                                <th class="py-2">Notes</th>
                                <th class="py-2">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entries as $e)
                                <tr class="border-b">
                                    <td class="py-2">{{ $e->date->format('Y-m-d') }}</td>
                                    <td class="py-2">{{ number_format($e->weight_kg, 2) }} kg</td>
                                    <td class="py-2">{{ $e->target_weight_kg ? number_format($e->target_weight_kg, 2) . ' kg' : '—' }}</td>
                                    <td class="py-2">{{ $e->calories_burned ?? '—' }}</td>
                                    <td class="py-2">{{ $e->notes ?? '—' }}</td>
                                    <td class="py-2 flex gap-2">
                                        <a class="underline" href="{{ route('progress.index', ['edit' => $e->id]) }}">Edit</a>

                                        <form method="POST" action="{{ route('progress.destroy', $e) }}"
                                              onsubmit="return confirm('Delete this entry?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="underline text-red-600" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels  = @json($chartLabels);
        const weights = @json($chartWeights);

        const ctx = document.getElementById('progressChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Weight (kg)',
                    data: weights,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</x-app-layout>
