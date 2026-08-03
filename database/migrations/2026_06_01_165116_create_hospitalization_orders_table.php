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
        Schema::create('hospitalization_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospitalization_id');

            $table->foreignId('ordered_by') // doctor id
                ->constrained('doctors')
                ->cascadeOnDelete(); 

            $table->foreignId('ordered_to') // patient id
                ->constrained('patients')
                ->cascadeOnDelete();

            $table->timestamp('ordered_at')->nullable(); 

            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->enum('order_type', [  
                'normal',
                'urgent',
                'emergency'
            ])->default('normal');

            $table->decimal('total_price', 10, 2)->default(0);
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_orders');
    }
};
