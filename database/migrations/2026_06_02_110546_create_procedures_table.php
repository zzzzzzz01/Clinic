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
        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz'); // Bog‘lash, Massaj, Fizioterapiya
            $table->string('name_ru'); // Bog‘lash, Massaj, Fizioterapiya
            $table->string('name_en'); // Bog‘lash, Massaj, Fizioterapiya 
            $table->string('category'); // Bog‘lash, Massaj, Fizioterapiya
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->integer('price');
            $table->integer('duration');
            $table->text('description_uz')->nullable(); // ixtiyoriy izoh
            $table->text('description_ru')->nullable(); // ixtiyoriy izoh
            $table->text('description_en')->nullable(); // ixtiyoriy izoh
            $table->boolean('is_active')->default(true); // faol / nofaol
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
