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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('appointment_slot_id')->constrained('appointment_slots')->cascadeOnDelete();
            $table->date('date');
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['booked', 'completed',  'cancelled' ])->default('booked'); 
            $table->string('treatment_type')->nullable(); 
            $table->unique(['doctor_id','appointment_slot_id','date']);
            $table->integer('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
