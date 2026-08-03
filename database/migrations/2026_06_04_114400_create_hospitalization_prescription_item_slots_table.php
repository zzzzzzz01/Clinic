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
        Schema::create('hospitalization_prescription_item_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospitalization_prescription_item_id')
                  ->constrained('hospitalization_prescription_items', 'id', 'fk_hpa_presc_item')
                  ->onDelete('cascade');
            
            $table->datetime('scheduled_at'); // Qachon berilishi kerak
            $table->enum('status', ['pending', 'given', 'skipped', 'stopped', 'resumed'])
                  ->default('pending');
            
            $table->string('skip_reason')->nullable(); // Sabab
            $table->string('administered_by_type')->nullable(); // Doctor, Nurse
            $table->unsignedBigInteger('administered_by_id')->nullable();
            $table->timestamp('administered_at')->nullable(); // Haqiqiy berilgan vaqt
            
            $table->integer('slot_order'); // Qaysi navbatda (1, 2, 3...)
            
            $table->timestamps();
            
            // $table->index(['hospitalization_prescription_item_id', 'scheduled_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_prescription_item_slots');
    }
};
