<x-guest-layout>
    <div class="min-h-[70vh] grid place-items-center">
        <div class="w-full max-w-md bg-white border rounded-3xl p-7"
             style="border-color: var(--border); box-shadow: 0 18px 40px rgba(43,45,66,.12);">

            <h1 class="text-2xl font-extrabold text-gray-900">Create your account</h1>
            <p class="mt-1 text-sm" style="color: var(--muted);">
                Join VitaPlan and start building your plan today.
            </p>

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                    <input id="name"
                           type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           autofocus
                           autocomplete="name"
                           class="mt-2 w-full rounded-2xl border px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-amber-300/60 focus:border-amber-300"
                           style="border-color: var(--border);">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input id="email"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
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
                           autocomplete="new-password"
                           class="mt-2 w-full rounded-2xl border px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-amber-300/60 focus:border-amber-300"
                           style="border-color: var(--border);">
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                    <input id="password_confirmation"
                           type="password"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           class="mt-2 w-full rounded-2xl border px-4 py-3 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-amber-300/60 focus:border-amber-300"
                           style="border-color: var(--border);">
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 rounded-2xl font-semibold text-white
                               hover:opacity-95 focus:outline-none focus:ring-2 focus:ring-gray-900/20"
                        style="background: var(--accent); box-shadow: 0 14px 22px rgba(58,58,58,.18);">
                    Register
                </button>

                <p class="text-center text-sm" style="color: var(--muted);">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color: var(--accent);">
                        Log in
                    </a>
                </p>
            </form>

        </div>
    </div>
</x-guest-layout>
