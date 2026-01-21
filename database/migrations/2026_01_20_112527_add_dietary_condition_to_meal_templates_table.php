<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_templates', function (Blueprint $table) {
            $table->string('dietary_condition')->nullable()->after('goal_type');
        });
    }

    public function down(): void
    {
        Schema::table('meal_templates', function (Blueprint $table) {
            $table->dropColumn('dietary_condition');
        });
    }
};
