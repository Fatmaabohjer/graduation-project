<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(Request $request): View
    {
        $logs = ActivityLog::query()
            ->with(['user:id,name,email', 'actor:id,name,email'])
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.logs.index', compact('logs'));
    }

    public function userLogs(Request $request, User $user): View
    {
        $logs = ActivityLog::query()
            ->where('user_id', $user->id)
            ->with(['actor:id,name,email'])
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.logs.user', compact('user', 'logs'));
    }
}
