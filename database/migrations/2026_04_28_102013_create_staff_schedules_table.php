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
        Schema::create('staff_schedules', function (Blueprint $table) {
            $table->id();

            // Polymorphic ustunlar
            $table->morphs('schedulable'); 
            // schedulable_id
            // schedulable_type

            $table->foreignId('day_id')
                  ->constrained('days')
                  ->cascadeOnDelete();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->time('lunch_start')->nullable();
            $table->time('lunch_end')->nullable();

            $table->integer('appointment_duration')->nullable();
            $table->boolean('is_working')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_schedules');
    }
};
