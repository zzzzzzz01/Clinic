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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name_uz');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('type_uz')->nullable();
            $table->string('type_ru')->nullable();
            $table->string('type_en')->nullable();
            $table->string('phone')->nullable(); // Aloqa ma'lumotlari
            $table->string('email')->nullable();
            $table->string('address')->nullable(); // Manzil
            $table->string('contact_person')->nullable();  // Mas'ul shaxs (kontakt)
            $table->text('description_uz')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
