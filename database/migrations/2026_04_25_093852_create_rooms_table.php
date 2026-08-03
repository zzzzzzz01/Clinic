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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); 
            $table->string('number'); 
            $table->foreignId('room_type_id')->constrained('room_types');
            $table->string('floor');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('capacity')->nullable(); 
            $table->string('price'); 
            $table->text('description_uz')->nullable();
            $table->text('description_ru')->nullable();
            $table->text('description_en')->nullable();
            $table->enum('status', ['empty', 'available', 'full', 'maintenance'])
                ->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
