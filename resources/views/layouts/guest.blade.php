<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'VitaPlan') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">


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
<body class="min-h-screen font-sans antialiased text-[var(--text)]"
      style="
        background:
          radial-gradient(900px 400px at 15% 10%, rgba(249,199,79,.18), transparent 60%),
          radial-gradient(700px 340px at 90% 15%, rgba(43,45,66,.08), transparent 55%),
          linear-gradient(#fff, #fff);
      ">

    {{-- Top brand bar --}}
    <header class="max-w-6xl mx-auto px-6 py-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-xl grid place-items-center font-black"
                 style="background: var(--primary); color: var(--accent); box-shadow: 0 10px 18px rgba(249,199,79,.35);">
                VP
            </div>
            <div>
                <div class="text-lg font-extrabold leading-tight">VitaPlan</div>
                <div class="text-sm" style="color: var(--muted);">Plan Better. Live Healthier</div>
            </div>
        </a>

        <nav class="flex items-center gap-3">
            <a href="{{ route('login') }}"
               class="px-4 py-2 rounded-xl font-semibold border bg-white hover:bg-gray-50"
               style="border-color: var(--border); color: var(--text);">
                Log in
            </a>
            <a href="{{ route('register') }}"
               class="px-4 py-2 rounded-xl font-semibold text-white hover:opacity-95"
               style="background: var(--accent);">
                Register
            </a>
        </nav>
    </header>

    {{-- Page content --}}
    <main class="max-w-6xl mx-auto px-6 pb-14">
        {{ $slot }}
    </main>

</body>
</html>
