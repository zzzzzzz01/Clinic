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
        Schema::create('hospitalization_prescription_administrations', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('hospitalization_prescription_item_id')
                ->constrained('hospitalization_prescription_items', 'id', 'fk_presc_item')
                ->cascadeOnDelete();

            // YANGI: Slotga bog'lanish
            $table->foreignId('hospitalization_prescription_item_slot_id')
                ->constrained('hospitalization_prescription_item_slots', 'id', 'fk_hpa_item_slot')
                ->cascadeOnDelete();
        
            // Kim bajardi (Doctor yoki Nurse)
            $table->string('administered_by_type'); // Doctor | Nurse
            $table->unsignedBigInteger('administered_by_id');
        
            $table->timestamp('administered_at');
        
            $table->enum('status', ['given', 'stopped', 'delayed', 'skipped', 'resumed'])
                ->default('given');
        
            // $table->string('skip_reason')->nullable();
            $table->text('skip_reason')->nullable();
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_prescription_administrations');
    }
};
