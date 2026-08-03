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
        Schema::create('hospitalizations', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('appointment_id')->constrained()->cascadeOnDelete();
        
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->enum('urgency', ['normal', 'urgent', 'emergency'])->default('normal');
        
            $table->text('referral_reason');
        
            $table->enum('status', ['waiting_for_bed', 'under_treatment', 'ready_for_discharge', 'discharged', 'deceased'])->default('waiting_for_bed');
        
            $table->timestamp('admitted_at')->nullable();
            $table->timestamp('discharged_at')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalizations');
    }
};
