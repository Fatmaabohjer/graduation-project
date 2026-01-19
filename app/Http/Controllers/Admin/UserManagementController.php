<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function toggleActive(Request $request, User $user, ActivityLogger $logger): RedirectResponse
    {
        // ✅ منع الأدمن يعطّل نفسه بالغلط
        if ($request->user()->id === $user->id) {
            return back()->with('error', 'You cannot disable your own account.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        // ✅ Log
        $logger->log(
            actorId: $request->user()->id,
            userId: $user->id,
            action: $user->is_active ? 'user_enabled' : 'user_disabled',
            description: ($user->is_active ? 'Enabled' : 'Disabled') . " user: {$user->email}"
        );

        return back()->with('success', 'User status updated successfully ✅');
    }
}
