<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fitness_users', function (Blueprint $table) {
            $table->string('dietary_condition')->nullable()->after('health_condition_type');
        });
    }

    public function down(): void
    {
        Schema::table('fitness_users', function (Blueprint $table) {
            $table->dropColumn('dietary_condition');
        });
    }
};
