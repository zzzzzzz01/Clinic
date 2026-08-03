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
        Schema::create('hospitalization_procedure_administrations', function (Blueprint $table) {
            $table->id();
        
            // hospitalization
            $table->unsignedBigInteger('hospitalization_id');
            $table->foreign('hospitalization_id', 'fk_hpa_hosp')
                  ->references('id')
                  ->on('hospitalizations')
                  ->cascadeOnDelete();
        
            // hospitalization_procedure
            $table->unsignedBigInteger('hospitalization_procedure_id');
            $table->foreign('hospitalization_procedure_id', 'fk_hpa_hosp_proc')
                  ->references('id')
                  ->on('hospitalization_procedures')
                  ->cascadeOnDelete();
        
            // patient
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id', 'fk_hpa_patient')
                  ->references('id')
                  ->on('patients')
                  ->cascadeOnDelete();
        
            // Kim bajardi
            $table->string('administered_by_type'); // doctor | nurse
            $table->unsignedBigInteger('administered_by_id');
        
            // Sana-vaqtlar
            $table->dateTime('administration_at')->nullable();
        
            // Status
            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('pending');
        
            // Izoh
            $table->text('notes')->nullable();
        
            $table->timestamps();
        
            // Polymorphic index
            $table->index(['administered_by_type', 'administered_by_id'], 'idx_hpa_performer');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_procedure_administrations');
    }
};
