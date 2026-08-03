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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('hospitalization_order_item_id');
            $table->unsignedBigInteger('test_id');

            $table->string('value')->nullable();

            $table->string('unit')->nullable();
            $table->decimal('normal_min', 8, 2)->nullable();
            $table->decimal('normal_max', 8, 2)->nullable();

            $table->enum('status', [
                'pending',
                'ready',
                'expired',
                'cancelled',
            ])->default('pending');

            $table->timestamp('resulted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
