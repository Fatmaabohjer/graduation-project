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
    Schema::create('fitness_users', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->integer('age')->nullable();
        $table->float('weight')->nullable();
        $table->float('height')->nullable();
        $table->float('target_weight')->nullable();
        $table->string('goal_type')->nullable();
        $table->string('health_condition_type')->nullable();

        $table->timestamps();
    });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitness_users');
    }
};
