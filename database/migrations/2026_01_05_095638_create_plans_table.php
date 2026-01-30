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
    Schema::create('plans', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        $table->unsignedSmallInteger('calories_target')->nullable(); 
        $table->decimal('bmi', 4, 1)->nullable(); 
        $table->string('goal_type')->nullable(); 

        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
