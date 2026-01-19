<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('progress_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('date');

            $table->decimal('weight_kg', 5, 2);
            $table->decimal('target_weight_kg', 5, 2)->nullable();

            $table->integer('calories_burned')->nullable();
            $table->string('notes')->nullable();

            $table->timestamps();

            // كل مستخدم إدخال واحد في اليوم
            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_entries');
    }
};
