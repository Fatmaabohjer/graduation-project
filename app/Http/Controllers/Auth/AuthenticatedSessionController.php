<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = $request->user();

        // ✅ منع دخول المستخدم المعطّل
        if (!$user->is_active) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => 'Your account has been disabled. Please contact support.']);
        }

        // ✅ Log: Login
        app(\App\Services\ActivityLogger::class)->log(
            actorId: $user->id,
            userId: $user->id,
            action: 'login',
            description: 'User logged in',
            ipAddress: $request->ip()
        );

        // ✅ Redirect based on role
        if ($user->is_admin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        // ✅ Log: Logout (قبل ما نعمل logout)
        $user = $request->user();

        if ($user) {
            app(\App\Services\ActivityLogger::class)->log(
                actorId: $user->id,
                userId: $user->id,
                action: 'logout',
                description: 'User logged out',
                ipAddress: $request->ip()
            );
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
