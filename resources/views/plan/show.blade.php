<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Plan
            </h2>

            <div class="flex gap-2">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-xl font-semibold border"
                   style="border-color:#2B2D42; color:#2B2D42;">
                    Dashboard
                </a>

                <form method="POST" action="{{ route('plan.generate') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-xl font-semibold"
                            style="background:#3A3A3A; color:#fff;">
                        Generate Plan
                    </button>
                </form>

                <form method="POST" action="{{ route('plan.generateMeals') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-xl font-semibold"
                            style="background:#F9C74F; color:#2B2D42;">
                        Generate Meals
                    </button>
                </form>

                <form method="POST" action="{{ route('plan.generateWorkouts') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-xl font-semibold"
                            style="background:#F9C74F; color:#2B2D42;">
                        Generate Workouts
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash --}}
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg"
                     style="background:#fff3cd; border:1px solid #F9C74F; color:#2B2D42;">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg"
                     style="background:#eafaf1; border:1px solid #2B2D42; color:#2B2D42;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Plan Summary --}}
            <div class="bg-white shadow-sm rounded-xl p-6 mb-6">
                @if(!$plan)
                    <p class="text-gray-700">
                        No plan yet. Click <b>Generate Plan</b> to create one.
                    </p>
                @else
                    <div class="flex items-center justify-between gap-4 flex-wrap">
                        <div>
                            <div class="text-sm text-gray-500">Plan Period</div>
                            <div class="font-semibold">
                                {{ $plan->start_date }} → {{ $plan->end_date }}
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <div class="px-4 py-2 rounded-lg border" style="border-color:#F9C74F;">
                                <div class="text-xs text-gray-500">Calories Target</div>
                                <div class="font-semibold">{{ $plan->calories_target ?? '—' }}</div>
                            </div>
                            <div class="px-4 py-2 rounded-lg border">
                                <div class="text-xs text-gray-500">Goal</div>
                                <div class="font-semibold">{{ $plan->goal_type ?? '—' }}</div>
                            </div>
                            <div class="px-4 py-2 rounded-lg border">
                                <div class="text-xs text-gray-500">BMI</div>
                                <div class="font-semibold">{{ $plan->bmi ?? '—' }}</div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>



            <div class="flex gap-2 mb-4">
                <a href="{{ route('plan.show', ['tab' => 'meals']) }}"
                   class="px-3 py-2 rounded-lg border font-semibold {{ $tab === 'meals' ? 'bg-gray-900 text-white' : 'bg-white text-gray-800' }}">
                    Meals
                </a>
                <a href="{{ route('plan.show', ['tab' => 'workouts']) }}"
                   class="px-3 py-2 rounded-lg border font-semibold {{ $tab === 'workouts' ? 'bg-gray-900 text-white' : 'bg-white text-gray-800' }}">
                    Workouts
                </a>
            </div>

            {{-- Content --}}
            @if(!$plan)
                <div class="bg-white shadow-sm rounded-xl p-6">
                    Create a plan first.
                </div>
            @else

                @if($tab === 'meals')
                    <div class="bg-white shadow-sm rounded-xl p-6">
                        <h3 class="text-lg font-semibold mb-2">Meals (Weekly)</h3>
                        <p class="text-sm text-gray-500 mb-4">Generated meals for 7 days.</p>

                        @if($meals->isEmpty())
                            <div class="p-3 rounded-lg" style="background:#fff3cd; border:1px solid #F9C74F;">
                                No meals yet. Click <b>Generate Meals</b>.
                            </div>
                        @else
                            @foreach($mealsByDay as $day => $items)
                                <div class="border rounded-xl p-4 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="font-semibold">Day {{ $day }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $items->sum('calories') }} kcal
                                        </div>
                                    </div>

                                    @foreach($items as $m)
                                        <div class="flex justify-between py-2 border-t">
                                            <div>
                                                <div class="text-xs text-gray-500 uppercase">{{ $m->meal_type }}</div>
                                                <div class="font-semibold">{{ $m->name }}</div>
                                            </div>
                                            <div class="font-semibold">{{ $m->calories }} kcal</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                @else
                    <div class="bg-white shadow-sm rounded-xl p-6">
                        <h3 class="text-lg font-semibold mb-2">Workouts (Weekly)</h3>
                        <p class="text-sm text-gray-500 mb-4">Workouts with YouTube videos.</p>

                        @if($workouts->isEmpty())
                            <div class="p-3 rounded-lg" style="background:#fff3cd; border:1px solid #F9C74F;">
                                No workouts yet. Click <b>Generate Workouts</b>.
                            </div>
                        @else
                            @foreach($workoutsByDay as $day => $items)
                                <div class="border rounded-xl p-4 mb-4">
                                    <div class="font-semibold mb-2">Day {{ $day }}</div>

                                    @foreach($items as $w)
                                        <div class="py-2 border-t">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <div class="font-semibold">{{ $w->name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $w->level ?? '—' }} • {{ $w->duration_minutes ?? '—' }} min
                                                    </div>
                                                    @if($w->video_url)
                                                        <a href="{{ $w->video_url }}" target="_blank" class="text-sm underline">
                                                            Watch Video
                                                        </a>
                                                    @endif
                                                </div>

                                                <span class="px-3 py-1 rounded-full text-xs font-semibold"
                                                      style="background:#F9C74F; color:#2B2D42;">
                                                    Day {{ $day }}
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endif

            @endif

        </div>
    </div>
</x-app-layout>
