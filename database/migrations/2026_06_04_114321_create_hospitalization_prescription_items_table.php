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
        Schema::create('hospitalization_prescription_items', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('hospitalization_prescription_id')
                ->constrained('hospitalization_prescriptions', 'id', 'fk_hosp_presc')
                ->cascadeOnDelete();
        
            $table->foreignId('medicine_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->enum('frequency_type', ['daily','hourly','weekly','interval','once','as_needed']);
            $table->integer('frequency_value')->nullable(); 
        
            $table->decimal('dose_amount', 8, 2); 
            $table->integer('duration_days')->nullable();
        
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
        
            $table->enum('status', ['active', 'stopped', 'completed', 'pending'])
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
        Schema::dropIfExists('hospitalization_prescription_items');
    }
};
