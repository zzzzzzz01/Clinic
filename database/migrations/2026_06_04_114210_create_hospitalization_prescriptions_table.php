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
        Schema::create('hospitalization_prescriptions', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('hospitalization_id')
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignId('patient_id')
            ->constrained('patients')
            ->cascadeOnDelete();
        
            // Kim buyurdi (Doctor yoki Nurse)
            $table->unsignedBigInteger('prescribed_by_id');
            $table->string('prescribed_by_type'); // Doctor | Nurse
        
            $table->timestamp('prescribed_at')->nullable();
        
            $table->enum('reason', ['standard', 'emergency', 'verbal'])
                ->default('standard');
        
            $table->text('note')->nullable();
        
            $table->enum('status', ['active', 'stopped', 'cancelled'])
                ->default('active');
        
            $table->timestamp('stopped_at')->nullable();
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_prescriptions');
    }
};
