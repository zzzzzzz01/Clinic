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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();

            $table->string('name'); 
            $table->string('code')->unique();
            $table->string('unit')->nullable(); 
            $table->decimal('normal_min', 8, 2)->nullable();
            $table->decimal('normal_max', 8, 2)->nullable();
            $table->integer('price');
            $table->integer('duration'); 
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
