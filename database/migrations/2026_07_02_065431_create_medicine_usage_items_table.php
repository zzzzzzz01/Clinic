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
        Schema::create('medicine_usage_items', function (Blueprint $table) {
            $table->id();
        
            $table->foreignId('medicine_usage_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->foreignId('medicine_id')
                ->constrained()
                ->cascadeOnDelete();
        
            $table->string('unit');
        
            $table->integer('quantity');
        
            $table->decimal('price', 12, 2);
        
            $table->decimal('total_price', 12, 2);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_usage_items');
    }
};
