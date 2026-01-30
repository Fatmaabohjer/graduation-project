<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'VitaPlan') }} - Your Health Plan, Made Simple</title>

    {{-- Tailwind via Vite (مش CDN) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font (Plus Jakarta Sans) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { box-sizing: border-box; }
        * { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
        .animate-float { animation: float 4s ease-in-out infinite; }

        .preview-card { box-shadow: 0 4px 40px -8px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.02); }
        .feature-card { box-shadow: 0 2px 20px -4px rgba(0,0,0,0.05); transition: all 0.3s ease; }
        .feature-card:hover { box-shadow: 0 8px 40px -8px rgba(0,0,0,0.1); transform: translateY(-4px); }
    </style>
</head>

<body class="h-full bg-[#FAFAFA] overflow-auto">
<div class="w-full min-h-full">

    {{-- Navigation --}}
    <nav class="w-full px-6 md:px-12 lg:px-20 py-5">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            {{-- Logo --}}
            <div class="flex items-center gap-2">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center bg-[#F5C543]">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L13.09 8.26L19 6L14.74 10.91L21 12L14.74 13.09L19 18L13.09 15.74L12 22L10.91 15.74L5 18L9.26 13.09L3 12L9.26 10.91L5 6L10.91 8.26L12 2Z"
                              fill="#1C1C1E"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-[#1C1C1E]">{{ config('app.name', 'VitaPlan') }}</span>
            </div>

            {{-- Nav Buttons --}}
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2.5 text-sm font-medium rounded-xl border border-black/10 bg-white text-[#1C1C1E] hover:bg-black/5 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2.5 text-sm font-medium rounded-xl text-[#1C1C1E] hover:bg-black/5 transition">
                        Log in
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2.5 text-sm font-medium text-white rounded-xl bg-[#1C1C1E] hover:opacity-90 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <main class="w-full px-6 md:px-12 lg:px-20 py-12 md:py-20">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                {{-- Left Side - Hero Text --}}
                <div class="space-y-8 opacity-0 animate-fade-in-up">
                    <div class="space-y-5">
                        <h1 class="text-4xl md:text-5xl lg:text-[56px] font-extrabold leading-tight tracking-tight text-[#1C1C1E]">
                            Your health plan, made simple.
                        </h1>
                        <p class="text-lg md:text-xl leading-relaxed max-w-lg text-gray-500">
                            Build calorie-aware meal plans, home workouts, and track your progress — all in one place.
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}"
                           class="px-7 py-4 text-white font-semibold rounded-2xl bg-[#1C1C1E] transition-all hover:opacity-90 hover:scale-[1.02] active:scale-[0.98]">
                            Get Started
                        </a>

                        <a href="#features"
                           class="px-7 py-4 font-semibold rounded-2xl border-2 border-[#1C1C1E] text-[#1C1C1E] transition-all hover:bg-gray-50 active:scale-[0.98]">
                            See Features
                        </a>
                    </div>
                </div>

                {{-- Right Side - Preview Card --}}
                <div class="opacity-0 animate-fade-in-up animate-delay-2">
                    <div class="preview-card rounded-3xl p-6 md:p-8 bg-white animate-float">

                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-[#F5C543]">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                          stroke="#1C1C1E" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-[#1C1C1E]">Quick Preview</h2>
                        </div>

                        <div class="space-y-4 mb-6">

                            <div class="p-4 rounded-2xl bg-[#FAFAFA] hover:bg-black/5 transition">
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#F5C543]">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2V6M12 18V22M6 12H2M22 12H18M19.07 4.93L16.24 7.76M7.76 16.24L4.93 19.07M19.07 19.07L16.24 16.24M7.76 7.76L4.93 4.93"
                                                  stroke="#1C1C1E" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold mb-1 text-[#1C1C1E]">BMI Recommendation</h3>
                                        <p class="text-sm text-gray-500">Height & weight → BMI + personalized advice</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-[#FAFAFA] hover:bg-black/5 transition">
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#F5C543]">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 5H7C5.89543 5 5 5.89543 5 7V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V7C19 5.89543 18.1046 5 17 5H15M9 5C9 6.10457 9.89543 7 11 7H13C14.1046 7 15 6.10457 15 5M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5"
                                                  stroke="#1C1C1E" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold mb-1 text-[#1C1C1E]">Personal Plan</h3>
                                        <p class="text-sm text-gray-500">Meals & workouts tailored to your goal</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-[#FAFAFA] hover:bg-black/5 transition">
                                <div class="flex items-start gap-4">
                                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 bg-[#F5C543]">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16 8V16M12 11V16M8 14V16M6 20H18C19.1046 20 20 19.1046 20 18V6C20 4.89543 19.1046 4 18 4H6C4.89543 4 5 4.89543 5 6V18C5 19.1046 4.89543 20 6 20Z"
                                                  stroke="#1C1C1E" stroke-width="2" stroke-linecap="round"
                                                  stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold mb-1 text-[#1C1C1E]">Progress Tracking</h3>
                                        <p class="text-sm text-gray-500">Weight & calories visualized over time</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('register') }}"
                           class="w-full block text-center py-4 text-white font-semibold rounded-2xl bg-[#1C1C1E] transition-all hover:opacity-90 hover:scale-[1.01] active:scale-[0.99]">
                            Create your account
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- Feature Cards Section --}}
    <section id="features" class="w-full px-6 md:px-12 lg:px-20 py-12 md:py-16">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-3 gap-6">

                <div class="feature-card rounded-3xl p-6 md:p-8 bg-white opacity-0 animate-fade-in-up animate-delay-2">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 bg-[#F5C543]">
                        <span class="text-[#1C1C1E] font-bold">🍽</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-[#1C1C1E]">Meal Planner</h3>
                    <p class="leading-relaxed text-gray-500">Smart meal suggestions based on your calorie goals and dietary preferences.</p>
                </div>

                <div class="feature-card rounded-3xl p-6 md:p-8 bg-white opacity-0 animate-fade-in-up animate-delay-3">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 bg-[#F5C543]">
                        <span class="text-[#1C1C1E] font-bold">🏋️</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-[#1C1C1E]">Home Workouts</h3>
                    <p class="leading-relaxed text-gray-500">Equipment-free exercise routines designed for any fitness level.</p>
                </div>

                <div class="feature-card rounded-3xl p-6 md:p-8 bg-white opacity-0 animate-fade-in-up animate-delay-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 bg-[#F5C543]">
                        <span class="text-[#1C1C1E] font-bold">📈</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-[#1C1C1E]">Progress Tracking</h3>
                    <p class="leading-relaxed text-gray-500">Visual charts and insights to keep you motivated on your journey.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="w-full px-6 md:px-12 lg:px-20 py-8 border-t border-gray-100">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-400">© {{ date('Y') }} {{ config('app.name','VitaPlan') }}. All rights reserved.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="text-sm text-gray-500 hover:opacity-70 transition">Privacy</a>
                <a href="#" class="text-sm text-gray-500 hover:opacity-70 transition">Terms</a>
                <a href="#" class="text-sm text-gray-500 hover:opacity-70 transition">Contact</a>
            </div>
        </div>
    </footer>

</div>
</body>
</html>
