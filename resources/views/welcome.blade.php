<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VitaPlan') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --primary: #F9C74F;
            --bg: #FFFFFF;
            --text: #2B2D42;
            --accent: #3A3A3A;
            --muted: #8D90A6;
            --border: #E9E9EF;
        }
    </style>
</head>
<body class="font-sans antialiased text-[var(--text)]">

<div class="min-h-screen"
     style="
        background:
          radial-gradient(900px 400px at 15% 10%, rgba(249,199,79,.18), transparent 60%),
          radial-gradient(700px 340px at 90% 15%, rgba(43,45,66,.08), transparent 55%),
          linear-gradient(#fff, #fff);
     ">
    <!-- Top bar -->
    <header class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl grid place-items-center font-black"
                 style="background: var(--primary); color: var(--accent); box-shadow: 0 10px 18px rgba(249,199,79,.35);">
                VP
            </div>
            <div>
                <div class="text-lg font-extrabold leading-tight">VitaPlan</div>
                <div class="text-sm" style="color: var(--muted);">Plan Better. Live Healthier</div>
            </div>
        </div>

        <nav class="flex items-center gap-3">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="px-4 py-2 rounded-xl font-semibold border bg-white"
                   style="border-color: var(--border); color: var(--text);">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="px-4 py-2 rounded-xl font-semibold border bg-white"
                   style="border-color: var(--border); color: var(--text);">
                    Log in
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 rounded-xl font-semibold text-white"
                   style="background: var(--accent);">
                    Register
                </a>
            @endauth
        </nav>
    </header>

    <!-- Hero -->
    <main class="max-w-6xl mx-auto px-6 pt-10 pb-16 grid lg:grid-cols-2 gap-10 items-center">
        <section>
            <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight tracking-tight">
                Your health plan, <span style="color: var(--accent);">made simple.</span>
            </h1>
            <p class="mt-4 text-base sm:text-lg" style="color: var(--muted); max-width: 55ch;">
                VitaPlan helps you build a routine with calorie-aware meal plans, home workouts, and progress tracking —
                tailored to your goal and lifestyle.
            </p>

            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ route('register') }}"
                   class="px-6 py-3 rounded-xl font-semibold text-white inline-flex items-center gap-2"
                   style="background: var(--accent); box-shadow: 0 14px 22px rgba(58,58,58,.18);">
                    <span class="inline-block h-2.5 w-2.5 rounded-full"
                          style="background: var(--primary); box-shadow: 0 0 0 4px rgba(249,199,79,.25);"></span>
                    Get Started
                </a>
                <a href="#features"
                   class="px-6 py-3 rounded-xl font-semibold border bg-white"
                   style="border-color: var(--border); color: var(--text);">
                    See Features
                </a>
            </div>

            <div class="mt-8 grid sm:grid-cols-3 gap-3">
                <div class="p-4 rounded-2xl border bg-white" style="border-color: var(--border);">
                    <div class="text-sm font-semibold" style="color: var(--muted);">Meals</div>
                    <div class="text-lg font-extrabold">Calorie plans</div>
                </div>
                <div class="p-4 rounded-2xl border bg-white" style="border-color: var(--border);">
                    <div class="text-sm font-semibold" style="color: var(--muted);">Workouts</div>
                    <div class="text-lg font-extrabold">At home</div>
                </div>
                <div class="p-4 rounded-2xl border bg-white" style="border-color: var(--border);">
                    <div class="text-sm font-semibold" style="color: var(--muted);">Progress</div>
                    <div class="text-lg font-extrabold">Track & improve</div>
                </div>
            </div>
        </section>

        <!-- Card -->
        <section class="bg-white border rounded-3xl p-6"
                 style="border-color: var(--border); box-shadow: 0 18px 40px rgba(43,45,66,.12);">
            <h2 class="text-xl font-extrabold">Quick Preview</h2>
            <p class="mt-2 text-sm" style="color: var(--muted);">
                Example of what users will do after signing up.
            </p>

            <div class="mt-5 space-y-3">
                <div class="p-4 rounded-2xl border" style="border-color: var(--border);">
                    <div class="font-semibold">BMI Recommendation</div>
                    <div class="text-sm" style="color: var(--muted);">
                        Enter height & weight → get BMI + simple advice.
                    </div>
                </div>
                <div class="p-4 rounded-2xl border" style="border-color: var(--border);">
                    <div class="font-semibold">Personal Plan</div>
                    <div class="text-sm" style="color: var(--muted);">
                        Meals + workouts matched to goal & difficulty.
                    </div>
                </div>
                <div class="p-4 rounded-2xl border" style="border-color: var(--border);">
                    <div class="font-semibold">Progress Tracking</div>
                    <div class="text-sm" style="color: var(--muted);">
                        Log weight & calories burned over time.
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('register') }}"
                   class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 rounded-xl font-semibold text-white"
                   style="background: var(--accent);">
                    <span class="inline-block h-2.5 w-2.5 rounded-full"
                          style="background: var(--primary); box-shadow: 0 0 0 4px rgba(249,199,79,.25);"></span>
                    Create your account
                </a>
            </div>
        </section>
    </main>

    <!-- Features -->
    <section id="features" class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid md:grid-cols-3 gap-4">
            <div class="p-6 rounded-3xl border bg-white" style="border-color: var(--border);">
                <div class="text-sm font-semibold" style="color: var(--muted);">Feature 01</div>
                <div class="text-lg font-extrabold mt-1">Meal Planner</div>
                <p class="text-sm mt-2" style="color: var(--muted);">
                    Choose meals with calories calculated to fit your needs.
                </p>
            </div>
            <div class="p-6 rounded-3xl border bg-white" style="border-color: var(--border);">
                <div class="text-sm font-semibold" style="color: var(--muted);">Feature 02</div>
                <div class="text-lg font-extrabold mt-1">Home Workouts</div>
                <p class="text-sm mt-2" style="color: var(--muted);">
                    Simple routines with videos you can follow at home.
                </p>
            </div>
            <div class="p-6 rounded-3xl border bg-white" style="border-color: var(--border);">
                <div class="text-sm font-semibold" style="color: var(--muted);">Feature 03</div>
                <div class="text-lg font-extrabold mt-1">Progress Log</div>
                <p class="text-sm mt-2" style="color: var(--muted);">
                    Track weight and burned calories — see your improvement.
                </p>
            </div>
        </div>
    </section>

    <footer class="max-w-6xl mx-auto px-6 pb-10 text-sm" style="color: var(--muted);">
        © {{ date('Y') }} VitaPlan — Plan Better. Live Healthier
    </footer>
</div>

</body>
</html>
