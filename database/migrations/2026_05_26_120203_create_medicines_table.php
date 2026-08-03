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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('package_type');     // Qadoqlanish turi: quti, flakon, ampula
            $table->string('form'); // Dori shakli: tabletka, sirop, inyeksiya
            $table->foreignId('medicine_category_id')->constrained('category_medicines')->cascadeOnDelete();
            $table->integer('strength_value')->nullable(); // 500, 20, 1
            $table->string('strength_unit')->nullable();   // mg, ml, g, %, IU
            $table->integer('stock_boxes')->default(0);  // Hozir nechta quti bor (fizik)
            $table->integer('stock_units')->default(0);  // Hozir nechta dona bor (fizik)
            $table->integer('units_per_box');  // 1 qutida nechta birlik bor
            $table->integer('min_stock')->default(1);  // Kam qolganda ogohlantirish uchun
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->text('description_uz')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
