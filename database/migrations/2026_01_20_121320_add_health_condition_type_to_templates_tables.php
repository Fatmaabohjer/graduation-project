<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('meal_templates', 'health_condition_type')) {
                $table->string('health_condition_type')->nullable()->after('goal_type');
            }
        });

        Schema::table('workout_templates', function (Blueprint $table) {
            if (!Schema::hasColumn('workout_templates', 'health_condition_type')) {
                $table->string('health_condition_type')->nullable()->after('goal_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('meal_templates', function (Blueprint $table) {
            if (Schema::hasColumn('meal_templates', 'health_condition_type')) {
                $table->dropColumn('health_condition_type');
            }
        });

        Schema::table('workout_templates', function (Blueprint $table) {
            if (Schema::hasColumn('workout_templates', 'health_condition_type')) {
                $table->dropColumn('health_condition_type');
            }
        });
    }
};
