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
        Schema::create('hospitalization_order_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospitalization_order_id');

            $table->enum('item_type', ['test', 'panel']);
            $table->unsignedBigInteger('item_id'); // test_id yoki panel_id

            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);

            $table->enum('status', [
                'pending',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->enum('order_type', [  
                'normal',
                'urgent',
                'emergency'
            ])->default('normal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitalization_order_items');
    }
};
