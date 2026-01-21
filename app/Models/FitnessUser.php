<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FitnessUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'age',
        'weight',
        'height',
        'target_weight',
        'goal_type',

        // ✅ للتمارين (إصابات/ألم)
        'health_condition_type',

        // ✅ للوجبات (حساسية/سكري/قلوتين...)
        'dietary_condition',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
