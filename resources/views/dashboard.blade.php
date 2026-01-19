<x-app-layout>
    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4">

            <div class="mb-6">
                <h1 class="text-2xl font-bold" style="color:#2B2D42;">Dashboard</h1>
                <p class="text-sm text-gray-600">VitaPlan • Plan Better. Live Healthier</p>
            </div>

            <div class="p-6 rounded-2xl border border-gray-200 bg-white mb-6"
                 style="background: linear-gradient(90deg, rgba(249,199,79,0.18), rgba(255,255,255,1));">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h2 class="text-xl font-bold" style="color:#2B2D42;">
                            Welcome back, {{ auth()->user()->name }} 👋
                        </h2>
                        <p class="text-gray-600">Your personalized health plans start here.</p>
                    </div>

                    <div class="flex gap-2 flex-wrap">
                        @if(!auth()->user()->fitnessProfile)
                            <a href="{{ route('profile.health.edit') }}"
                               class="px-4 py-2 rounded-xl font-semibold"
                               style="background:#F9C74F; color:#2B2D42;">
                                Complete Health Profile
                            </a>
                        @else
                            <form method="POST" action="{{ route('plan.generate') }}">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2 rounded-xl font-semibold"
                                        style="background:#3A3A3A; color:#FFFFFF;">
                                    Generate Plan
                                </button>
                            </form>

                            <a href="{{ route('plan.show') }}"
                               class="px-4 py-2 rounded-xl font-semibold border bg-white hover:bg-gray-50"
                               style="border-color:#2B2D42; color:#2B2D42;">
                                My Plan
                            </a>

                            <a href="{{ route('progress.index') }}"
                               class="px-4 py-2 rounded-xl font-semibold border bg-white hover:bg-gray-50"
                               style="border-color:#2B2D42; color:#2B2D42;">
                                Track Progress
                            </a>
                        @endif
                    </div>
                </div>

                {{-- flash messages --}}
                @if(session('error'))
                    <div class="mt-4 p-3 rounded-lg"
                         style="background:#fff3cd; border:1px solid #F9C74F; color:#2B2D42;">
                        ⚠️ {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mt-4 p-3 rounded-lg"
                         style="background:#eafaf1; border:1px solid #2B2D42; color:#2B2D42;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl border border-gray-200 bg-white">
                    <h3 class="text-lg font-semibold" style="color:#2B2D42;">Health Profile</h3>
                    <p class="text-gray-600 mt-1">
                        Add your age, weight, height, goal, and health conditions.
                    </p>

                    <a href="{{ route('profile.health.edit') }}"
                       class="inline-block mt-4 px-4 py-2 rounded-xl font-semibold"
                       style="background:#2B2D42;color:white;">
                        Go to Health Profile
                    </a>
                </div>

                <div class="p-6 rounded-2xl border border-gray-200 bg-white">
                    <h3 class="text-lg font-semibold" style="color:#2B2D42;">My Weekly Plan</h3>
                    <p class="text-gray-600 mt-1">
                        View your meals and workouts once generated.
                    </p>

                    <a href="{{ route('plan.show') }}"
                       class="inline-block mt-4 px-4 py-2 rounded-xl font-semibold"
                       style="background:#F9C74F;color:#2B2D42;">
                        Open My Plan
                    </a>
                </div>

                <div class="p-6 rounded-2xl border border-gray-200 bg-white">
                    <h3 class="text-lg font-semibold" style="color:#2B2D42;">Track Progress</h3>
                    <p class="text-gray-600 mt-1">
                        Log your weight over time and view your progress chart.
                    </p>

                    <a href="{{ route('progress.index') }}"
                       class="inline-block mt-4 px-4 py-2 rounded-xl font-semibold"
                       style="background:#3A3A3A;color:#FFFFFF;">
                        Open Progress
                    </a>
                </div>
            </div>

            <div class="mt-10 text-center text-sm text-gray-500">
                VitaPlan © {{ date('Y') }} • Primary: #F9C74F
            </div>

        </div>
    </div>
</x-app-layout>
