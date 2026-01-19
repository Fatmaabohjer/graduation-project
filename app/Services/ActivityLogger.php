<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogger
{
    public function log(?int $actorId, ?int $userId, string $action, ?string $description = null, ?string $ipAddress = null): void
    {
        ActivityLog::create([
            'actor_id'   => $actorId,
            'user_id'    => $userId,
            'action'     => $action,
            'description'=> $description,
            'ip_address' => $ipAddress,
        ]);
    }
}
