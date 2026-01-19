<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('workout_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('level')->nullable();                 // Beginner/Intermediate/Advanced
            $table->unsignedInteger('duration_minutes')->nullable();
            $table->string('video_url')->nullable();
            $table->string('goal_type')->nullable();             // lose/gain/maintain/general
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_templates');
    }
};
