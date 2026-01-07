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
    Schema::create('meals', function (Blueprint $table) {
        $table->id();

        // Relation with plans
        $table->foreignId('plan_id')->constrained()->cascadeOnDelete();

        // Day of the week (1 = Monday, 7 = Sunday)
        $table->unsignedTinyInteger('day');

        // Meal type
        $table->string('meal_type'); 
        // breakfast | lunch | dinner | snack

        // Meal info
        $table->string('name');
        $table->unsignedSmallInteger('calories');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');  
    }
};
