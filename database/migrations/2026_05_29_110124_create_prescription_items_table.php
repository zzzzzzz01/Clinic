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
        Schema::create('prescription_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prescription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->enum('frequency_type', ['daily','hourly','weekly','interval','once','as_needed']);
            $table->integer('frequency_value')->nullable(); 
            // $table->integer('interval_days')->nullable();   // interval uchun
            $table->decimal('dose_amount', 8, 2); 
            $table->integer('duration_days')->nullable();
            $table->text('usage_instructions'); // qanday ichiladi
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_items');
    }
};
