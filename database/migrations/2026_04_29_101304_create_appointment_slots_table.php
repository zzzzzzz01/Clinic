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
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->id();
            
            // Slot qaysi doctor_schedule asosida
            $table->foreignId('staff_schedule_id')
                  ->constrained('staff_schedules')
                  ->cascadeOnDelete();

            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');

            // Slot status: available / booked / archived / outside_schedule
            $table->string('status')->default('available');

            // // Agar slot band bo‘lsa, qaysi bemor
            $table->foreignId('patient_id')
                  ->nullable()
                  ->constrained('patients')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_slots');
    }
};
