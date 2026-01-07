<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'VitaPlan') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root{
                --primary: #F9C74F;   /* Soft Yellow */
                --bg: #FFFFFF;        /* White */
                --text: #2B2D42;      /* Dark Gray */
                --accent: #3A3A3A;    /* Charcoal */
                --border: #E9E9EF;
                --muted: #8D90A6;
                --ring: 0 0 0 6px rgba(249,199,79,.25);
            }
        </style>
    </head>
    <body class="font-sans text-[var(--text)] antialiased">
        <div class="min-h-screen flex items-center justify-center px-4 py-10"
             style="
                background:
                  radial-gradient(900px 400px at 15% 10%, rgba(249,199,79,.18), transparent 60%),
                  radial-gradient(700px 340px at 90% 15%, rgba(43,45,66,.08), transparent 55%),
                  linear-gradient(#fff, #fff);
             ">
            <div class="w-full max-w-md">
                <div class="mb-6 flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl grid place-items-center font-black"
                         style="background: var(--primary); color: var(--accent); box-shadow: 0 10px 18px rgba(249,199,79,.35);">
                        VP
                    </div>
                    <div>
                        <div class="text-lg font-extrabold leading-tight">VitaPlan</div>
                        <div class="text-sm" style="color: var(--muted);">Plan Better. Live Healthier</div>
                    </div>
                </div>

                <div class="bg-white border rounded-2xl shadow-xl"
                     style="border-color: var(--border); box-shadow: 0 18px 40px rgba(43,45,66,.12);">
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </div>

                <div class="mt-5 text-xs text-center" style="color: var(--muted);">
                    © {{ date('Y') }} VitaPlan
                </div>
            </div>
        </div>
    </body>
</html>
