<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('workout_templates', function (Blueprint $table) {
            $table->string('health_condition_type')->nullable()->after('goal_type');
        });
    }

    public function down(): void
    {
        Schema::table('workout_templates', function (Blueprint $table) {
            $table->dropColumn('health_condition_type');
        });
    }
};
