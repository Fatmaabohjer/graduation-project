<x-guest-layout>
    <div class="min-h-[70vh] grid place-items-center">
        <div class="w-full max-w-md bg-white border rounded-3xl p-7"
             style="border-color: var(--border); box-shadow: 0 18px 40px rgba(43,45,66,.12);">

            <h1 class="text-2xl font-extrabold text-gray-900">Welcome back</h1>
            <p class="mt-1 text-sm" style="color: var(--muted);">
                Log in to continue to your dashboard.
            </p>

            @if (session('status'))
                <div class="mt-4 rounded-2xl px-4 py-3 text-sm bg-emerald-50 text-emerald-800 border border-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           class="mt-2 w-full rounded-2xl border px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-amber-300/60 focus:border-amber-300"
                           style="border-color: var(--border);">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input id="password"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="mt-2 w-full rounded-2xl border px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-amber-300/60 focus:border-amber-300"
                           style="border-color: var(--border);">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                        <input type="checkbox"
                               name="remember"
                               class="rounded border-gray-300 text-amber-500 focus:ring-amber-300">
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm font-semibold hover:underline"
                           style="color: var(--accent);">
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl font-semibold text-white
                               hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-gray-900/20"
                        style="background: var(--accent); box-shadow: 0 14px 22px rgba(58,58,58,.18);">
                    Log in
                </button>

                <p class="text-center text-sm" style="color: var(--muted);">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color: var(--accent);">
                        Register
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
