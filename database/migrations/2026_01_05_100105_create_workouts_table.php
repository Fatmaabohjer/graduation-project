<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('workouts', function (Blueprint $table) {
        $table->id();

        // Relation with plans
        $table->foreignId('plan_id')->constrained()->cascadeOnDelete();

        // Day of the week (1..7)
        $table->unsignedTinyInteger('day');

        // Workout info
        $table->string('name'); // e.g., Push-ups, Walking, Yoga
        $table->unsignedSmallInteger('duration_minutes')->nullable(); // e.g., 20
        $table->string('level')->nullable(); // Beginner / Intermediate / Advanced
        $table->string('video_url')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
        
    }
};
