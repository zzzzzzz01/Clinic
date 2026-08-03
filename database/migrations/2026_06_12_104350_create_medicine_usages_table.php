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
        Schema::create('medicine_usages', function (Blueprint $table) {
            $table->id();
        
            $table->decimal('total_price', 12, 2);
        
            $table->string('payment_method')->nullable(); // cash, card, transfer, insurance
        
            $table->timestamp('given_at')->useCurrent();
        
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_usages');
    }
};
